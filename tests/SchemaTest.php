<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SchemaTest extends TestCase
{

    public function testSchemaCreation()
    {
        $schemaName = "testname";
        Pacuna\Schemas\Facades\PGSchema::create($schemaName);

        $schemas = \Illuminate\Support\Facades\DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '".$schemaName."';");
        $this->assertEquals(1, count($schemas));

        return $schemaName;
    }

    /**
     * @depends testSchemaCreation
     */
    public function testDropSchema($schemaName)
    {
        Pacuna\Schemas\Facades\PGSchema::drop($schemaName);

        $schemas = \Illuminate\Support\Facades\DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '".$schemaName."';");
        $this->assertEquals(0, count($schemas));
    }

}
