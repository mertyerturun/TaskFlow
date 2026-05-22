<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaskFlowSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $managerRole = Role::updateOrCreate(['name' => 'manager']);
        $developerRole = Role::updateOrCreate(['name' => 'developer']);

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@taskflow.com'],
            [
                'name' => 'Software Engineer Mert Yerturun',
                'password' => Hash::make('12345'),
            ]
        );

        $adminUser->roles()->syncWithoutDetaching([
            $adminRole->id,
            $managerRole->id
        ]);

        // Proje adını ve açıklamasını burada İngilizceye çevirdik:
        Project::updateOrCreate(
            ['name' => 'TaskFlow Development Project'],
            ['description' => 'A Laravel project developed as part of the Advanced Web Programming course assignment.']
        );
    }
}
