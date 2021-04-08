<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
	protected $table = 'users';
	protected $primaryKey = 'ID_USER';
	public $timestamps = false;

	protected $fillable = [
		'username',
		'password',
		'NAMA_LENGKAP'
	];
}
