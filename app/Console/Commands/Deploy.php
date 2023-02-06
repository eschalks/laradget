<?php

namespace App\Console\Commands;

use Assert\Assertion;
use Illuminate\Console\Command;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\PhpseclibV3\SftpAdapter;
use League\Flysystem\PhpseclibV3\SftpConnectionProvider;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use phpseclib3\Crypt\RSA;
use phpseclib3\Net\SSH2;
use Symfony\Component\Process\Process;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        preg_match('/(\S+)@(\S+):(\d+)/', env('SSH_CONNECTION'), $matches);

        [, $username, $host, $port] = $matches;

        $this->output->writeln('Building static assets...');
        $vite = new Process(['pnpm', 'build'], base_path());
        Assertion::same($vite->run(function ($type, $data) {
            $this->output->writeln($data);
        }), self::SUCCESS);

        $publicFs = new Filesystem(new LocalFilesystemAdapter(public_path()));
        Assertion::true($publicFs->directoryExists('build'));

        try {

            $ssh        = new SSH2($host, $port);
            $privateKey = RSA::loadPrivateKey(file_get_contents(env('SSH_KEY')));
            $ssh->login($username, $privateKey);

            $this->output->writeln($ssh->exec('cd laradget && git pull && sh build.sh'));

            $sftpConnectionProvider = new SftpConnectionProvider($host, $username, privateKey: $privateKey,
                port:                                            $port,);
            $sftpAdapter            = new SftpAdapter($sftpConnectionProvider, 'laradget/public', PortableVisibilityConverter::fromArray([
                'file' => [
                    'public' => 0655,
                ],
                'dir' => [
                    'public' => 0755,
                ]
                                                                                                                                         ]));
            $sftpFs                 = new Filesystem($sftpAdapter);

            $sftpFs->deleteDirectory('build');

            $this->output->progressStart();
            $this->copyFiles($publicFs, $sftpFs, 'build');
            $this->output->progressFinish();
        }
        finally {
            $publicFs->deleteDirectory('build');
        }

        return Command::SUCCESS;
    }

    private function copyFiles(Filesystem $from, Filesystem $to, string $path): void
    {
        /** @var \League\Flysystem\StorageAttributes $file */
        foreach ($from->listContents($path) as $file) {
            $filePath = $file->path();
            if ($file->isDir()) {
                $this->copyFiles($from, $to, $filePath);
                continue;
            }

            $fileStream = $from->readStream($filePath);
            $to->writeStream($filePath, $fileStream, [
                'visibility' => 'public',
                'directory_visibility' => 'public',
            ]);
            $this->output->progressAdvance();
        }
    }
}
