<?php

namespace app\Models;

use PDO;

class AdminModel extends Model
{
    public function findAdmin(string $email)
    {
        $req = $this->db()->prepare("
            SELECT * FROM admin WHERE email = :email
        ");
        $req->bindValue(':email', $email);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC);
    }

}