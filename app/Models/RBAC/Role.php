<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'sort',
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\RBAC\Permission');
    }
}
