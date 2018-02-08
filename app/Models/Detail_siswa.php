<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_siswa extends Model {

	protected $table = 'detail_siswa';
	public $timestamps = false;
	protected $fillable = ['id','nama','tgl_lahir','jenis_kelamin','alamat','asal_sekolah','nama_ayah','alamat_ayah','id_pekerjaan_ayah','nama_ibu','alamat_ibu','id_pekerjaan_ibu','status_ibu','status_ayah'];
  protected $primaryKey = 'id';
}
