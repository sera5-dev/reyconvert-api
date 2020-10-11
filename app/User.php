<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $fillable = [
		'email',
		'username',
		'password',
		'nama',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
