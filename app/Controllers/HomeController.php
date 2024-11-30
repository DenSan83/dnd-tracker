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

        //-Aside fields:
        // attacks (cantrip, lvl1, lvl2),
        // (class,race,bg,alignment),
        // appearance,
        // backstory,

        //-Stats
        // Ability scores + modifiers(str,dex,con,int,wis,cha),
        // skills,
        // features (by class) + feats
        // "other proficiencies & languages",

        //-Backpack:
        // inventory,

        //-Sword
        // equipment+armor,

    }

    public function getCurrentTurn()
    {
        $characterModel = new CharacterModel();
        return $characterModel->getInitiativeList();
    }

}