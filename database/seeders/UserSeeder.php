<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $direkturPosition = Position::where('name', 'Direktur')->first()->id;
        $managerOperasionalPosition = Position::where('name', 'Manager Operasional')->first()->id;
        $managerKeuanganPosition = Position::where('name', 'Manager Keuangan')->first()->id;
        $staffOperasionalPosition = Position::where('name', 'Staff Operasional')->first()->id;
        $staffKeuanganPosition = Position::where('name', 'Staff Keuangan')->first()->id;

        // Create Direktur
        $direktur = User::create([
            'name' => 'Budi Santoso',
            'email' => 'direktur@example.com',
            'password' => Hash::make('password'),
            'position_id' => $direkturPosition,
            'manager_id' => null, // No manager
        ]);

        // Create Manager Operasional
        $managerOperasional = User::create([
            'name' => 'Agus Pratama',
            'email' => 'operasional@example.com',
            'password' => Hash::make('password'),
            'position_id' => $managerOperasionalPosition,
            'manager_id' => $direktur->id,
        ]);

        // Create Manager Keuangan
        $managerKeuangan = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'keuangan@example.com',
            'password' => Hash::make('password'),
            'position_id' => $managerKeuanganPosition,
            'manager_id' => $direktur->id,
        ]);

        // Create Staff Operasional (reports to Manager Operasional)
        User::create([
            'name' => 'Rini Wulandari',
            'email' => 'staff.operasional1@example.com',
            'password' => Hash::make('password'),
            'position_id' => $staffOperasionalPosition,
            'manager_id' => $managerOperasional->id,
        ]);

        // Create another Staff Operasional
        User::create([
            'name' => 'Joko Susilo',
            'email' => 'staff.operasional2@example.com',
            'password' => Hash::make('password'),
            'position_id' => $staffOperasionalPosition,
            'manager_id' => $managerOperasional->id,
        ]);

        // Create Staff Keuangan (reports to Manager Keuangan)
        User::create([
            'name' => 'Maya Sari',
            'email' => 'staff.keuangan1@example.com',
            'password' => Hash::make('password'),
            'position_id' => $staffKeuanganPosition,
            'manager_id' => $managerKeuangan->id,
        ]);

        // Create another Staff Keuangan
        User::create([
            'name' => 'Andi Wijaya',
            'email' => 'staff.keuangan2@example.com',
            'password' => Hash::make('password'),
            'position_id' => $staffKeuanganPosition,
            'manager_id' => $managerKeuangan->id,
        ]);
    }
}
