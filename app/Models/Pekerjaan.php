<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model {

	protected $table = 'pekerjaan';
	public $timestamps = false;
	protected $fillable = ['nama_pekerjaan'];
  protected $primaryKey = 'id_pekerjaan';
}
