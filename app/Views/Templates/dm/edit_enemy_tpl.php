<!DOCTYPE html>
<html lang="es">
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

<div class="content content-home text-center">
    <div class="title px-5">
        <?php
        $action = 'Create';
        if (isset($data['enemy'])) {
            $action = 'Edit';
        }
        ?>
        <h2><?= $action ?> Enemy</h2>
    </div>
    <?php
        $route = '/dm/new-enemy';
        if (isset($data['enemy'])) {
            $route = '/dm/edit-enemy/'.$data['enemy']->getId();
        }
    ?>
    <form action="<?= HOST .$route ?>" method="post">
        <div>
            <h5>Icon</h5>
            <ul class="d-flex overflow-x-scroll">
                <?php foreach ($data['enemy_uploaded_icons'] as $key => $icon) { ?>
                    <li></li>
                <?php } ?>
                <?php foreach ($data['enemy_def_icons'] as $key => $icon) { ?>
                    <li>
                        <input type="radio" class="round-check" name="enemy[image]" id="mdi<?= $key ?>" value="<?= $data['def_icons_route']. $icon ?>"
                            <?php
                            $publicRoute = '/public/images/enemy-icons/';
                            if (isset($data['enemy']) && $data['enemy']->getImage() === $publicRoute . $icon) {
                                echo 'checked';
                            } elseif ($key == 0) {
                                echo 'checked';
                            }
                            ?> />
                        <label class="label-check" for="mdi<?= $key ?>"><img src="<?= HOST . $data['def_icons_route']. $icon ?>" class="icon-image" /></label>
                    </li>
                <?php } ?>
            </ul>
            <div class="text-start">
                <button class="btn btn-secondary" type="button" disabled>+ Upload enemy icon</button>
            </div>
        </div>
        <div class="mb-2">
            <input type="hidden" name="enemy[id]" value="<?= isset($data['enemy'])? $data['enemy']->getId() : '';  ?>">
            <span>Name<span class="text-danger">*</span> </span>
            <input type="text" required name="enemy[name]" class="w-100" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getName(); } ?>" />
        </div>
        <div class="row">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="enemy[data][show]" value="true" id="btndeploy" autocomplete="off"
                    <?php if (isset($data['enemy_data']) && $data['enemy_data']['show'] === 'true') { echo 'checked';
                        } elseif (!isset($data['enemy_data'])) { echo 'checked'; }
                    ?>
                >
                <label class="btn btn-outline-success" for="btndeploy">Deploy</label>

                <input type="radio" class="btn-check" name="enemy[data][show]"  value="false" id="btnhide" autocomplete="off"
                    <?php if (isset($data['enemy_data']) && $data['enemy_data']['show'] === 'false') { echo 'checked'; } ?>
                >
                <label class="btn btn-outline-secondary" for="btnhide">Hide</label>
            </div>
        </div>
        <div class="row">
            <div class="col-4 d-flex flex-column align-items-start">
                <span>HP</span>
                <div class="d-flex">
                    <input type="number" name="enemy[max_health]" class="w-50" min="1" placeholder="Maximum" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getMaxHealth(); } else { echo 1; } ?>"/>
                    <input type="number" name="enemy[cur_health]" class="w-50" min="0" placeholder="Current" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCurHealth(); } else { echo 1; } ?>" />
                </div>
                <div class="d-flex mb-2">
                    <input type="checkbox" name="enemy[hp_is_visible]" id="hp-is-visible" class="me-2"
                        <?php if (isset($data['enemy_data']['hp_is_visible']) && $data['enemy_data']['hp_is_visible'] === 1) { echo 'checked'; } ?>
                        <?php if (!isset($data['enemy_data'])) { echo 'checked'; } ?>
                    />
                    <label for="hp-is-visible">Is HP visible?</label>
                </div>

                <span>Initiative</span>
                <input type="number" name="enemy[initiative]" class="w-100" min="0" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getInitiative(); } else { echo 1; } ?>" />
                <span>Race</span>
                <input type="text" name="enemy[data][race]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['race']; } ?>" />
                <span>Type</span>
                <input type="text" name="enemy[data][type]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['type']; } ?>" />
                <span>Alignment</span>
                <input type="text" name="enemy[data][alignment]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['alignment']; } ?>" />
                <span>Traits</span>
                <input type="text" name="enemy[data][traits]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['traits']; } ?>" />
                <span>Resistance</span>
                <input type="text" name="enemy[data][resistance]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['resistance']; } ?>" />
                <span>Immunity</span>
                <input type="text" name="enemy[data][immunity]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['immunity']; } ?>" />
            </div>
            <div class="col-8 d-flex flex-column align-items-start">
                <span>Abilities</span>
                <div class="d-flex">
                    <input type="text" name="enemy[mod][str]" class="w-50 text-center" placeholder="Str" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['str']; } ?>"/>
                    <input type="text" name="enemy[mod][dex]" class="w-50 text-center" placeholder="Dex" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['dex']; } ?>"/>
                    <input type="text" name="enemy[mod][con]" class="w-50 text-center" placeholder="Con" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['con']; } ?>"/>
                </div>
                <div class="d-flex">
                    <input type="text" name="enemy[mod][int]" class="w-50 text-center" placeholder="Int" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['int']; } ?>"/>
                    <input type="text" name="enemy[mod][wis]" class="w-50 text-center" placeholder="Wis" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['wis']; } ?>"/>
                    <input type="text" name="enemy[mod][cha]" class="w-50 text-center" placeholder="Cha" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['cha']; } ?>"/>
                </div>
                <div class="d-flex mt-2">
                    <div class="w-50 text-start">
                        <span>Def</span>
                        <input type="text" name="enemy[mod][def]" class="w-100" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['def']; } ?>"/>
                    </div>
                    <div class="w-50 text-start">
                        <span>Speed</span>
                        <input type="text" name="enemy[mod][speed]" class="w-100" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['speed']; } ?>"/>
                    </div>
                </div>
                <div class="d-flex mt-2">
                    <input type="text" name="enemy[mod][sense]" class="w-50 text-center" placeholder="Sense" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['sense']; } ?>"/>
                    <input type="text" name="enemy[mod][weak]" class="w-50 text-center" placeholder="Weak" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['weak']; } ?>"/>
                    <input type="text" name="enemy[mod][save]" class="w-50 text-center" placeholder="Save" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['save']; } ?>"/>
                </div>
                <div class="d-flex">
                    <input type="text" name="enemy[mod][accu]" class="w-50 text-center" placeholder="Accu" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['accu']; } ?>"/>
                    <input type="text" name="enemy[mod][cast]" class="w-50 text-center" placeholder="Cast" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['cast']; } ?>"/>
                    <input type="text" name="enemy[mod][level]" class="w-50 text-center" placeholder="Level" value="<?php if (isset($data['enemy'])) { echo $data['enemy']->getCharModifiers()['level']; } ?>"/>
                </div>
                <span>Attack</span>
                <input type="text" name="enemy[data][attack]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['attack']; } ?>" />
                <span>Spells</span>
                <input type="text" name="enemy[data][spells]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['spells']; } ?>" />
                <span>Speciality</span>
                <input type="text" name="enemy[data][speciality]" class="w-100" value="<?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['speciality']; } ?>" />
                <span>Loot</span>
                <input type="text" name="enemy[inventory][loot]" class="w-100" value="<?php if (isset($data['enemy_inventory'])) { echo $data['enemy_inventory']['loot']; } ?>" />
                <span>Special loot</span>
                <input type="text" name="enemy[inventory][sp_loot]" class="w-100" value="<?php if (isset($data['enemy_inventory'])) { echo $data['enemy_inventory']['sp_loot']; } ?>" />
            </div>
        </div>
        <div class="d-flex flex-column align-items-start">
            <label>Notes:</label>
            <textarea name="enemy[data][notes]" rows="4" class="w-100"><?php if (isset($data['enemy_data'])) { echo $data['enemy_data']['notes']; } ?></textarea>
        </div>

        <button type="submit" class="btn btn-secondary w-100 mt-3 mb-5"><?= $action ?></button>
    </form>
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