<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    //
    protected $table = "aktifitas";
    protected $fillable = ["nama", "alamat", "agama", "nohp"];
}
