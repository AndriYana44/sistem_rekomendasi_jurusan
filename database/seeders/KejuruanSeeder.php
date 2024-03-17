<?php

namespace Database\Seeders;

use App\Models\Kejuruan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KejuruanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kejuruan = [
            ['kejuruan' => 'TKJ'],
            ['kejuruan' => 'ANIMASI'],
            ['kejuruan' => 'AKUTANSI']
        ];

        DB::table('m_kejuruan')->insert($kejuruan);
    }
}
