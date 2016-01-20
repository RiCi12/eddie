<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
{

    use DatabaseTransactions;

    public function testCreation()
    {
        $newProject = new \eddie\Models\Project();
        $newProject->name = "There are some space";
        $newProject->save();
        $this->assertEquals(str_replace(' ', '', strtolower($newProject->name)), $newProject->schema_name);
        $this->seeInDatabase('projects', ['name' => $newProject->name]);
    }
}
