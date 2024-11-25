<?php

if (isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
    echo 'Welcome '.$character->getName();
    echo '<a href="'.HOST.'/logout">Logout</a>';
}
//    foreach ($data['characters'] as $character) {
//        echo '<a href="login?character='.$character->getId().'">'.$character->getName().'</a>';
//    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./public/css/login.css">
    </head>
    <body>
        <div class="navbar">
            <div class="container">
                <h1>Please login</h1>
            </div>
        </div>
        <div class="container">
            <div class="row character-block">
                <?php foreach ($data['characters'] as $character) { ?>
                    <div class="col-6 col-md-3 p-2">
                        <a href="login?character=<?= $character->getId() ?>">
                            <div class="card character-card">
                                <div class="char-wrapper">
                                    <img src="./public/images/frame.webp" class="frame">
                                    <img src="./uploads/<?= $character->getImage() ?>" class="avatar">
                                </div>
                                <span class="text-success">
                                    <?= $character->getName() ?>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>