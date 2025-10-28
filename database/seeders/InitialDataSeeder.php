<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Area;
use App\Models\Mekhala;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'is_active' => true,
        ]);

        // Create sample areas
        $area1 = Area::create([
            'name' => 'Area 1',
            'description' => 'First area',
            'is_active' => true,
        ]);

        $area2 = Area::create([
            'name' => 'Area 2',
            'description' => 'Second area',
            'is_active' => true,
        ]);

        // Create sample mekhala
        $mekhala1 = Mekhala::create([
            'name' => 'Mekhala 1',
            'description' => 'First mekhala',
            'is_active' => true,
        ]);

        // Create sample units
        Unit::create([
            'name' => 'Unit 1A',
            'area_id' => $area1->id,
            'description' => 'Unit 1 in Area A',
            'is_active' => true,
        ]);

        Unit::create([
            'name' => 'Unit 1B',
            'area_id' => $area1->id,
            'description' => 'Unit 2 in Area A',
            'is_active' => true,
        ]);

        Unit::create([
            'name' => 'Unit 2A',
            'area_id' => $area2->id,
            'description' => 'Unit 1 in Area B',
            'is_active' => true,
        ]);

        // Create area user
        User::create([
            'name' => 'Area User',
            'email' => 'area@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'area',
            'area_id' => $area1->id,
            'is_active' => true,
        ]);

        // Create mekhala user
        User::create([
            'name' => 'Mekhala User',
            'email' => 'mekhala@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'mekhala',
            'mekhala_id' => $mekhala1->id,
            'is_active' => true,
        ]);
    }
}