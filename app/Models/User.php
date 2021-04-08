<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $ID_USER
 * @property string $USERNAME
 * @property string $PASSWORD
 * @property string $NAMA_LENGKAP
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'ID_USER';
	public $timestamps = false;

	protected $fillable = [
		'USERNAME',
		'PASSWORD',
		'NAMA_LENGKAP'
	];
}
