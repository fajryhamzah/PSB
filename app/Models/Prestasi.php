<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model {

	protected $table = 'prestasi';
	public $timestamps = false;
	protected $fillable = ['nama_prestasi','keterangan','id','id_penilai','nilai'];
  protected $primaryKey = 'id_prestasi';
}
