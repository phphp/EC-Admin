<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;

/**
 * RBAC 功能的基类，提供一些方法
 */
class Base extends Model
{
    public function clearRbacCache() {
        \Cache::clear('rolesWithPermissions'); // role controller
        \Cache::clear('uriWithRoles'); // check permission middware
    }
}
