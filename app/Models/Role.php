<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMIN_ROLES = ['admin', 'master'];
    const FIRST_PARTY_ROLES = ['supervisor', 'manager', 'cordinator', 'senior', 'junior'];
    //roles that are not agents
    const SECOND_PARTY_ROLES = ['technic', 'company'];
    const THIRD_PARTY_ROLES = ['general-contractor'];
    
    //agents roles
    public static function agents()
    {
        return array_merge(self::ADMIN_ROLES, self::FIRST_PARTY_ROLES);
    }
}
