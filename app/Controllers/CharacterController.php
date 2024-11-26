<?php

namespace app\Controllers;

use app\Models\CharacterModel;
use app\Models\OnlineModel;

class CharacterController extends Controller
{
    public function login($data)
    {
        // 1. find all characters and serve them
        $CharacterModel = new CharacterModel();
        $characters = $CharacterModel->getAll();

        // 2. if theres a request, create session
        $onlineModel = new OnlineModel();
        if (isset($_GET['character']) &&
            array_key_exists($_GET['character'], $characters) &&
            !$onlineModel->checkIfOnline($_GET['character']))
        {
            $character = $characters[$_GET['character']];
            $_SESSION['character'] = $character;
            // set online
            $onlineModel->setOnline($character->getId(), $character->getName());
            // TODO: log
            $this->redirect('');
        }

        $data = ['characters' => $characters];
        $this->view->load('login', $data);
    }

    public function logout()
    {
        session_destroy();
        // set offline
        if (isset($_SESSION['character'])) {
            $onlineModel = new OnlineModel();
            $onlineModel->setOffline($_SESSION['character']->getId());
            unset($_SESSION);
        }

        // TODO: log
        $this->redirect('');
    }

}