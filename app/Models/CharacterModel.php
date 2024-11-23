<?php

namespace app\Models;

use app\Models\Entities\Character;
use PDO;

class CharacterModel extends Model
{
    private $defaultImage = 'image';
    public function getAll()
    {
        $req = $this->db()->prepare("
            SELECT * FROM characters
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

}