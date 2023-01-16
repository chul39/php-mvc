<?php 

namespace Core;

/**
 * Base controller
 */
abstract class Controller 
{

    /**
     * Parameters from route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     * @param array $route_params Parameters from route
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Call action methods (need to be named with Action suffix)
     * before() and after() will also be executed.
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            } 
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Function to be called before the action method
     * @return void
     */
    protected function before()
    {

    }

    /**
     * Function to be called after the action method
     * @return void
     */
    protected function after()
    {

    }

}

?>