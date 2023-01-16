<?php 

namespace App\Models;

use PDO;

/**
 * Post model
 */

class Post extends \Core\Model
{

    /**
     * Get all posts as array
     * @return array
     */
    public static function getAll()
    {
        try {
            $db = static::getDB();
            $stmt = $db->query('SELECT id, title, content FROM posts ORDER BY created_time');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMeesage();
        }
    }   

}

?>