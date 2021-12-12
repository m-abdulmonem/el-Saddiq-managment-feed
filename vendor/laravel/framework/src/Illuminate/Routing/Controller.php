<?php

namespace Illuminate\Routing;

use BadMethodCallException;

abstract class Controller
{
    /**
     * The middleware registered on the controller.
     *
     * @var array
     */
    protected $middleware = [];


    /**
     * The view folder name
     *
     * @var string
     */
    protected $folder = "";

    /**
     * the permission name of he view
     *
     * @var string
     */
    protected $perm = "";
    
    /**
     * the translation file name
     *
     * @var string
     */
    protected $trans = "";


    /**
     * Register middleware on the controller.
     *
     * @param  \Closure|array|string  $middleware
     * @param  array  $options
     * @return \Illuminate\Routing\ControllerMiddlewareOptions
     */
    public function middleware($middleware, array $options = [])
    {
        foreach ((array) $middleware as $m) {
            $this->middleware[] = [
                'middleware' => $m,
                'options' => &$options,
            ];
        }

        return new ControllerMiddlewareOptions($options);
    }

    /**
     * Get the middleware assigned to the controller.
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }

    /**
     * spaite permissions check 
     * 
     * @void
     */
    public function perm()
    {
        $this->middleware("permission:read $this->perm")->only('show');
        $this->middleware("permission:create $this->perm")->only(['create','store']);
        $this->middleware("permission:update $this->perm")->only(['edit','update']);
        $this->middleware("permission:delete $this->perm")->only('destroy');

    }
}
