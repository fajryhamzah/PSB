<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model {

	protected $table = 'persyaratan';
	public $timestamps = false;
	public $incrementing = false;
	protected $fillable = ['id','foto','kartu_keluarga','skhun','surat_keterangan_pindah_kota'];
  protected $primaryKey = 'id';
}
