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
                'role' => 'admin'
            ],
            [
                'name' => 'Super Editor',
                'email' => 'supereditor@email.com',
                'password' => bcrypt('supereditor'),
                'role' => 'super_editor'
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@email.com',
                'password' => bcrypt('editor'),
                'role' => 'editor'
            ],
            [
                'name' => 'Wartawan',
                'email' => 'wartawan@email.com',
                'password' => bcrypt('wartawan'),
                'role' => 'wartawan'
            ]
        ];

        $admin = [
            [
                'id_user' => 1,
                'email' => 'admin@email.com',
                'password' => bcrypt('admin')
            ]
        ];

        $super_editor = [
            [
                'id_user' => 2,
                'nama' => 'Super Editor',
                'email' => 'supereditor@email.com',
                'password' => bcrypt('supereditor'),
                'alamat' => 'Jl. Super Editor No. 1',
                'no_hp' => '081234567890',
                'jabatan' => 'Super Editor'
            ]
        ];

        $editor = [
            [
                'id_user' => 3,
                'nama' => 'Editor',
                'email' => 'editor@email.com',
                'password' => bcrypt('editor'),
                'alamat' => 'Jl. Editor No. 1',
                'no_hp' => '081234567891'
            ]
        ];

        $wartawan = [
            [
                'id_user' => 3,
                'nama' => 'Wartawan',
                'email' => 'wartawan@email.com',
                'password' => bcrypt('wartawan')
            ]
        ];

        User::insert($user);
        Admin::insert($admin);
        SuperEditor::insert($super_editor);
        Editor::insert($editor);
        Wartawan::insert($wartawan);
    }
}
