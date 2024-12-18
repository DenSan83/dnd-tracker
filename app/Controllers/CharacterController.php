<?php

namespace app\Controllers;

use app\Models\CharacterModel;
use app\Models\OnlineModel;

class CharacterController extends Controller
{
    private $model;
    public function __construct()
    {
        parent::__construct();
        $characterModel = new CharacterModel();
        $this->model = $characterModel;
    }

    private array $subRoutes = [
        'abilities-and-modifiers' => 'editAbilitiesModifiers',
        'about' => 'editAbout',
        'spells' => 'editSpells',
        'skills' => 'editSkills',
        'inventory' => 'editInventory',
        'other' => 'editOther',
    ];
    public function login($data)
    {
        // 1. find all characters and serve them
        $characters = $this->model->getAll();

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
            $onlineModel = new OnlineModel();
            $onlineModel->setOffline($_GET['id']);
        }

        // TODO: log
        $this->redirect('');
    }

    public function edit($parameters) {
        if (isset($_SESSION['admin']) && $this->model->userIdExists($parameters[0])) {
            // edit/{user_id}/{subroute}/{params}
            // TODO: admin_log
            var_dump($parameters);
        } else if (isset($_SESSION['character']) && array_key_exists($parameters[0], $this->subRoutes)) {
            // edit/{subroute}/{params}
            // TODO: admin_log: (here or in every submethod?)
            $subroute = $parameters[0];
            unset($parameters[0]);
            $parameters = array_values($parameters);
            $this->{$this->subRoutes[$subroute]}($parameters);
        } else if (!isset($_SESSION['character'])) {
            $this->redirect('');
        } else {
            $this->redirect('404');
        }
    }

    public function setCharModifiers(string $key, array $content)
    {
        $myMods = $_SESSION['character']->getCharModifiers();
        $myMods[$key] = $content;

        $_SESSION['character']->setCharModifiers($myMods);
        $this->model->setCharModifiers($_SESSION['character']->getId(), json_encode($myMods));
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
        if (isset($_SESSION['character']) && array_key_exists('abilities', $_SESSION['character']->getCharModifiers())) {
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

    public function editAbout()
    {
        if (isset($_POST['about'])) {
            $ability = $_POST['about'];
            $this->setCharModifiers('about', $ability);

            $initiative = $ability['initiative'] ? $ability['initiative'] : 0;
            $_SESSION['character']->setInitiative($initiative);
            $this->model->setInitiative($_SESSION['character']->getId(), $initiative);
            // TODO: log
            // TODO: return success message
        }

        $clases = $this->model->getApiData('classes')['results'];
        $about = [];
        if (isset($_SESSION['character']) && array_key_exists('about', $_SESSION['character']->getCharModifiers())) {
            $about = $_SESSION['character']->getCharModifiers()['about'];
        }

        $this->view->load('edit_about', [
            'classes' => $clases,
            'about' => $about
        ]);
    }

    public function editSpells()
    {
        $spellsIds = [];
        if (isset($_SESSION['character']) && array_key_exists('spells', $_SESSION['character']->getCharModifiers())) {
            $spellsIds = $_SESSION['character']->getCharModifiers()['spells'];
            sort($spellsIds);
        }
        if (isset($_POST['spell'])) {
            $spellId = $_POST['spell']['find'];
            $spellsIds[] = $spellId;
            $this->setCharModifiers('spells', $spellsIds);
            // TODO log
            // TODO: return success message
        }

        $spellsByLevel = [];
        foreach ($spellsIds as $spellId) {
            $thisSpell = $this->model->getSpellById($spellId);
            $level = ($thisSpell['level'] === 0) ? 'Cantrips' : 'Level '.$thisSpell['level'];
            $spellsByLevel[$level][] = $thisSpell;
        }


        $this->view->load('edit_spells', [
            'spells_by_level' => $spellsByLevel
        ]);
    }

    public function editSkills()
    {
        $skills = [];
        if (isset($_SESSION['character']) && array_key_exists('skills', $_SESSION['character']->getCharModifiers())) {
            $skills = $_SESSION['character']->getCharModifiers()['skills'];
            //sort($spellsIds);
        }
        if (isset($_POST['skill'])) {
            $skill = [
                'name' => $_POST['skill']['name'],
                'link' => $_POST['skill']['link']
            ];
            $skills[] = $skill;
            $this->setCharModifiers('skills', $skills);
            // TODO log
            // TODO: return success message
        }

        $this->view->load('edit_skills', [
            'skills' => $skills
        ]);
    }

    public function editInventory()
    {
        $this->view->load('edit_inventory', []);
    }

    public function editOther()
    {
        // Get data
        $data = [];
        if (isset($_SESSION['character'])) {
            $data = $_SESSION['character']->getData();
        }
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
            $_SESSION['character']->setData($data);
            $this->model->setCharData($_SESSION['character']->getId(), $data);
            // TODO log
            // TODO: return success message
        }

        $this->view->load('edit_other', [
            'data' => $data
        ]);
    }
}