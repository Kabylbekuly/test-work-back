<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];
    protected $primaryKey = 'id';
    protected $table = 'roles';

    public function getDetailAttribute()
    {
        return ucfirst($this->name);
    }

    public function scopeFilterByName($q, $name = null)
    {
        if (!$name) {
            return $q;
        }

        return $q->where('name', 'like', '%' . $name . '%');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
