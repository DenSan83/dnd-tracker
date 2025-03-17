<div class="name">
    <h1><i><?= $spellName ?></i></h1>
</div>
<?php if ($spellLvl) { ?>
    <div class="subtitle">
        <i><?= $spellLvl ?> Conjuration </i>
    </div>
<?php } ?>
<div class="single-list">
    <ul>
        <?php if ($castingTime) { ?>
            <li><b>Casting Time: </b><?= $castingTime ?></li>
        <?php } ?>
        <?php if ($range) { ?>
            <li><b>Range: </b><?= $range ?></li>
        <?php } ?>
        <?php if ($target) { ?>
            <li><b>Target: </b><?= $target ?></li>
        <?php } ?>
        <?php if ($vsm) { ?>
            <li><b>Components: </b>
                <?= $vsm['verbal'] ?>
                <?= $vsm['somatic'] ?>
                <?= $vsm['material'].$vsm['material_list'] ?></li>
        <?php } ?>
        <?php if ($duration) { ?>
            <li><b>Duration: </b><?= $duration ?></li>
        <?php } ?>
        <?php if ($ritual) { ?>
            <li><b>Ritual: </b><?= $ritual ?></li>
        <?php } ?>
    </ul>
    <?php if ($details) { ?>
        <p><?= nl2br($details) ?></p>
    <?php } ?>
    <?php if ($source) { ?>
        <small><b>Source: </b> <a target="_blank" href="<?= $url ?>"><?= $source ?></a></small>
    <?php } ?>

    <?php if ($notes) { ?>
        <hr>
        <p><b>Notes: </b> <?= $notes ?></p>
    <?php } ?>
</div>