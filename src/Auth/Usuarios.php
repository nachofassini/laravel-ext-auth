<?php
namespace NachoFassini\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Usuarios extends User
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'dni', 'email', 'password', 'remember_token'];

    public function habilitado()
    {
        return $this->estado->codigo == 'HAB';
    }

    public function estado()
    {
        return $this->belongsTo(NachoFassini\Auth\UserEstados::class, 'estado_id');
    }
}
