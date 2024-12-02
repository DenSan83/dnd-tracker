<?php

namespace app\Models;

use app\Models\Entities\Character;
use PDO;

class CharacterModel extends Model
{
    private $defaultImage = 'image';
    public function getAll($order = 'name')
    {
        $wherePlayers = '';
        if ($order === 'name') $wherePlayers = ' WHERE type = "player"';
        if ($order === 'initiative') $wherePlayers = ' WHERE initiative <> 0';
        $req = $this->db()->prepare("
            SELECT * FROM characters $wherePlayers
            ORDER BY $order
        ");
        $req->execute();
        $results = $req->fetchAll(PDO::FETCH_ASSOC);
        $characters = [];
        foreach ($results as $result) {
            $characters[$result['id']] = new Character(
                $result['id'],
                $result['name'],
                $result['image'] ?? $this->defaultImage,
                $result['data'],
                $result['max_health'],
                $result['cur_health'],
                $result['char_modifiers'],
                $result['initiative'],
                $result['role'],
                $result['type'],
                $result['owner'],
            );
        }

        return $characters;
    }

    public function getInitiativeList()
    {
        $req = $this->db()->prepare("
            SELECT id, initiative, name, image FROM characters
            ORDER BY initiative DESC
        ");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_UNIQUE|PDO::FETCH_ASSOC);
    }

    public function userIdExists(int $id)
    {
        $req = $this->db()->prepare("
            SELECT COUNT(*) FROM characters
            WHERE id = :id
        ");
        $req->bindValue(':id', $id);
        $req->execute();

        return (bool) $req->fetch(PDO::FETCH_ASSOC)['COUNT'];
    }

    /**
     * @param int $id user_id
     * @param string $charModifiers is an array transformed to json
     * @return mixed
     */
    public function setCharModifiers(int $id, string $charModifiers)
    {
        $req = $this->db()->prepare("
            UPDATE characters
            set char_modifiers = :char_modifiers
            WHERE id = :id
        ");
        $req->bindValue(':id', $id);
        $req->bindValue(':char_modifiers', $charModifiers);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC);
    }

}