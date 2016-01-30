<?php

namespace eddie\Providers;

use eddie\Models\Project;
use Illuminate\Support\ServiceProvider;
use Pacuna\Schemas\Facades\PGSchema;

class CreateSchemaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Project::created(function(Project $project) {
            PGSchema::create($project->schema_name);
            PGSchema::migrate($project->schema_name, ["--path" => "eddie/database/migations/schemamigrations"]);
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
