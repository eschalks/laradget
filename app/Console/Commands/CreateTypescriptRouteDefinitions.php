<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;

class CreateTypescriptRouteDefinitions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ts:route-definitions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the routes.d.ts for type hinting routes in the frontend.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Router $router)
    {
        $file = fopen(resource_path('js/generated/routes.d.ts'), 'wb');
        $routesPerParameterCount = Collection::wrap($router->getRoutes()->getRoutes())
            ->filter(fn(Route $route) => $route->getName() !== null)
            ->groupBy(fn(Route $route) => count($route->parameterNames()));



        foreach ($routesPerParameterCount as $parameterCount => $routes) {
            $routeNames = $routes->map(fn(Route $route) => "'{$route->getName()}'")
                   ->implode(' | ');

            fwrite($file, "declare function route(name: $routeNames");

            if ($parameterCount > 0) {
                fwrite($file, $this->createParametersDefinition($parameterCount));
            }

            fwrite($file, "): string;\n");
        }

        fclose($file);

        return Command::SUCCESS;
    }


    private function createParametersDefinition(int $parameterCount): string
    {
        $parameters = Collection::times($parameterCount)
                                ->map(fn(int $index) => "number")
                                ->implode(', ');

        return ", parameters: [$parameters]";
    }
}
