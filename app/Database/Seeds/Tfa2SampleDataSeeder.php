<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Tfa2SampleDataSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('customers')->insertBatch([
            ['full_name' => 'Ariana Santos', 'email' => 'ariana.santos@example.com', 'phone' => '+63 917 111 2233', 'created_at' => '2026-10-03 09:00:00'],
            ['full_name' => 'Miguel Reyes', 'email' => 'miguel.reyes@example.com', 'phone' => '+63 918 222 3344', 'created_at' => '2026-10-03 09:05:00'],
            ['full_name' => 'Sofia Lim', 'email' => 'sofia.lim@example.com', 'phone' => '+63 919 333 4455', 'created_at' => '2026-10-03 09:10:00'],
            ['full_name' => 'Daniel Cruz', 'email' => 'daniel.cruz@example.com', 'phone' => '+63 920 444 5566', 'created_at' => '2026-10-03 09:15:00'],
            ['full_name' => 'Liza Mendoza', 'email' => 'liza.mendoza@example.com', 'phone' => '+63 921 555 6677', 'created_at' => '2026-10-03 09:20:00'],
        ]);

        $this->db->table('users')->insertBatch([
            ['username' => 'admin01', 'full_name' => 'Renee Bautista', 'created_at' => '2026-10-03 10:00:00'],
            ['username' => 'mgr_santos', 'full_name' => 'Ethan Santos', 'created_at' => '2026-10-03 10:05:00'],
            ['username' => 'cashier_lee', 'full_name' => 'Mia Lee', 'created_at' => '2026-10-03 10:10:00'],
            ['username' => 'mgr_fernandez', 'full_name' => 'Julian Fernandez', 'created_at' => '2026-10-03 10:15:00'],
            ['username' => 'cashier_vega', 'full_name' => 'Kyla Vega', 'created_at' => '2026-10-03 10:20:00'],
        ]);
    }
}