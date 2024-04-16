<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Editor;
use App\Models\Wartawan;
use App\Models\SuperEditor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Super Editor',
                'email' => 'supereditor@email.com',
                'password' => bcrypt('supereditor'),
                'role' => 'super_editor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@email.com',
                'password' => bcrypt('editor'),
                'role' => 'editor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wartawan',
                'email' => 'wartawan@email.com',
                'password' => bcrypt('wartawan'),
                'role' => 'wartawan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $admin = [
            [
                'id_user' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $super_editor = [
            [
                'id_user' => 2,
                'alamat' => 'Jl. Super Editor No. 1',
                'no_hp' => '081234567890',
                'jabatan' => 'Super Editor',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $editor = [
            [
                'id_user' => 3,
                'alamat' => 'Jl. Editor No. 1',
                'no_hp' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $wartawan = [
            [
                'id_user' => 4,
                'id_editor' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        User::insert($user);
        Admin::insert($admin);
        SuperEditor::insert($super_editor);
        Editor::insert($editor);
        Wartawan::insert($wartawan);
    }
}
