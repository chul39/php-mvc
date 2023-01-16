<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Post;

/**
 * Post controller
 */
class Posts extends \Core\Controller
{
    
    /**
     * Show index page
     * @return void
     */
    public function indexAction() 
    {
        $posts = Post::getAll();
        View::render('Posts/index.php', [ 'posts' => $posts ]);
    }

    /**
     * Add new page
     * @return void
     */
    public function addNewAction()
    {
        echo "addNew() in Posts controller.";
    }

    /**
     * Show edit page
     * @return void
     */
    public function editAction()
    {
        echo "index() in Posts controller.";
        echo "<p>Parameters: <pre>" . htmlspecialchars(print_r($this->route_params, true)) . "</pre></p>";
    }

}

?>