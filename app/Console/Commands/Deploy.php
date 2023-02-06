<?php

namespace App\Console\Commands;

use Assert\Assertion;
use Illuminate\Console\Command;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use phpseclib3\Crypt\RSA;
use phpseclib3\Net\SFTP;
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

            $ssh = new SSH2($host, $port);
            $privateKey = RSA::loadPrivateKey(file_get_contents(env('SSH_KEY')));
            $ssh->login($username, $privateKey);

            $this->output->writeln($ssh->exec('cd laradget && git pull && sh build.sh'));

            $sftp = new SFTP($host, $port);
            $sftp->login($username, $privateKey);
            $sftp->delete('laradget/public/build');

            $this->output->progressStart();
            $this->copyFiles($publicFs, $sftp, 'build');
            $this->output->progressFinish();

        }
        finally {
            $publicFs->deleteDirectory('build');
        }

        return Command::SUCCESS;
    }

    private function copyFiles(Filesystem $publicFs, SFTP $sftp, string $path): void
    {
        /** @var \League\Flysystem\StorageAttributes $file */
        foreach ($publicFs->listContents($path) as $file) {
            $filePath = $file->path();
            if ($file->isDir()) {
                $this->copyFiles($publicFs, $sftp, $filePath);
                continue;
            }

            $fileStream = $publicFs->readStream($filePath);
            $sftp->put("laradget/public/$filePath", $fileStream);
            fclose($fileStream);
            $this->output->progressAdvance();
        }
    }
}
