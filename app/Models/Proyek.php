<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Proyek
 * 
 * @property string $KODE_PROYEK
 * @property string $NAMA_PROYEK
 * @property Carbon $START_PROYEK
 * @property Carbon $END_PROYEK
 * @property int $STATUS
 * @property Carbon $LAST_UPDATE
 * 
 * @property Collection|Progress[] $progress
 *
 * @package App\Models
 */
class Proyek extends Model
{
	protected $table = 'proyek';
	protected $primaryKey = 'KODE_PROYEK';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'STATUS' => 'int'
	];

	protected $dates = [
		'START_PROYEK',
		'END_PROYEK',
		'LAST_UPDATE'
	];

	protected $fillable = [
		'NAMA_PROYEK',
		'START_PROYEK',
		'END_PROYEK',
		'STATUS',
		'LAST_UPDATE'
	];

	public function progress()
	{
		return $this->hasMany(Progress::class, 'KODE_PROYEK');
	}
}
