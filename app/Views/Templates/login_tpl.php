<?php

if (isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
    echo 'Welcome '.$character->getName();
    echo '<br>';
    echo '<pre>';
    print_r($character);
    echo '</pre>';
    echo '<a href="'.HOST.'/logout">Logout</a>';
} else {
    foreach ($data['characters'] as $character) {
        echo '<a href="login?character='.$character->getId().'">'.$character->getName().'</a>';
    }
    echo '<br>';
    echo 'Please login';
}
