<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
  protected $fillable = [
    'nama',
    'logo'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  public function rates()
  {
    return $this->hasMany('Rate');
  }
}
