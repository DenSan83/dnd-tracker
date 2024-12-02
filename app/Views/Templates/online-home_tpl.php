<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DnD Tracker - Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=HOST?>/public/css/online-home.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a class="navbar-brand text-light fw-bold" href="<?= HOST ?>/">D&D Tracker</a>
        <div class="" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item">
                    <a href="#" class="nav-link me-2 text-light" id="sidebarToggle" aria-label="Toggle navigation">
                        Turn
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= HOST ?>/logout?id=<?= $_SESSION['character']->getId() ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="sidebar d-lg-block bg-light border-end p-1" id="sidebar">
    <div class="d-flex justify-content-end">
        <button id="closeSidebar" class="btn">
            <span>&times;</span>
        </button>
    </div>

    <a href="<?= HOST ?>/edit/abilities-and-modifiers" class="ability-scores">
        <div class="row flex-nowrap justify-content-center mb-2">
            <div class="col-4 col-str">
                <b class="mb-2">Str</b>
                <span class="text-center m-1 mb-2"><?= $data['abilities']['str'] ?? '10' ?></span>
                <span class="modifier"><?= $data['modifiers']['str'] ?? '0' ?></span>
            </div>
            <div class="col-4 col-dex">
                <b class="mb-2">Dex</b>
                <span class="text-center m-1 mb-2"><?= $data['abilities']['dex'] ?? '10' ?></span>
                <span class="modifier"><?= $data['modifiers']['dex'] ?? '0' ?></span>
            </div>
            <div class="col-4 col-con">
                <b class="mb-2">Con</b>
                <span class="text-center m-1 mb-2"><?= $data['abilities']['con'] ?? '10' ?></span>
                <span class="modifier"><?= $data['modifiers']['con'] ?? '0' ?></span>
            </div>
        </div>
        <div class="row flex-nowrap justify-content-center mb-2">
            <div class="col-4 col-int">
                <b class="mb-2">Int</b>
                <span class="text-center m-1 mb-2"><?= $data['abilities']['int'] ?? '10' ?></span>
                <span class="modifier"><?= $data['modifiers']['int'] ?? '0' ?></span>
            </div>
            <div class="col-4 col-wis">
                <b class="mb-2">Wis</b>
                <span class="text-center m-1 mb-2"><?= $data['abilities']['wis'] ?? '10' ?></span>
                <span class="modifier"><?= $data['modifiers']['wis'] ?? '0' ?></span>
            </div>
            <div class="col-4 col-cha">
                <b class="mb-2">Cha</b>
                <span class="text-center m-1 mb-2"><?= $data['abilities']['cha'] ?? '10' ?></span>
                <span class="modifier"><?= $data['modifiers']['cha'] ?? '0' ?></span>
            </div>
        </div>
    </a>


    <!---->
    <div class="accordion" id="my-data">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_1" aria-controls="collapse_1">
                    Cantrips
                </button>
            </h2>
            <div id="collapse_1" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="d-block">
                        <p>
                            Payé par : <span>Dennis</span>
                        </p>
                        <p>
                            Prochain date : <span>2024-10-03</span>
                        </p>
                        <p>
                            Fréquence : <span>monthly</span>
                        </p>
                        <p>
                            Actif : <span>oui</span>
                        </p>
                        <div>
                            <button class="btn btn-success add-recurrent">
                                Modifier &gt;&gt;
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_2" aria-controls="collapse_2">
                    Level 1 attacks
                </button>
            </h2>
            <div id="collapse_2" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="d-block">
                        <p>
                            Payé par : <span>Dennis</span>
                        </p>
                        <p>
                            Prochain date : <span>2024-10-03</span>
                        </p>
                        <p>
                            Fréquence : <span>monthly</span>
                        </p>
                        <p>
                            Actif : <span>oui</span>
                        </p>
                        <div>
                            <button class="btn btn-success add-recurrent">
                                Modifier &gt;&gt;
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_3" aria-controls="collapse_3">
                    Level 2 attacks
                </button>
            </h2>
            <div id="collapse_3" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="d-block">
                        <p>
                            Payé par : <span>Dennis</span>
                        </p>
                        <p>
                            Prochain date : <span>2024-10-03</span>
                        </p>
                        <p>
                            Fréquence : <span>monthly</span>
                        </p>
                        <p>
                            Actif : <span>oui</span>
                        </p>
                        <div>
                            <button class="btn btn-success add-recurrent">
                                Modifier &gt;&gt;
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_0" aria-controls="collapse_0">
                    Other
                </button>
            </h2>
            <div id="collapse_0" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="d-block">
                        <?= nl2br($data['my_character']->getData()) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!---->



</div>

<div class="content content-home text-center">
    <div class="title px-5">
        <h2><?= $data['my_character']->getName() ?></h2>
        Max HP: <?= $data['my_character']->getMaxHealth() ?>
        <?php $width = 50; ?>
        <a href="">
            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" style="width: <?= $width/$data['my_character']->getMaxHealth() *100 ?>%"><?= $width ?></div>
            </div>
        </a>
    </div>
    <div class="container contains-image">
        <img src="./uploads/<?= $data['my_character']->getImage() ?>" class="character_image">
    </div>
    <div class="turns px-5">
        <div class="row d-flex flex-nowrap">
            <?php foreach (array_reverse($data['character_list']) as $character) { ?>
                <div class="col turn-<?= $character->getId() ?>">
                    <span>(<?= $character->getInitiative() ?>)</span>
                    <img src="./uploads/<?= $character->getImage() ?>"/>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#sidebarToggle').click(function() {
            $('#sidebar').toggle();
            $('.content').toggleClass('ml-0');
        });

        $('#closeSidebar').click(function() {
            $('#sidebar').hide();
            $('.content').addClass('ml-0');
        });
    });
</script>

</body>
</html>