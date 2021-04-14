<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Progress
 * 
 * @property Carbon $TANGGAL
 * @property int $ID_TIPE
 * @property string $KODE_PROYEK
 * @property float $VALUE
 * 
 * @property Proyek $proyek
 * @property Tipe $tipe
 *
 * @package App\Models
 */
class Progress extends Model
{
	protected $table = 'progress';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_TIPE' => 'int',
		'VALUE' => 'float'
	];

	protected $dates = [
		'TANGGAL'
	];

	protected $fillable = [
		'VALUE'
	];

	public function proyek()
	{
		return $this->belongsTo(Proyek::class, 'KODE_PROYEK');
	}

	public function tipe()
	{
		return $this->belongsTo(Tipe::class, 'ID_TIPE');
	}
}
