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
        return redirect(route("login"));
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
    public function render($request, Throwable $exception): Response
    {
        if ($this->isHttpException($exception)) {

            if (\str_contains($request->url(),"dashbaord")){
                $this->dashboardErrors($exception);
            }
            
        }
        return parent::render($request, $exception);
    }

    private function dashboardErrors($exception)
    {
        switch ($exception->getStatusCode()){
            case 404:
                session()->flash("error-404",404);
                return $this->dashboardErrorView(404);
            case 500:
                return $this->dashboardErrorView(500);
            case 419:
                return $this->dashboardErrorView(419);
            case 403:
                return $this->dashboardErrorView(403);
            case 429:
                return redirect("429");
            case 501:
                return redirect("501");
        }
    }

    private function dashboardErrorView(string|int $code)
    {
        $path = "site.layouts.errors";

        return response()->view("$path.$code",['title' => trans("home.$code")]);
    }
}
