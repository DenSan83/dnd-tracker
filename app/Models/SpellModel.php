<?php

namespace app\Models;

use PDO;

class SpellModel extends Model
{
    public function getSpellById(int $id)
    {
        $req = $this->db()->prepare("
            SELECT * FROM spells
            WHERE id = :id
        ");
        $req->bindValue(':id', $id);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }
}