<?php

namespace app\Controllers;

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

        $data = [];
        $this->view->load($homeTpl, $data);
    }

}