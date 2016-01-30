<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectDeleteTest extends TestCase
{

    /**
     * When a Project object is deleted, the associated database schema is deleted too.
     *
     */
    public function testDeleteSchema()
    {
        $project = \eddie\Models\Project::where(['name' => $this->testSchemaName])->first();

        $schemaName = $project->schema_name;

        $project->delete();

        $this->notSeeInDatabase('projects', ['name' => $project->name]);

        $schemas = \Illuminate\Support\Facades\DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '".$schemaName."';");
        $this->assertEquals(0, count($schemas));
    }
}
