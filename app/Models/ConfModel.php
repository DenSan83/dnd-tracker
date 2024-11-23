<?php

namespace app\Models;

use PDO;

class ConfModel extends Model
{
    public function getConf()
    {
        $req = $this->db()->prepare("
            SELECT conf_key, conf_value, visibility FROM config
        ");
        $req->execute();

        return $req->fetchAll(PDO::FETCH_UNIQUE|PDO::FETCH_ASSOC);
    }

}