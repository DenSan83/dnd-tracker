<?php include_once 'partials/editor_top_tpl.php'; ?>
    <div class="content container text-center edit_hp_tpl">
        <div class="float-left d-flex">
            <a href="<?= HOST ?>/" class="btn btn-success"> << Return</a>
        </div>
        <div class="title px-5 mb-4">
            <h2>HP</h2>
        </div>
        <div class="other editor col-12">
            <div class="progress mb-5" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-striped bg-<?= $data['currentColor'] ?> progress-bar-animated"
                     style="width: <?= $data['percent'] ?>%"><?php if ($data['percent'] >= 10) echo $data['current'] .'/'. $data['max']; ?></div>
            </div>
            <form method="post">
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="current" class="form-label">Current</label>
                        <input type="text" class="form-control text-center" id="current" autofocus
                            name="hp[current]" value="<?= $data['current'] ?>" min="0">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="max" class="form-label">Max</label>
                        <input type="number" class="form-control text-center" id="max"
                           name="hp[max]" value="<?= $data['max'] ?>" min="0">
                    </div>
                    <button type="submit" class="btn btn-success col-12 ml-3">Save</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        let timeoutId;
        let lastValidValue;

        const initializeLastValidValue = () => {
            const currentInput = document.getElementById('current');
            const currentValue = currentInput.value.trim();
            if (/^\d+$/.test(currentValue)) {
                lastValidValue = currentValue;
            } else {
                lastValidValue = '1';
                currentInput.value = '1';
            }
        };
        initializeLastValidValue();

        document.getElementById('current').addEventListener('keyup', () => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                const inputElement = document.getElementById('current');
                const maxElement = document.getElementById('max');
                let inputVal = inputElement.value.trim();
                const maxValue = parseInt(maxElement.value) || 100;

                if (inputVal.includes('+') && /^\d+\+\d+$/.test(inputVal)) {      // Add
                    const parts = inputVal.split('+');
                    let sum = parseInt(parts[0]) + parseInt(parts[1]);
                    sum = Math.min(sum, maxValue);
                    inputVal = sum.toString();
                } else if (inputVal.includes('-') && /^\d+-\d+$/.test(inputVal)) { // Subtract
                    const parts = inputVal.split('-');
                    let difference = parseInt(parts[0]) - parseInt(parts[1]);
                    difference = Math.max(0, difference);
                    inputVal = difference.toString();
                } else if (/^\d+$/.test(inputVal)) {                               // Accepted int
                    inputVal = Math.min(parseInt(inputVal), maxValue).toString();
                } else {                                                           // Other values
                    inputVal = inputVal.replace(/[^\d]/g, '');
                    if (inputVal === '') {
                        inputVal = lastValidValue;
                    } else {
                        inputVal = Math.min(parseInt(inputVal) || 0, maxValue).toString();
                    }
                }

                inputElement.value = inputVal;
                if (inputVal !== '') {
                    lastValidValue = inputVal;
                }
            }, 1500);
        });
    </script>
<?php include_once 'partials/editor_bottom_tpl.php'; ?>