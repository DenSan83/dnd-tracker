<?php

namespace app\Models;

use PDO;
use PDOException;

class Model
{
    public function db(): PDO
    {
        return new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    }

    public function dbConnect()
    {
        try {
            $db = $this->db();
            $req = $db->prepare("
                SELECT * FROM characters
            ");
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}