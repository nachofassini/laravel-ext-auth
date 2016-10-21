<?php
namespace NachoFassini\Auth;

trait HasEstadoTrait
{
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
