<?php
use app\enum\Role;
?>
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
        <a class="navbar-brand text-light fw-bold" href="<?= HOST ?>">D&D Tracker</a>
        <div class="" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item">
                    <a href="#" class="nav-link me-2 text-light" id="sidebarToggle" aria-label="Toggle navigation">
                        Sidebar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= HOST ?>/logout?id=<?= $_SESSION['character']->getId() ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php
    // Sidebar
    if ($data['my_character']->getRole() === Role::DM->value) {
        include_once 'partials/dm-home-sidebar_tpl.php';
    } else {
        include_once 'partials/online-home-sidebar_tpl.php';
    }
?>

<div class="content content-home text-center">
    <div class="title px-5">
        <h2><?= $data['my_character']->getName() ?></h2>
        <?php if ($data['my_character']->getRole() !== Role::DM->value) { ?>
            Max HP: <?= $data['hpData']['maxHealth'] ?>
            <?php $curHealth = $data['hpData']['curHealth']; ?>
            <a href="<?= HOST ?>/edit/hp" class="text-decoration-none">
                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-striped bg-<?= $data['hpData']['currentColor'] ?> progress-bar-animated"
                         style="width: <?= $data['hpData']['percent'] ?>%"><?= $data['hpData']['curHealth'] ?></div>
                </div>
            </a>
        <?php } ?>
    </div>
    <div class="container contains-image position-relative">
        <img src="./uploads/<?= $data['my_character']->getImage() ?>" class="character_image">
        <?php if ($data['my_character']->getRole() !== Role::DM->value) { ?>
            <img src="./public/images/armor.png" class="btn btn-outline-secondary equipment-btn" data-bs-toggle="modal" data-bs-target="#equipmetModal">
            <!-- Modal equipment -->
            <div class="modal fade" id="equipmetModal" tabindex="-1" aria-labelledby="equipmetModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="equipmetModalLabel">Equipment
                                <a href="<?= HOST ?>/edit/inventory" class="text-dark"><?= ICONS['gear'] ?></a>
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="text-start">
                                <?php
                                if (!empty($data['inventory']) && !empty($data['inventory']['equipment'])) {
                                    foreach ($data['inventory']['equipment'] as $slot => $equipment) { ?>
                                        <li>
                                            [<?= ucfirst($slot) ?>]
                                            <b><?= $equipment['name'] ?></b>:
                                            <?= $equipment['description'] ?>
                                        </li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal equipment -->
        <?php } ?>
    </div>

    <div class="turns px-5">
        <div class="row d-flex flex-nowrap">
            <?php foreach (array_reverse($data['character_list']) as $character) {
                $possibleColors = ['success', 'warning', 'danger'];
                $charPercent = $character->getCurHealth()/$character->getMaxHealth() *100;
                $curColor = $possibleColors[0];
                if ($charPercent < 50 && $charPercent > 10) {
                    $curColor = $possibleColors[1];
                } else if ($charPercent <= 10) {
                    $curColor = $possibleColors[2];
                }

                if ($character->getRole() === Role::NPC->value) {
                    $hpIsVisible = json_decode($character->getData(), true)['hp_is_visible'];
                    $show = json_decode($character->getData(), true)['show'];
                    if ($show === 'true'){ ?>
                    <div class="col turn-<?= $character->getId() ?>">
                        <?php if ($hpIsVisible) { ?>
                        <div class="progress charlist-hp" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-<?= $curColor ?> progress-bar-animated"
                                 style="width: <?= $charPercent ?>%"></div>
                        </div>
                        <?php } else { ?>
                            <div class="progress charlist-hp" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-secondary progress-bar-animated"
                                     style="width: 100%">?</div>
                            </div>
                        <?php } ?>
                        <div class="initiative-circle"><?= $character->getInitiative() ?></div>
                        <span>---</span>
                        <img src="<?= HOST . '/' . $character->getImage() ?>"/>
                    </div>
                <?php }} else { ?>
                <div class="col turn-<?= $character->getId() ?>">
                    <div class="progress charlist-hp" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-<?= $curColor ?> progress-bar-animated"
                             style="width: <?= $charPercent ?>%"></div>
                    </div>
                    <div class="initiative-circle">
                        <?= $character->getInitiative() ?>
                    </div>
                    <span>---</span>
                    <img src="./uploads/<?= $character->getImage() ?>"/>
                </div>
            <?php }} ?>
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