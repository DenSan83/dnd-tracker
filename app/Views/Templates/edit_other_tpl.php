<?php include_once 'partials/editor_top_tpl.php'; ?>
    <div class="content container text-center">
        <div class="float-left d-flex">
            <a href="<?= HOST ?>/" class="btn btn-success"> << Return</a>
        </div>
        <div class="title px-5 mb-4">
            <h2>Other</h2>
        </div>
        <div class="other editor col-12">
            <form method="post">
                <div class="">
                    <textarea name="data" class="col-12" rows="10"><?= $data['data'] ?></textarea>
                    <button type="submit" class="btn btn-success col-12 ml-3">Save</button>
                </div>
            </form>
        </div>
    </div>
<?php include_once 'partials/editor_bottom_tpl.php'; ?>