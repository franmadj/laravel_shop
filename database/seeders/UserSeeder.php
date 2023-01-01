<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = User::create([
                    'name' => 'Super admin',
                    'email' => 'admin@mail.com',
                    'password' => bcrypt('webmaster'),
        ]);
        $role = Role::create(['name' => 'user']);
        $role = Role::create(['name' => 'admin']);
        $user->assignRole('admin');
        //$permission = Permission::create(['name' => 'edit articles']);
        //$user = DB::table('users')->orderBy('id', 'asc')->skip(0)->take(1)->first();
    }
}
