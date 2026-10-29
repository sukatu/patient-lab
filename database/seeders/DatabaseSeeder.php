<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $patients = [
            ['PAT-10001', 'Ama', 'Mensah', '1988-04-12', 'Female', '024 555 0101', 'ama.mensah@example.test', 'Accra', 'active', '2026-10-12 09:30:00'],
            ['PAT-10002', 'Kwame', 'Asante', '1975-09-03', 'Male', '020 555 0102', 'kwame.asante@example.test', 'Kumasi', 'active', '2026-09-28 13:15:00'],
            ['PAT-10003', 'Abena', 'Owusu', '1992-01-20', 'Female', '027 555 0103', 'abena.owusu@example.test', 'Accra', 'active', '2026-10-21 08:45:00'],
            ['PAT-10004', 'Kojo', 'Boateng', '1961-11-14', 'Male', '054 555 0104', 'kojo.boateng@example.test', 'Takoradi', 'inactive', '2025-12-02 11:00:00'],
            ['PAT-10005', 'Akosua', 'Agyeman', '2000-07-08', 'Female', '024 555 0105', 'akosua.agyeman@example.test', 'Cape Coast', 'active', '2026-08-19 15:40:00'],
            ['PAT-10006', 'Yaw', 'Osei', '1983-02-27', 'Male', '050 555 0106', 'yaw.osei@example.test', 'Accra', 'active', '2026-10-03 10:20:00'],
            ['PAT-10007', 'Esi', 'Addo', '1995-06-16', 'Female', '026 555 0107', 'esi.addo@example.test', 'Tamale', 'inactive', null],
            ['PAT-10008', 'Kofi', 'Adjei', '1970-12-30', 'Male', '055 555 0108', 'kofi.adjei@example.test', 'Kumasi', 'active', '2026-07-11 14:05:00'],
            ['PAT-10009', 'Adwoa', 'Darko', '1986-05-22', 'Female', '059 555 0109', 'adwoa.darko@example.test', 'Accra', 'active', '2026-10-25 16:10:00'],
            ['PAT-10010', 'Nana', 'Sarpong', '1948-03-05', 'Non-binary', '023 555 0110', 'nana.sarpong@example.test', 'Takoradi', 'active', '2026-06-30 09:00:00'],
            ['PAT-10011', 'Efua', 'Nyarko', '1998-08-11', 'Female', '024 555 0111', 'efua.nyarko@example.test', 'Cape Coast', 'active', '2026-09-14 12:30:00'],
            ['PAT-10012', 'Fiifi', 'Quartey', '2005-10-19', 'Male', '020 555 0112', 'fiifi.quartey@example.test', 'Accra', 'active', null],
        ];

        foreach ($patients as $patient) {
            Patient::query()->updateOrCreate(
                ['patient_number' => $patient[0]],
                [
                    'first_name' => $patient[1],
                    'last_name' => $patient[2],
                    'date_of_birth' => $patient[3],
                    'sex' => $patient[4],
                    'phone' => $patient[5],
                    'email' => $patient[6],
                    'city' => $patient[7],
                    'status' => $patient[8],
                    'last_visit_at' => $patient[9],
                ]
            );
        }
    }
}
