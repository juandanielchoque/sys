<?php

namespace App\Rules\usuario\registrar;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class duplicidadUsuario implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /* validando duplicidad de usuario */
        $valUsuario = DB::select("select count(*) as total from usuario where usuario=? and estado=1", [
            $value
        ]);
        if ($valUsuario[0]->total > 0) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este usuario ya existe';
    }
}
