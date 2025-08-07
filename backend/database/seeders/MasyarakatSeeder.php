<?php

namespace Database\Seeders;

use App\Models\Masyarakat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Zmrq\Ektp\eKTP;

class MasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // isi 500 data masyarakat!
        Schema::disableForeignKeyConstraints();
        Masyarakat::truncate();
        $banyakData = 500;
        $faker = \Faker\Factory::create("id_ID");
        $ektp = new eKTP();
        $jk = ["male" => "Laki-laki", "female" => "Perempuan"];
        $kawin = [Masyarakat::$STATUS_KAWIN_LAJANG, Masyarakat::$STATUS_KAWIN_MENIKAH];
        for($i = 0; $i < $banyakData; $i++) {
            $pw = Hash::make("123456");
            $gender = array_keys($jk)[$faker->numberBetween(0,1)];
            $firstName = $faker->firstName($gender);
            $lastName = $faker->lastName($gender); 
            $tglLahir = $faker->dateTimeBetween('-60 years', '-18 years')->format("Y-m-d");

            // masyarakat instance first
            $m = Masyarakat::create([
                "nama_lengkap" => $firstName . " " . $lastName,
                "nik" => $ektp->nik,
                "alamat" => $faker->address(),
                "tempat_lahir" => $ektp->user->bornCity,
                "tanggal_lahir" => $tglLahir,
                "agama" => $ektp->user->religion,
                "jenis_kelamin" => $jk[$gender],
                "status_kawin" => $kawin[$faker->numberBetween(0,1)],
            ]);

            $tempUsername = $firstName;
            $numerify = $faker->numerify("####");
            while(\App\Models\User::where('username', $tempUsername . " " . $numerify)->count() > 0) {
                $numerify = $faker->numerify("####");
            }
            $tempUsername = $firstName . " " . $numerify;

            \App\Models\User::create([
                "masyarakat_id" => $m->id,
                "username" => $tempUsername,
                "password" => $pw,
            ]);
        }
    }
}
