<?php

namespace app\Controllers;

use app\Models\CharacterModel;

class CharacterController extends Controller
{
    public function login($data)
    {
        // 1. find all characters and serve them
        $CharacterModel = new CharacterModel();
        $characters = $CharacterModel->getAll();

        // 2. if theres a request, create session
        if (isset($_GET['character']) && array_key_exists($_GET['character'], $characters)) {
            $_SESSION['character'] = $characters[$_GET['character']];
            // log
        }

        $data = ['characters' => $characters];
        $this->view->load('login', $data);
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION);
        // log
        $this->redirect('login');
    }

}