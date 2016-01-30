<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * Name of the schema used for testing purposes.
     *
     * @var string
     */
    protected $testSchemaName = "SchemaTestName";

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
