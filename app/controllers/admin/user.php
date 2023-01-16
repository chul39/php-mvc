<?php

namespace App\Controllers\Admin;

/**
 * User admin controller
 */
class User extends \Core\Controller
{

    /**
     * Before filter
     * @return void
     */
    protected function before()
    {
        
    }

    /**
     * After filter
     * @return void
     */
    protected function after()
    {
       
    }

    /**
     * Show the index page
     * @return void
     */
    public function indexAction()
    {
        echo 'Hello from the index action in the User admin controller!';
    }

}
