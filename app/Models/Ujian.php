<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model {

	protected $table = 'ujian';
	public $timestamps = false;
	protected $fillable = ['nama_ujian','persentase'];
  protected $primaryKey = 'id_ujian';
}
