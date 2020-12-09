<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
  protected $fillable = [
    'id',
    'tanggal',
    'nama',
    'kontak',
    'gambar',
    'video',
    'komentar',
    'star',
  ];
}
