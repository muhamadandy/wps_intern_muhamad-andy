<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Direktur',
                'level' => 'direktur',
            ],
            [
                'name' => 'Manager Operasional',
                'level' => 'manager',
            ],
            [
                'name' => 'Manager Keuangan',
                'level' => 'manager',
            ],
            [
                'name' => 'Staff Operasional',
                'level' => 'staff',
            ],
            [
                'name' => 'Staff Keuangan',
                'level' => 'staff',
            ],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}