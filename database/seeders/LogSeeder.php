<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Sample log entries more relevant to the organizational structure
        $logData = [
            [
                'description' => 'Pengajuan cuti tahunan',
                'status' => 'pending',
                'attachment' => 'form_cuti_2025.pdf',
            ],
            [
                'description' => 'Laporan kinerja bulanan',
                'status' => 'disetujui',
                'attachment' => 'laporan_kinerja_april.xlsx',
            ],
            [
                'description' => 'Pengajuan biaya operasional',
                'status' => 'pending',
                'attachment' => 'form_biaya_operasional.docx',
            ],
            [
                'description' => 'Permintaan perbaikan fasilitas kantor',
                'status' => 'ditolak',
                'attachment' => 'form_permintaan_fasilitas.pdf',
            ],
            [
                'description' => 'Proposal kegiatan tim',
                'status' => 'disetujui',
                'attachment' => 'proposal_kegiatan.pdf',
            ],
            [
                'description' => 'Pengajuan reimburse biaya transportasi',
                'status' => 'pending',
                'attachment' => 'form_reimburse.pdf',
            ],
            [
                'description' => 'Laporan kunjungan klien',
                'status' => 'disetujui',
                'attachment' => 'laporan_kunjungan.docx',
            ],
        ];

        // Create multiple logs for various users
        foreach ($users as $user) {
            // Each user gets 1-3 random log entries
            $numLogs = rand(1, 3);

            for ($i = 0; $i < $numLogs; $i++) {
                // Get a random log template
                $logTemplate = $logData[array_rand($logData)];

                // Create the log with a random date in the past 30 days
                Log::create([
                    'description' => $logTemplate['description'],
                    'user_id' => $user->id,
                    'status' => $logTemplate['status'],
                    'attachment' => $logTemplate['attachment'],
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 29)),
                ]);
            }
        }
    }
}