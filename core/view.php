<?php

namespace Core;

/** 
 * View
*/

class View
{

    /**
     * Render view
     * @param string $view View file name
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);
        $file = "../App/Views/$view";
        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

}

?>