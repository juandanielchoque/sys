<?php

namespace App\Rules\usuario\registrar;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class duplicidadCorreo implements Rule
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
        /* validando duplicidad de correo */
        $valCorreo = DB::select("select count(*) as total from usuario where correo=? and estado=1", [
            $value
        ]);
        if ($valCorreo[0]->total > 0) {
            return false;
        } else {
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
        return 'Este correo ya existe';
    }
}
