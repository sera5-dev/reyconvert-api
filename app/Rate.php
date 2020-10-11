<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
	protected $fillable = [
		'provider_id',
		'rate',
		'pulsa',
		'uang',
	];

	protected $hidden = [
		'created_at',
		'updated_at'
	];

	public function provider()
	{
		return $this->belongsTo('Provider');
	}
}
