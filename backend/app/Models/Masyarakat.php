<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $fillable = [
        "nik",
        "nama_lengkap",
        "alamat",
        "tanggal_lahir",
        "jenis_kelamin",
        "tempat_lahir",
        "agama",
        "status_kawin",
    ];

    public static $STATUS_KAWIN_MENIKAH = "menikah";
    public static $STATUS_KAWIN_LAJANG = "lajang";
}
