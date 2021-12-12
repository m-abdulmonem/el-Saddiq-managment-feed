<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('/') || $request->is('/*')) {
            return redirect()->guest('login');
        }
        return redirect()->guest(route('login'));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {

            switch ($exception->getStatusCode()){
                case 404:
                    session()->flash("error-404",404);
                    return response()->view("site.layouts.errors.404", ['title' => trans("home.404")]);
                case 500:
                    return response()->view("site.layouts.errors.500",['title' => trans("home.500")]);
                case 419:
                    return response()->view("site.layouts.errors.419",['title' => trans("home.419")]);
                case 403:
                    return response()->view("site.layouts.errors.403",['title' => trans("home.403")]);
                case 429:
                    return redirect("429");
                case 501:
                    return redirect("501");
            }
        }
        return parent::render($request, $exception);
    }
}
