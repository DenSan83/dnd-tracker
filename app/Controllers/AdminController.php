<?php

namespace app\Controllers;

use app\Models\AdminModel;

class AdminController extends Controller
{
    public function adminLogin()
    {
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
            $this->redirect('');
        }

        $data = [];
        $this->view->load('admin', $data);
    }

}