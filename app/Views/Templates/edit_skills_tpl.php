<?php include_once 'partials/editor_top_tpl.php'; ?>
    <div class="content container text-center">
        <div class="float-left d-flex">
            <a href="<?= HOST ?>/" class="btn btn-success"> << Return</a>
        </div>
        <div class="title px-5 mb-4">
            <h2>Skills</h2>
            <ul class="list-group">
                <?php foreach ($data['skills'] as $skill) { ?>
                    <li class="list-group-item d-flex">
                        <a href="<?= $skill['link'] ?>" target="_blank"><?= $skill['name'] ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="skills editor">
            <form method="post">
                <div class="row flex-nowrap justify-content-around m-0 mb-3">
                    <div class="col-5 p-0 pe-1">
                        <input type="text" placeholder="Name" data-host="<?= HOST ?>" name="skill[name]" class="w-100 input-spells" autocomplete="off" />
                    </div>
                    <div class="col-5 p-0 ps-1">
                        <input type="text" placeholder="https://source.com" data-host="<?= HOST ?>" name="skill[link]" class="w-100 input-spells" autocomplete="off" />
                    </div>
                    <div class="col-2 pe-0">
                        <button type="submit" id="addButton" class="btn btn-success w-100">Add skill</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php include_once 'partials/editor_bottom_tpl.php'; ?>