<?php

namespace app\Controllers;

use app\enum\Role;
use app\Models\CharacterModel;

class DMController extends Controller
{
    private $model;

    private array $subRoutes = [
        'new-enemy' => 'newEnemy',
        'see-enemy' => 'seeEnemy',
        'edit-enemy' => 'editEnemy',
        'clone-enemy' => 'cloneEnemy',
        'delete-enemy' => 'deleteEnemy',
    ];

    public function __construct()
    {
        parent::__construct();
        $characterModel = new CharacterModel();
        $this->model = $characterModel;
    }

    public function dmRoutes($parameters)
    {
        if (isset($_SESSION['character'])
            && $_SESSION['character']->getRole() === Role::DM->value
            && array_key_exists($parameters[0], $this->subRoutes)) {
            // dm/{subroute}/{params}
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

    public function seeEnemy($params)
    {
        $enemies = $this->model->getEnemies();
        $enemyId = (int)$params[0];
        $enemy = $this->model->getEnemyById($enemyId);
        $enemyData = json_decode($enemy->getData(), true);
        $enemyInventory = $this->model->getInventoryFromCharacter($enemy->getId());

        $this->view->load('dm/display_enemy', [
            'enemies' => $enemies,
            'enemy' => $enemy,
            'enemy_data' => $enemyData,
            'enemy_inventory' => $enemyInventory,
        ]);
    }

    public function newEnemy()
    {
        // TODO: add uploaded icons to the list [before] the other icons
        $data['enemy_uploaded_icons'] = [];
        $data['uploaded_icons_route'] = '/uploads/enemy-icons/';

        // Default icons
        $data['enemy_def_icons'] = [];
        $data['def_icons_route'] = '/public/images/enemy-icons/';
        for ($i = 1; $i <= 10; $i++) {
            $data['enemy_def_icons'][] = 'mon' . sprintf('%02d', $i) . '.png';
        }

        if (isset($_POST['enemy'])) {
            if (empty($_POST['enemy']['name'])) {
                $this->redirect('dm', '/new-enemy');
            }
            $this->saveEnemyData($_POST['enemy']);
        }

        $data['enemies'] = $this->model->getEnemies();
        $data['action'] = 'Create';

        $this->view->load('dm/edit_enemy', $data);
    }

    public function editEnemy($params)
    {
        $enemies = $this->model->getEnemies();
        $enemy_uploaded_icons = [];
        $uploaded_icons_route = '/uploads/enemy-icons/';
        $enemy_def_icons = [];
        $def_icons_route = '/public/images/enemy-icons/';
        for ($i = 1; $i <= 10; $i++) {
            $enemy_def_icons[] = 'mon' . sprintf('%02d', $i) . '.png';
        }

        $enemyId = (int)$params[0];
        $enemy = $this->model->getEnemyById($enemyId);
        $enemyData = json_decode($enemy->getData(), true);
        $enemyInventory = $this->model->getInventoryFromCharacter($enemy->getId());

        if (isset($_POST['enemy'])) {
            $enemyId = (int)$_POST['enemy']['id'];
            $this->saveEnemyData($_POST['enemy'], $enemyId);

            $this->redirect('dm', '/edit-enemy/' . $enemyId);
        }

        $this->view->load('dm/edit_enemy', [
            'enemy_uploaded_icons' => $enemy_uploaded_icons,
            'uploaded_icons_route' => $uploaded_icons_route,
            'enemy_def_icons' => $enemy_def_icons,
            'def_icons_route' => $def_icons_route,
            'enemies' => $enemies,
            'enemy' => $enemy,
            'enemy_data' => $enemyData,
            'enemy_inventory' => $enemyInventory,
            'action' => 'Edit'
        ]);
    }

    public function cloneEnemy($params)
    {
        $enemies = $this->model->getEnemies();
        $enemy_uploaded_icons = [];
        $uploaded_icons_route = '/uploads/enemy-icons/';
        $enemy_def_icons = [];
        $def_icons_route = '/public/images/enemy-icons/';
        for ($i = 1; $i <= 10; $i++) {
            $enemy_def_icons[] = 'mon' . sprintf('%02d', $i) . '.png';
        }

        $enemyId = (int)$params[0];
        $enemy = $this->model->getEnemyById($enemyId);
        $enemyData = json_decode($enemy->getData(), true);
        $enemyInventory = $this->model->getInventoryFromCharacter($enemy->getId());

        if (isset($_POST['enemy'])) {
            $this->saveEnemyData($_POST['enemy']);

            $this->redirect('');
        }

        $this->view->load('dm/edit_enemy', [
            'enemy_uploaded_icons' => $enemy_uploaded_icons,
            'uploaded_icons_route' => $uploaded_icons_route,
            'enemy_def_icons' => $enemy_def_icons,
            'def_icons_route' => $def_icons_route,
            'enemies' => $enemies,
            'enemy' => $enemy,
            'enemy_data' => $enemyData,
            'enemy_inventory' => $enemyInventory,
            'action' => 'Create'
        ]);
    }

    private function saveEnemyData($enemyData, $enemyId = null): void
    {
        $enemyData['data']['hp_is_visible'] = isset($enemyData['hp_is_visible']) ? 1 : 0;

        if (is_null($enemyId)) { // Create character
            $enemyId = $this->model->createCharacter($enemyData['name'], 'npc', 'enemy', 0, $enemyData['image']);
        } else {
            $this->model->editCharacter($enemyId, $enemyData['name'], $enemyData['image']);
        }

        // Add features
        $this->model->editHP($enemyId, (int)$enemyData['cur_health'], (int)$enemyData['max_health']);
        $this->model->setInitiative($enemyId, (int)$enemyData['initiative']);
        $this->model->setCharModifiers($enemyId, json_encode($enemyData['mod']));
        $this->model->setCharData($enemyId, json_encode($enemyData['data']));
        $this->model->setCharInventory($enemyId, json_encode($enemyData['inventory']));
    }

    public function deleteEnemy($params)
    {
        $enemyId = (int)$params[0];
        $this->model->deleteEnemy($enemyId);

        $this->redirect('');
    }
}