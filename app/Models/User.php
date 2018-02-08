<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'user';
	public $timestamps = false;
	protected $fillable = ['username','password','email','id_tipe'];
}
