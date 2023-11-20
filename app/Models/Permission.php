<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @OA\Schema(
 *     description="Tag model"
 * )
 * @OA\Property(type="integer", property="id"),
 * @OA\Property(type="string", property="name"),
 * @OA\Property(type="string", property="slug"),
 * @OA\Property(type="string", property="description"),
 * @OA\Property(type="string", property="model"),
 */


class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'model'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
