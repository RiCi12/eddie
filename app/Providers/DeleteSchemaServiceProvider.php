<?php

namespace eddie\Providers;

use eddie\Models\Project;
use Illuminate\Support\ServiceProvider;
use Pacuna\Schemas\Facades\PGSchema;

class DeleteSchemaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Project::deleting(function(Project $project) {
            PGSchema::switchTo();
            PGSchema::drop($project->schema_name);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
