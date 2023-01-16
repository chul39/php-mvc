<?php 

namespace Core;

/**
 * Error and exception handler
 */

class Error
{
    /**
     * Error handler
     * @param int $level Error level
     * @param string $message Error message
     * @param string $file File name
     * @param int $line Line number
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler
     * @param Exception $exception The exception
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        // Set HTTP response code.
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);
        // Show or hide error in browser.
        if (\App\Config::SHOW_ERRORS) {
            echo "<h1>Error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {
            View::render("$code.php");
        }
        // Active or disable logging to file
        if (\App\Config::ACTIVE_LOG) {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);
            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= "with Message: '" . $exception->getMessage() . "'";
            $message .= "\nStack trace:" . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();
            error_log($message);
        }
    }

}

?>