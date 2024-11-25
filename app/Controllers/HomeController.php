<?php

namespace app\Controllers;

class HomeController extends Controller
{
    public function home()
    {
        if (CONF['allow_login']['conf_value'] === '1') {
            $this->redirect('login');
        }

        // message "No game is available atm"
        $data = [];
        $this->view->load('home', $data);
    }

}