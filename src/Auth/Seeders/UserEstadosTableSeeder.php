<?php
namespace NachoFassini\Auth\Seeders;

use Illuminate\Database\Seeder;
use NachoFassini\Auth\UserEstados;

class UserEstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            'habilitado' => ['nombre' => 'Habilitado', 'codigo' => 'HAB', 'descripcion' => 'Habilitados para usar el sistema.'],
            'bloqueado' => ['nombre' => 'Bloqueado', 'codigo' => 'BLQ', 'descripcion' => 'No puede usar el sistema'],
        ];

        $habilitado = UserEstados::create($estados['habilitado']);
        $bloqueado = UserEstados::create($estados['bloqueado']);
    }
}
