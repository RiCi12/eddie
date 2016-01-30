<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActorTest extends TestCase
{

    /**
     * Simple creation test.
     *
     * @return Actor
     */
    public function testCreation()
    {
        $newActor = factory(\eddie\Models\Actor::class)->make();
        $newActor->save();
        $this->seeInDatabase('actors', ['name' => $newActor->name,'description' => $newActor->description]);

        return $newActor;
    }

    /**
     * Test the parent relation between actor objects.
     *
     * @param $actor    \eddie\Models\Actor
     *
     * @return  ArrayObject
     *
     * @depends testCreation
     */
    public function testParentRelation($actor)
    {
        $newSon = factory(\eddie\Models\Actor::class)->make();
        $newSon->parent()->associate($actor);
        $newSon->save();

        $this->assertEquals($actor->id, $newSon->parent_id);
        $this->assertEquals($newSon->id, $actor->sons->get('0')->id);

        return ['parent' => $actor, 'son' => $newSon];
    }

    /**
     * Test the OnDelete property of relation between parent and son Actor.
     *
     * @param $actors   ArrayObject
     *
     * @depends testParentRelation
     */
    public function testOnDeleteProperty($actors)
    {
        $actors['parent']->delete();

        $this->notSeeInDatabase('actors', ['id' => $actors['son']->id]);
    }

    /**
     * Simple refuses creation test.
     *
     * @expectedException PDOException
     */
    public function testRefuseCreation()
    {
        $newActor = new \eddie\Models\Actor();
        $newActor->save();
    }
}
