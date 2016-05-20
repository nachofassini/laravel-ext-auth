<?php
namespace NachoFassini\Auth;

trait ExtAuthTrait
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'dni', 'email', 'password', 'remember_token'];

    /**
     * Verificar si el usuario esta habilitado
     * @return bool
     */
    public function habilitado()
    {
        return $this->estado->codigo == 'HAB';
    }

    /**
     * Obtiene los estados de los usuarios
     *
     * @return mixed
     */
    public function estado()
    {
        return $this->belongsTo(UserEstados::class, 'estado_id');
    }
}
