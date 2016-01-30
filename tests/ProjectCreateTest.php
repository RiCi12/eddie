<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectCreateTest extends TestCase
{
    /**
     * Simple creation test
     *
     * @return  \eddie\Models\Project
     *
     */
    public function testCreation()
    {
        $newProject = new \eddie\Models\Project();
        $newProject->name = $this->testSchemaName;
        $newProject->save();
        \Pacuna\Schemas\Facades\PGSchema::switchTo();//Going back to the default schema, where "projects" table lives
        $this->assertEquals(str_replace(' ', '', strtolower($newProject->name)), $newProject->schema_name);
        $this->seeInDatabase('projects', ['name' => $newProject->name]);

        return $newProject;
    }

    /**
     * Check if the schema was created after the Project creation.
     *
     * @param \eddie\Models\Project $newProject
     *
     * @depends testCreation
     */
    public function testSchemaCreated(\eddie\Models\Project $newProject)
    {
        $schemas = \Illuminate\Support\Facades\DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '".$newProject->schema_name."';");
        $this->assertEquals(1, count($schemas));
    }

    /**
     * Test the unique constraint on the schema_name of project.
     *
     * @param $project
     *
     * @depends testCreation
     *
     * @expectedException PDOException
     */
    public function testUniqueSchemaName($project)
    {
        $newProject = new \eddie\Models\Project();
        $newProject->name = str_replace(' ', '', strtolower($project->name));
        $newProject->save();
    }

    /**
     * Switch to the newly created schema.
     *
     * @param $project
     *
     */
    public function tearDown()
    {
        \Pacuna\Schemas\Facades\PGSchema::switchTo($this->testSchemaName);
    }

}
