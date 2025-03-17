<div class="sidebar d-lg-block bg-light border-end p-1" id="sidebar">
    <div class="d-flex justify-content-end">
        <button id="closeSidebar" class="btn">
            <span>&times;</span>
        </button>
    </div>

    <!-- Abilities and modifiers -->
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

    <!-- Accordion -->
    <div class="accordion" id="my-data">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_0" aria-controls="collapse_0">
                    About
                </button>
            </h2>
            <div id="collapse_0" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="float-end">
                        <a href="<?= HOST ?>/edit/about" class="text-dark">
                            <?= ICONS['gear'] ?>
                        </a>
                    </div>
                    <div class="d-block position-relative">
                        <b>Player ID:</b> <?= $data['my_character']->getId() ?> <br>
                        <b>Initiative:</b>
                        <div class="initiative-circle">
                            <?= $data['my_character']->getInitiative() ?>
                        </div><br>
                        <b>Armor Class:</b> <?= $data['about']['armor'] ?? '' ?> <br>
                        <b>Speed:</b> <?= $data['about']['speed'] ?? '' ?> <br>
                        <b>Class:</b>
                        <?php
                        if (isset($data['about']['char_class']) && is_array($data['about']['char_class'])) {
                            //echo '<br>';
                            foreach ($data['about']['char_class'] as $charClass) {
                                echo '<br>- ' . $charClass['name'] . ' (Lvl ' . $charClass['lvl'] . ')';
                            }
                        } else {
                            echo $data['about']['char_class'] ?? '';
                        }

                        ?>
                        <br>
                        <b>Race:</b> <?= $data['about']['char_race'] ?? '' ?> <br>
                        <b>Exp:</b> <?= $data['about']['char_exp'] ?? '' ?> <br>
                        <!-- Background -->
                        <?php if (isset($data['about']['char_bg']) && $data['about']['char_bg'] !== '') { ?>
                            <b>Background</b> <br>
                            <?= $data['about']['char_bg'] ?? '' ?> <br>
                        <?php } ?>
                        <!-- Appearance -->
                        <?php if (isset($data['about']['char_appearance']) && $data['about']['char_appearance'] !== '') { ?>
                            <b>Apearance</b> <br>
                            <?= $data['about']['char_appearance'] ?? '' ?> <br>
                        <?php } ?>
                        <!-- Backstory -->
                        <?php if (isset($data['about']['char_backstory']) && $data['about']['char_backstory'] !== '') { ?>
                            <b>Backstory</b> <br>
                            <?= $data['about']['char_backstory'] ?? '' ?> <br>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_1" aria-controls="collapse_1">
                    Spells
                </button>
            </h2>
            <div id="collapse_1" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="d-flex justify-content-end w-100">
                        <div class="mb-2">
                            <a href="<?= HOST ?>/edit/spells" class="text-dark">
                                <?= ICONS['gear'] ?>
                            </a>
                        </div>
                    </div>
                    <div class="d-block">
                        <div class="accordion spells" id="spells">
                            <?php $manaCount = $data['mana_count'] ?? [];
                            foreach ($data['spells_by_level'] as $levelName => $spells) {
                                $lvl = ($levelName === 'Cantrips') ? 0 : (strpos($levelName, 'Level ') === 0 ? (int) substr($levelName, 6) : null); ?>
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-between align-items-center">
                                        <button class="accordion-button collapsed text-light bg-opacity-75 rounded-0"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#<?= $this->stringify($levelName) ?>"
                                                aria-controls="<?= $this->stringify($levelName) ?>">
                                            <?= $levelName ?>
                                        </button>
                                        <?php if ($lvl != 0) {
                                        $qty = array_key_exists($lvl, $data['mana_slots'])? (int) $data['mana_slots'][$lvl] : 1; ?>
                                        <div class="d-flex">
                                            <?php for ($i = 0; $i < $qty; $i++) {
                                                $checked = array_key_exists($lvl, $manaCount) ? $manaCount[$lvl] : 0; ?>
                                            <input type="checkbox" class="me-2" name="mana_slots[<?= $lvl ?>]" data-level="<?= $lvl ?>"
                                                <?= $i < $checked ? 'checked' : '' ?>>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </h3>
                                    <div id="<?= $this->stringify($levelName) ?>" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="d-block">
                                                <?php foreach ($spells as $spell) { ?>
                                                    - <span><?= $spell['name'] ?>
                                                        <a href=""
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#spellsModal"
                                                           data-modalcontent="<?= htmlspecialchars($spell['modal']) ?>">
                                                            <?= ICONS['arrow-right'] ?>
                                                        </a>
                                                    </span>
                                                    <br>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_2" aria-controls="collapse_2">
                    Skills
                </button>
            </h2>
            <div id="collapse_2" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="float-end">
                        <a href="<?= HOST ?>/edit/skills" class="text-dark">
                            <?= ICONS['gear'] ?>
                        </a>
                    </div>
                    <div class="d-block">
                        <?php foreach ($data['skills'] as $skill) { ?>
                            - <a href="<?= $skill['link'] ?>" target="_blank"><?= $skill['name'] ?></a> <br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_3" aria-controls="collapse_3">
                    Inventory
                </button>
            </h2>
            <div id="collapse_3" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="float-end">
                        <a href="<?= HOST ?>/edit/inventory" class="text-dark">
                            <?= ICONS['gear'] ?>
                        </a>
                    </div>
                    <div class="d-block">
                        <?php
                        if (!empty($data['inventory']) && !empty($data['inventory']['items'])) {  ?>
                            <?= nl2br($data['inventory']['items']) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed text-light bg-opacity-75 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_4" aria-controls="collapse_4">
                    Other
                </button>
            </h2>
            <div id="collapse_4" class="accordion-collapse collapse" data-bs-parent="#my-data">
                <div class="accordion-body">
                    <div class="float-end">
                        <a href="<?= HOST ?>/edit/other" class="text-dark">
                            <?= ICONS['gear'] ?>
                        </a>
                    </div>
                    <div class="d-block">
                        <?= nl2br($data['my_character']->getData()) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---->

</div>