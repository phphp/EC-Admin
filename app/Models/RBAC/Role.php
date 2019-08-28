<?php

namespace App\Models\RBAC;

use App\Models\RBAC\Base;
use Illuminate\Database\Eloquent\Model;

class Role extends Base
{
    protected $fillable = [
        'name',
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\RBAC\Permission');
    }

    public function admins()
    {
        return $this->belongsToMany('App\Models\Admin');
    }
}
