<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear old data (optional, for development)
        Schema::disableForeignKeyConstraints();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        Permission::truncate();
        Role::truncate();
        /**
         * @var \App\Models\Role
         */
        $roleAdmin = Role::create(['nama' => 'Panitia', 'keterangan' => 'administrasi dan managament data pemilih']);
        /**
         * @var \App\Models\Role
         */
        $roleVoter = Role::create(['nama' => 'Voter', 'keterangan' => 'Masyarakat yang memiliki hak untuk memilih kepala desa']);
        $permissions = [
            // Permissions untuk Masyarakat
            "masyarakat" => [
                [
                'nama' => 'view-masyarakat',
                'keterangan' => 'Melihat data masyarakat'
                ],
                [
                    'nama' => 'create-masyarakat',
                    'keterangan' => 'Membuat data masyarakat baru'
                ],
                [
                    'nama' => 'edit-masyarakat',
                    'keterangan' => 'Mengubah data masyarakat'
                ],
                [
                    'nama' => 'delete-masyarakat',
                    'keterangan' => 'Menghapus data masyarakat'
                ]
            ],
            // Permissions untuk Kandidat
            "kandidat" => [
                [
                    'nama' => 'view-kandidat',
                    'keterangan' => 'Melihat data kandidat'
                ],
                [
                    'nama' => 'create-kandidat',
                    'keterangan' => 'Membuat data kandidat baru'
                ],
                [
                    'nama' => 'edit-kandidat',
                    'keterangan' => 'Mengubah data kandidat'
                ],
                [
                    'nama' => 'delete-kandidat',
                    'keterangan' => 'Menghapus data kandidat'
                ]
            ],
            "periode" => [
                [
                    'nama' => 'view-periode',
                    'keterangan' => 'Melihat daftar periode pemilihan kepala desa', 
                ],
                [
                    'nama' => 'create-periode',
                    'keterangan' => 'Membuat data periode baru'
                ],
                [
                    'nama' => 'edit-periode',
                    'keterangan' => 'Mengubah data periode'
                ],
            ],
            // Permissions untuk user
            "user" => [
                [
                    'nama' => 'view-user',
                    'keterangan' => 'Melihat data user'
                ],
                [
                    'nama' => 'create-user',
                    'keterangan' => 'Membuat data user baru'
                ],
                [
                    'nama' => 'edit-user',
                    'keterangan' => 'Mengubah data user'
                ],
                [
                    'nama' => 'delete-user',
                    'keterangan' => 'Menghapus data user'
                ],
            ],
            "other" => [
                [
                    'nama' => 'generate-credential',
                    'keterangan' => 'Membuat QR-CODE yang akan digunakan masuk ke halaman pemilihan'
                ]
            ]
        ];

        $voterPermission = Permission::create([
            'nama' => 'can-vote',
            'keterangan' => 'dapat memilh calon kepala desa 1 kali tiap periode'
        ]);

        $permissionIds = [];
        $count = 0;
        foreach($permissions as $group => $permission) {
            for($i = 0; $i < count($permission); $i++) {
                $temp = Permission::create($permission[$i]);
                $permissionIds[$count] = $temp->id;
                $count += 1;
            }
        }
        $roleAdmin->permissions()->sync($permissionIds);
        $roleVoter->permissions()->sync($voterPermission);
    }
}
