<?php

namespace app\Controllers;

use app\Models\CharacterModel;

class HomeController extends Controller
{
    public function home()
    {
        $homeTpl = 'offline-home';
        if (isset($_SESSION['character'])) {
            $homeTpl = 'online-home';
        } else if (CONF['allow_login']['conf_value'] === '1') {
            $this->redirect('login');
        }

        // Get players list (ordered by initiative)
        $characterModel = new CharacterModel();
        $characterList = $characterModel->getAll('initiative');
        // Get current turn
        $turn = $this->getCurrentTurn();
        // Get my character image and description
        $myCharacter = $_SESSION['character'];


        $this->view->load($homeTpl, [
            'character_list' => $characterList,
            'turn' => $turn,
            'my_character' => $myCharacter,
        ]);
    }

    public function getCurrentTurn()
    {
        $characterModel = new CharacterModel();
        return $characterModel->getInitiativeList();
    }

}