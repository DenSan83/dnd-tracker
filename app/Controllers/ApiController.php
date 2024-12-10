<?php

namespace app\Controllers;

use app\Models\CharacterModel;

class ApiController extends Controller
{
    public function apiManager($parameters)
    {
        if ($parameters[0] == 'spells') {
            $this->apiSpells($_GET['query']);
        }
    }

    public function apiSpells($parameters)
    {
        $CharacterModel = new CharacterModel();
        $spells = $CharacterModel->findSpellByName($parameters);
        echo json_encode($spells);
        exit();
    }

}