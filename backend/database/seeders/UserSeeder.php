<?php

namespace Database\Seeders;

use App\Models\Masyarakat;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //clean up
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Masyarakat::truncate();

        $factory = Factory::create("id_ID");
        $admin = User::create([
            "username" => "AdminSIPADES",
            "password" => Hash::make("123456"),
            "masyarakat_id" => null
        ]);
        $masyarakat = Masyarakat::create([
            "nik" => $factory->numerify(str_repeat('#',16)),
            "alamat" => $factory->address(),
            "agama" => "atheis",
            "nama_lengkap" => $factory->firstName() . " " . $factory->lastName(),
            "tempat_lahir" => "kabong-kabong",
            "tanggal_lahir" => "2004-07-19",
            "status_kawin" => "lajang"
        ]);
        $voter = User::create([
            "username" => "kabuci_loko",
            "password" => Hash::make("123456"),
            "masyarakat_id" => $masyarakat->id
        ]);
        $admin->assignRole(['Panitia']);
        $voter->assignRole(['Voter']);
    }
}
