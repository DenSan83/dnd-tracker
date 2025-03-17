<?php

namespace app\Controllers;

use app\Models\CharacterModel;

class ApiController extends Controller
{
    /*
     * This function is called via Ajax
     */
    public function apiManager($parameters)
    {
        if ($parameters[0] == 'spells') {
            $this->apiSpells($_GET['query']);
        } else
        if ($parameters[0] == 'update-mana') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->apiUpdateMana($data);
            } else {
                echo json_encode(['error' => true, 'message' => 'Error decoding JSON: ' . json_last_error_msg()]);
            }
        }
    }

    public function apiSpells($parameters)
    {
        $CharacterModel = new CharacterModel();
        $spells = $CharacterModel->findSpellByName($parameters);
        echo json_encode($spells);
        exit();
    }

    public function apiUpdateMana($parameters)
    {
        // TODO: save used mana slots before pushing
        $characterController = new CharacterController();
        $characterController->setCharModifiers('mana_count', $parameters['mana_count']);
        var_dump($parameters['mana_count']);exit;
        exit;
    }

}