<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terpilih extends Model {

	protected $table = 'terpilih';
	public $timestamps = false;
	protected $fillable = ['id','status'];
  protected $primaryKey = 'id';
	public $incrementing = false;
}
