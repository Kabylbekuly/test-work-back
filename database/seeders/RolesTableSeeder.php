<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Admin Role',
                'level' => 5,
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'User Role',
                'level' => 1,
            ],
            [
                'name' => 'Unverified',
                'slug' => 'unverified',
                'description' => 'Unverified Role',
                'level' => 0,
            ],
            [
                'name' => 'Content-Manager',
                'slug' => 'contentmanager',
                'description' => 'Content_manager',
                'level' => 4,
            ],
            [
                'name' => 'Partner',
                'slug' => 'partner',
                'description' => 'partner',
                'level' => 2,
            ],
            [
                'name' => 'Partner Manager',
                'slug' => 'partner_manager',
                'description' => 'partner manager',
                'level' => 2,
            ],
            [
                'name' => 'Sapartime Manager',
                'slug' => 'sapartime_manager',
                'description' => 'sapartime manager',
                'level' => 2,
            ],

        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name' => $RoleItem['name'],
                    'slug' => $RoleItem['slug'],
                    'description' => $RoleItem['description'],
                    'level' => $RoleItem['level'],
                ]);
            }
        }
    }
}
