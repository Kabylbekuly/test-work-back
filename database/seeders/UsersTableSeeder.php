<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Order;
use App\Models\Partner;
use App\Models\SupportTicketCategory;
use App\Models\Tour;
use App\Models\TourTicket;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '1',
            'name' => 'admin',
            'email' => 'admin@qsmart.kz',
            'password' => bcrypt('123456'),
            'email_verified_at' => Carbon::now(),
        ]);


        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1',
        ]);

        DB::table('users')->insert([
            'id' => '2',
            'name' => 'Nurmagambet',
            'email' => 'snurik2012@gmail.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => Carbon::now(),

        ]);
        DB::table('role_user')->insert([
            'role_id' => '5',
            'user_id' => '2',
        ]);
    }
}
