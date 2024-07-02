<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $totalMembresia = DB::select(" select count(*) as 'total_membresia' from membresia ");
        View::share('totalMembresia', $totalMembresia[0]->total_membresia);

        $totalCliente = DB::select(" select count(*) as 'total_cliente' from cliente where tipo_usuario='cliente' ");
        View::share('totalCliente', $totalCliente[0]->total_cliente);

        $totalUsuario = DB::select(" select count(*) as 'total_usuario' from cliente where tipo_usuario!='cliente' ");
        View::share('totalUsuario', $totalUsuario[0]->total_usuario);

        $fechaActual = Carbon::now()->toDateString();
        $totalAsistencia = DB::select("SELECT COUNT(*) AS total_asistencia FROM asistencia WHERE DATE(fecha_hora) = '{$fechaActual}'");
        View::share('totalAsistencia', $totalAsistencia[0]->total_asistencia);

        //consultas para mostrar tabla de renovacion y cuentas por cobrar
        $miembrosPorRenovar = DB::select(' SELECT cliente.id_cliente,cliente.nombre,cliente.foto,DATEDIFF(hasta, now()) AS diferencia_fechas,membresia.precio,membresia.modo
        FROM cliente INNER JOIN membresia ON cliente.id_membresia = membresia.id_membresia
        where tipo_usuario="cliente" and (select DATEDIFF(hasta, now()) AS diferencia_fechas)<=10 order by diferencia_fechas desc ');
        View::share('miembrosPorRenovar', $miembrosPorRenovar);


        $cuentasPorCobrar = DB::select(" SELECT cliente.id_cliente,cliente.nombre,debe,cliente.foto,DATEDIFF(now(),desde) AS diferencia_fechas,membresia.nombre as 'nomMem',membresia.precio,membresia.modo
        FROM cliente INNER JOIN membresia ON cliente.id_membresia = membresia.id_membresia
        where debe>0 order by diferencia_fechas desc
         ");
        View::share('cuentasPorCobrar', $cuentasPorCobrar);


    }
}
