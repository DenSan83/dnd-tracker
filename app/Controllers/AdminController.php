<?php

namespace app\Controllers;

use app\Models\AdminModel;
use app\Models\ConfModel;

class AdminController extends Controller
{
    public function adminLogin()
    {
        $tpl = 'admin';

        // If login request
        if (isset($_POST['admin'])) {
            $adminModel = new AdminModel();
            if (!$adminUser = $adminModel->findAdmin($_POST['admin']['email'])) {
                $this->redirect('admin', '', [
                    'error' => 'Wrong email'
                ]);
                // TODO: log_error
            }
            if (!password_verify($_POST['admin']['password'], $adminUser['password'])) {
                $this->redirect('admin', '', [
                    'error' => 'Wrong password'
                ]);
                // TODO: log_error
            }

            $_SESSION['admin'] = $adminUser['email'];
            // TODO: log
            $this->redirect('admin');
        }

        // If an admin is logged in
        if (!isset($_SESSION['admin'])) {
            $this->view->load('admin-login', []);
            exit;
        }

        $confModel = new ConfModel();
        $data = $confModel->getConf();
        $this->view->load('admin', [
            'conf' => $data
        ]);
    }

}