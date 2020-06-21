<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Model\Permission')->withTimestamps();
    }
}