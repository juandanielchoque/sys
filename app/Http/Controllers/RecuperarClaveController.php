<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecuperarClaveRequest;
use App\Mail\RecuperarClaveMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RecuperarClaveController extends Controller
{
    public function index()
    {
        return view("auth/recuperarClave");
    }
    public function update(Request $request)
    {
        $request->validate([
            "correo" => "required|exists:App\Models\cliente,correo"
        ]);
        $correo = $request->correo;
        $codigo = Str::random(6);
        $actualizarCodigo = DB::update("update cliente set codigo='$codigo' where correo='$correo' ");

        $envioCorreo = new RecuperarClaveMailable($correo, $codigo); //enviamos estos datos al MAILABLE
        $envio = Mail::to($correo)->send($envioCorreo); //CORREO DEL RECEPTOR
        if ($envio === null) {
            return redirect()->back()->with("CORRECTO", "Se ha enviado un correo a:" . $correo);
        } else {
            return redirect()->back()->with("INCORRECTO", "No se pudo enviar el correo, por favor intente nuevamente");
        }
    }


    public function nuevoClave($correo, $codigo)
    {
        return view("auth/reset/vistaRecuperar", compact("correo", "codigo"));
    }

    public function reset(RecuperarClaveRequest $request)
    {
        $correo = $request->correo;
        $codigo = $request->codigo;
        $buscar = DB::select("select count(*) as total from cliente where correo='$correo' and codigo='$codigo' ");
        if ($buscar[0]->total <= 0) {
            return back()->with("INCORRECTO", "El valor del correo no coincide con el codigo");
        }

        $clave1 = md5($request->password);
        $clave2 = md5($request->passwordRepeat);
        if ($clave1 != $clave2) {
            return back()->with("INCORRECTO", "Las contraseñas no coinciden");
        }
        $claveE = md5($request->password);
        try {
            $sql = DB::update(" update cliente set password=?, codigo='' where correo=?", [
                $claveE,
                $request->correo
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Contraseña restablecida correctamente");
        } else {
            return back()->with("INCORRECTO", "error al restablecer la contraseña");
        }
    }
}
