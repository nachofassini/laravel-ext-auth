<?php
namespace NachoFassini\Auth;

trait ExtAuthTrait
{
    /**
     * @param $query
     * @param string $param
     */
    public function scopeBusqueda($query, $param = '')
    {
        if ($param != '') {
            $search = '%' . $param . '%';
            return $query->where('name', 'like', $search)
                ->orWhere('email', 'like', $search);
        }
        return $query;
    }

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
