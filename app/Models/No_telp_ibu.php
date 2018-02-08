<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class No_telp_ibu extends Model {

	protected $table = 'no_telp_ibu';
	public $timestamps = false;
	protected $fillable = ['id','no'];
  protected $primaryKey = 'no';
	public $incrementing = false;
}
