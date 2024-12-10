<?php

namespace app\Views;

use http\Exception;

class View
{
    public function load(string $template, array $data = []): void
    {
        $tpl = 'app/Views/Templates/'.$template.'_tpl.php';
        if (!file_exists($tpl)) {
            // TODO: add error_log
            echo 'Template '.$tpl.' not found.';
            exit;
        }
        include_once $tpl;
    }

    public function stringify($string) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9\-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }

}