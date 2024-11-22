<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$appEnv = $_ENV['APP_ENV'];

echo 'under construction';