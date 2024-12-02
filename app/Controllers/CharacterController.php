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
        if (isset($_GET['id'])) {
            $onlineModel->setOffline($_GET['id']);
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

    public function setCharModifiers(string $key, array $content)
    {
        $myMods = $_SESSION['character']->getCharModifiers();
        $myMods[$key] = $content;

        $_SESSION['character']->setCharModifiers($myMods);
        $CharacterModel = new CharacterModel();
        $CharacterModel->setCharModifiers($_SESSION['character']->getId(), json_encode($myMods));
    }

    public function editAbilitiesModifiers()
    {
        if (isset($_POST['ability'])) {
            $ability = $_POST['ability'];
            $this->setCharModifiers('abilities', $ability);
            // TODO log
            // TODO: return success message
        }

        $abilities = $modifiers = [];
        if (array_key_exists('abilities', $_SESSION['character']->getCharModifiers())) {
            $abilities = $_SESSION['character']->getCharModifiers()['abilities'];
            $modifiersMap = [
                1=>'-5', 2=>'-4', 3=> '-4', 4 => '-3',5=> '-3',6=>'-2',7=> '-2',8=> '-1',9=> '-1',10=> '0',
                11=> '0',12=> '+1',13=> '+1',14=> '+2',15=> '+2',16=> '+3',17=> '+3',18=> '+4',19=> '+4',20=>'+5'
            ];

            foreach ($abilities as $key => $ability) {
                $modifiers[$key] = $modifiersMap[$ability];
            }
        }

        $this->view->load('edit_abilities-and-modifiers', [
            'abilities' => $abilities,
            'modifiers' => $modifiers
        ]);
    }
}