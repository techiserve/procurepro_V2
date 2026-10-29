<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $database = $app['config']->get('database');
        if (
            $database['default'] !== 'sqlite'
            || $database['connections']['sqlite']['database'] !== ':memory:'
            || ! empty($database['connections']['sqlite']['url'])
        ) {
            throw new \RuntimeException('Feature tests require an in-memory SQLite database. Refusing to use the configured database.');
        }

        return $app;
    }
}
