<?php

namespace eddie\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = ['name'];

    /**
     * Mutator to set the name of the schema_name when the name attribute is set.
     *
     * @param $value    String    The name of the project.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['schema_name'] = str_replace(' ', '', strtolower($value));
        $this->attributes['name'] = $value;
    }

}
