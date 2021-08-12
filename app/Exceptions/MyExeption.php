<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class MyExeption extends Exception
{
    public function render(Request $request)
    {
        return response()->view(
                config('settings.theme').'.errors.404',
                array(
                    'exception' => $this
                )
        );
    }
}
