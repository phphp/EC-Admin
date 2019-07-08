<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name', 'action', 'uri', 'sort'
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\RBAC\Role');
    }
}
