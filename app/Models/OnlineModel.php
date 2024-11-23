<?php

namespace app\Models;

use PDO;

class OnlineModel extends Model
{
    public function setOnline(int $id, string $name)
    {
        $req = $this->db()->prepare("
            INSERT INTO online (character_id, name) VALUES (:character_id, :name)
        ");
        $req->bindValue(':character_id', $id);
        $req->bindValue(':name', $name);
        $req->execute();
    }

    public function setOffline(int $id)
    {
        $req = $this->db()->prepare("
            DELETE FROM online WHERE character_id = :character_id
        ");
        $req->bindValue(':character_id', $id);
        $req->execute();
    }

    public function checkIfOnline(int $id)
    {
        $req = $this->db()->prepare("
            SELECT COUNT(*) AS num FROM online WHERE character_id = :character_id
        ");
        $req->bindValue(':character_id', $id);
        $req->execute();

        return (bool) $req->fetch(PDO::FETCH_ASSOC)['num'];
    }

}