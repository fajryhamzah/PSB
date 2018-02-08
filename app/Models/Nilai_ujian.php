<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai_ujian extends Model {

	protected $table = 'nilai_ujian';
	public $timestamps = false;
	protected $fillable = ['id_ujian','id_penilai','id_siswa','nilai'];
  protected $primaryKey = 'id_nilai_ujian';
}
