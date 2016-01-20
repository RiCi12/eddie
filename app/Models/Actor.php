<?php

namespace eddie\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = ['name', 'description', 'parent_id'];

    /**
     * Get the parent Actor object, if any.
     *
     * @return  Actor
     */
    public function parent()
    {
        return $this->belongsTo(Actor::class, 'parent_id', 'id');
    }

    /**
     * Get the Actor objects (if any) inherited from this Actor model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sons()
    {
        return $this->hasMany(Actor::class, 'parent_id', 'id');
    }
}
