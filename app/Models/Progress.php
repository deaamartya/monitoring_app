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
 * @property string $KODE_PROYEK
 * @property float|null $PV_VALUE
 * @property float|null $EV_VALUE
 * @property float|null $AC_VALUE
 * @property int|null $RENCANA
 * @property int|null $REALISASI
 * 
 * @property Proyek $proyek
 *
 * @package App\Models
 */
class Progress extends Model
{
	protected $table = 'progress';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'PV_VALUE' => 'float',
		'EV_VALUE' => 'float',
		'AC_VALUE' => 'float',
		'RENCANA' => 'int',
		'REALISASI' => 'int'
	];

	protected $dates = [
		'TANGGAL'
	];

	protected $fillable = [
		'PV_VALUE',
		'EV_VALUE',
		'AC_VALUE',
		'RENCANA',
		'REALISASI'
	];

	public function proyek()
	{
		return $this->belongsTo(Proyek::class, 'KODE_PROYEK');
	}
}
