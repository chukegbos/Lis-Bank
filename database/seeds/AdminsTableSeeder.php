<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin;
        $admin->name = 'Admin Honorable';
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('Father@1989');
        $admin->save();
    }
}
