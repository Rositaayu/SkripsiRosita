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
                'nama_tag' => 'Politik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Olahraga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Teknologi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Ekonomi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Hiburan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Lifestyle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Travel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Kriminal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Sosial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Budaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Agama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Otomotif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Kuliner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Fashion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Properti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tag' => 'Parenting',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Tag::insert($tag);
    }
}
