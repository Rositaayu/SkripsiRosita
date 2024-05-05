<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tag = [
            [
                'nama_tag' => 'Peristiwa Daerah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Indonesia Positif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Peristiwa Nasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Olahraga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Politik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Peristiwa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Ekonomi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Pemerintahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Gaya Hidup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'English',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Wisata',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Peristiwa Internasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Hukum dan Kriminal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Entertainment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Kuliner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Tekno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Otomotif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Tag::insert($tag);
    }
}
