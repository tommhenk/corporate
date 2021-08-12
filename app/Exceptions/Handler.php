<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\MyException;
use Illuminate\Http\Request;
use App\Exceptions\InvalidOrderException;
use Exception;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */

    // public function report(Exeption $exep)
    // {

    //     dd($exep);
    // }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {

        if ($this->isHttpException( $e )) {
            $statusCode = $e->getStatusCode();

            switch($statusCode) {
                case '404' :

                $obj = new \App\Http\Controllers\SiteController( new \App\Repositories\MenusRepository(new \App\Models\Menu) );
                $navigation = view(config('settings.theme').'.navigation')->with('menu', $obj->getMenu())->render();
                // dd($navigation);
                \Log::alert('Страница не найдена - '. $request->url());
                return response()->view(config('settings.theme').'.errors.404', ['bar'=>'no', 'title'=>'Страница не найдена', 'navigation'=>$navigation]);
            }
        }
     
        return parent::render($request, $e);
    }
    public function register()
    {

        $this->reportable(function (Throwable $e) {
            // 
        });

    }
}
