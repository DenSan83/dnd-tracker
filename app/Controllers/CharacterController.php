<?php

namespace app\Controllers;

use app\Models\CharacterModel;
use app\Models\OnlineModel;

class CharacterController extends Controller
{
    private array $subRoutes = [
        'abilities-and-modifiers' => 'editAbilitiesModifiers',
    ];
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

    public function edit($parameters) {
        if (isset($_SESSION['admin']) && $this->userIdExists($parameters[0])) {
            // edit/{user_id}/{subroute}/{params}
            // TODO: admin_log
            var_dump($parameters);
        } else if (array_key_exists($parameters[0], $this->subRoutes)) {
            // edit/{subroute}/{params}
            // TODO: admin_log: (here or in every submethod?)
            $subroute = $parameters[0];
            unset($parameters[0]);
            $parameters = array_values($parameters);
            $this->{$this->subRoutes[$subroute]}($parameters);
        } else {
            $this->redirect('404');
        }
    }

    public function userIdExists(int $id)
    {
        $CharacterModel = new CharacterModel();
        return $CharacterModel->userIdExists($id);
    }

    public function editAbilitiesModifiers()
    {
        var_dump('abilities and modif');
        // TODO: -create a view,
        // - save and edit abilities and modifiers
        // - create column for this data (save as string? json?)
    }
}