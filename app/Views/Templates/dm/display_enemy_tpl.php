<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DnD Tracker - Enemies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=HOST?>/public/css/online-home.css">
    <link rel="stylesheet" href="<?=HOST?>/public/css/edit-enemy.css">
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

<?php include_once getcwd(). '/app/Views/Templates/partials/dm-home-sidebar_tpl.php'; ?>

<div class="content content-home text-center mb-5">
    <div class="title px-5">
        <h2><?= $data['enemy']->getName() ?></h2>
    </div>
    <div class="row">
        <div class="col-4">
            <p>
                <b>Race:</b> <?= $data['enemy_data']['race'] ?><br>
                <b>Type:</b> <?= $data['enemy_data']['type'] ?><br>
                <b>Visibility:</b> <?php
                    if ($data['enemy_data']['show'] === 'true') {  ?>
                        <label class="btn btn-success btn-sm" for="btndeploy">Deployed</label>
                    <?php } else { ?>
                        <label class="btn btn-secondary btn-sm" for="btnhide">Hidden</label>
                    <?php } ?>
            </p>
        </div>
        <div class="col-8 row tabled">
            <div class="col-4">
                <div><b>HP</b></div>
                <div>
                    <?php
                        $percent = $data['enemy']->getCurHealth() / $data['enemy']->getMaxHealth() * 100;
                        $color = (isset($data['enemy_data']['hp_is_visible']) && $data['enemy_data']['hp_is_visible'] === 1) ? 'success' : 'secondary';
                    ?>
                    <div class="progress charlist-hp" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-<?= $color ?> progress-bar-animated" style="width: <?= $percent ?>%"></div>
                    </div>
                    <?= $data['enemy']->getCurHealth() ?>/
                    <?= $data['enemy']->getMaxHealth() ?>
                </div>
            </div>
            <div class="col">
                <div><b>Def</b></div>
                <div><?= $data['enemy']->getCharModifiers()['def'] ?></div>
            </div>
            <div class="col">
                <div><b>Speed</b></div>
                <div><?= $data['enemy']->getCharModifiers()['speed'] ?></div>
            </div>
            <div class="col">
                <div><b>Sense</b></div>
                <div><?= $data['enemy']->getCharModifiers()['sense'] ?></div>
            </div>
            <div class="col">
                <div><b>Weak</b></div>
                <div><?= $data['enemy']->getCharModifiers()['weak'] ?></div>
            </div>
            <div class="col">
                <div><b>Save</b></div>
                <div><?= $data['enemy']->getCharModifiers()['save'] ?></div>
            </div>
            <div class="col">
                <div><b>Accu</b></div>
                <div><?= $data['enemy']->getCharModifiers()['accu'] ?></div>
            </div>
            <div class="col">
                <div><b>Cast</b></div>
                <div><?= $data['enemy']->getCharModifiers()['cast'] ?></div>
            </div>
            <div class="col">
                <div><b>Level</b></div>
                <div><?= $data['enemy']->getCharModifiers()['level'] ?></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <a href="<?= HOST . '/dm/edit-enemy/'.$data['enemy']->getId() ?>">
                <img src="<?= HOST . $data['enemy']->getImage() ?>" class="icon-view-image border border-primary rounded mb-2" />
            </a>
        </div>
        <div class="col-8 text-start">
            <br>
            <b>Attack:</b><br>
            <?= $data['enemy_data']['attack'] ?><br>
            <b>Spells:</b><br>
            <?= $data['enemy_data']['spells'] ?><br>
            <b>Speciality:</b><br>
            <?= $data['enemy_data']['speciality'] ?><br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="tabled d-flex">
                <div class="col">
                    <div><b>Str</b></div>
                    <div><?= $data['enemy']->getCharModifiers()['str'] ?></div>
                </div>
                <div class="col">
                    <div><b>Dex</b></div>
                    <div><?= $data['enemy']->getCharModifiers()['dex'] ?></div>
                </div>
                <div class="col">
                    <div><b>Con</b></div>
                    <div><?= $data['enemy']->getCharModifiers()['con'] ?></div>
                </div>
                <div class="col">
                    <div><b>Int</b></div>
                    <div><?= $data['enemy']->getCharModifiers()['int'] ?></div>
                </div>
                <div class="col">
                    <div><b>Wis</b></div>
                    <div><?= $data['enemy']->getCharModifiers()['wis'] ?></div>
                </div>
                <div class="col">
                    <div><b>Cha</b></div>
                    <div><?= $data['enemy']->getCharModifiers()['cha'] ?></div>
                </div>
            </div>
            <div class="text-start">
                <br>
                <b>Initiative:</b><br>
                <?= $data['enemy']->getInitiative() ?><br>
                <b>Alignment:</b><br>
                <?= $data['enemy_data']['alignment'] ?><br>
                <b>Traits:</b><br>
                <?= $data['enemy_data']['traits'] ?><br>
            </div>

        </div>
        <div class="col-8 text-start border border-secondary">
            <b>Resistance:</b><br>
            <?= $data['enemy_data']['resistance'] ?><br>
            <b>Immunity:</b><br>
            <?= $data['enemy_data']['immunity'] ?><br>
            <b>Loot:</b><br>
            <?= $data['enemy_inventory']['loot'] ?><br>
            <b>Special loot:</b><br>
            <?= $data['enemy_inventory']['sp_loot'] ?><br>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>