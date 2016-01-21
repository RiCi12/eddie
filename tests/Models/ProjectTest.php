<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
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
        $newProject->name = "There are some space";
        $newProject->save();
        $this->assertEquals(str_replace(' ', '', strtolower($newProject->name)), $newProject->schema_name);
        $this->seeInDatabase('projects', ['name' => $newProject->name]);

        return $newProject;
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
     * Test the delete of a Project entry.
     *
     * @param $project  \eddie\Models\Project
     *
     * @depends testCreation
     *
     */
    public function testDeleteProject($project)
    {
        $project->delete();
        $this->notSeeInDatabase('projects', ['id' => $project->id]);
    }

}
