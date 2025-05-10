<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $coachRole = Role::create(['name' => 'coach']);
        $playerRole = Role::create(['name' => 'player']);
        
        // Assign existing users to roles based on their role field
        $users = User::all();
        foreach ($users as $user) {
            // Only assign role if the role field is not null
            if (!empty($user->role)) {
                $user->assignRole($user->role);
            } else {
                // Default to player role if no role is set
                $user->assignRole('player');
            }
        }
    }
}
