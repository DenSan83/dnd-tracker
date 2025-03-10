<?php

namespace app\Models;

use PDO;

class ConfigModel extends Model
{
    public function getConfigSpellColumns()
    {
        $req = $this->db()->prepare("
            SELECT conf_value FROM config
            WHERE conf_key = 'spell_columns'
        ");
        $req->execute();
        return $req->fetch(PDO::FETCH_COLUMN);
    }

}