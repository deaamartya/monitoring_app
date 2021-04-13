<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipe
 * 
 * @property int $ID_TIPE
 * @property string $NAMA_TIPE
 * 
 * @property Collection|Progress[] $progress
 *
 * @package App\Models
 */
class Tipe extends Model
{
	protected $table = 'tipe';
	protected $primaryKey = 'ID_TIPE';
	public $timestamps = false;

	protected $fillable = [
		'NAMA_TIPE'
	];

	public function progress()
	{
		return $this->hasMany(Progress::class, 'ID_TIPE');
	}
}
