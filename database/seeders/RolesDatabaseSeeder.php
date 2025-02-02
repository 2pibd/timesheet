<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'SuperAdmin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'User']);

        app()['cache']->forget('spatie.permission.cache');

        $admin = User::firstOrCreate([
            'name' => 'Joe',
            'slug' => 'Bloggs',
            'email' => 'j.bloggs@domain.com'
        ],
            [
                'password' => bcrypt('a-random-password')
            ]);

        $admin->assignRole('Admin');
    }
}
