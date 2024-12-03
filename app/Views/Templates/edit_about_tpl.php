<?php include_once 'partials/editor_top_tpl.php'; ?>
<div class="content container text-center">
    <div class="float-left d-flex">
        <a href="<?= HOST ?>/" class="btn btn-success"> << Return</a>
    </div>
    <div class="title px-5 mb-4">
        <h2>About</h2>
    </div>
    <div class="about editor">
        <form method="post" class="pb-5">
            <div class="armor-initiative-speed flex-nowrap m-auto pe-1 pt-4 row">
                <div class="col">
                    <input type="text" class="col" name="about[armor]" value="<?= $data['about']['armor'] ?>">
                </div>
                <div class="col">
                    <input type="text" class="col" name="about[initiative]" value="<?= $data['about']['initiative'] ?>">
                </div>
                <div class="col">
                    <input type="text" class="col" name="about[speed]" value="<?= $data['about']['speed'] ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="char_class">Class</label><br>
                    <select name="about[char_class]" class="w-100 text-center class-selector">
                        <option value="">--- Select a class ---</option>
                        <?php foreach ($data['classes'] as $class) { ?>
                            <option value="<?= $class['index'] ?>"
                                <?php if (isset($data['about']['char_class']) && $data['about']['char_class'] === $class['index']) { echo 'selected'; } ?>
                            ><?= $class['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="char_race">Race</label><br>
                    <input type="text" name="about[char_race]" class="w-100" value="<?= $data['about']['char_race'] ?>"/>
                </div>
            </div>
            <div class="mb-3">
                <label for="char_bg">Background</label><br>
                <textarea name="about[char_bg]" class="w-100 resizable" cols="30" rows="5"><?= $data['about']['char_bg'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="char_appearance">Appearance</label><br>
                <textarea name="about[char_appearance]" class="w-100 resizable" cols="30" rows="5"><?= $data['about']['char_appearance'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="char_backstory">Back story</label><br>
                <textarea name="about[char_backstory]" class="w-100 resizable" cols="30" rows="5"><?= $data['about']['char_backstory'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Save</button>
        </form>
    </div>
</div>

<?php include_once 'partials/editor_bottom_tpl.php'; ?>