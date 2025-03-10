<?php include_once 'partials/editor_top_tpl.php'; ?>
    <div class="content container text-center">
        <div class="float-left d-flex">
            <a href="<?= HOST ?>/" class="btn btn-success"> << Return</a>
        </div>
        <div class="title px-5 mb-4">
            <h2>Spells</h2>
        </div>
        <div class="mb-4">
            <div class="accordion spells">
                <?php foreach ($data['spells_by_level'] as $levelName => $spells) { ?>
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed text-light bg-opacity-75 rounded-0"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#<?= $this->stringify($levelName) ?>"
                                    aria-controls="<?= $this->stringify($levelName) ?>">
                                <?= $levelName ?>
                            </button>
                        </h3>
                        <div id="<?= $this->stringify($levelName) ?>" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="d-block">
                                    <?php foreach ($spells as $spell) { ?>
                                        <div class="card d-flex flex-md-row mb-2 p-2">
                                            <div class="col-md-6">
                                                <span class="level badge text-bg-secondary float-start"><?= $spell['level'] ?></span>
                                                <h3 class="name"><?= $spell['name'] ?></h3>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="details"><?= $spell['details'] ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="spells editor">
            <form method="post" id="spellForm">
                <div class="row flex-nowrap justify-content-around m-0 mb-3">
                    <div class="col-10 p-0">
                        <input type="text" data-host="<?= HOST ?>" id="spellInput" class="w-100 input-spells" autocomplete="off" />
                        <input type="hidden" name="spell[find]" id="spellOutput" value="" />
                    </div>
                    <div class="col-2 pe-0">
                        <button type="submit" id="addButton" class="btn btn-success w-100">Add spell</button>
                    </div>
                </div>
            </form>
            <div id="suggestions" class="mt-2 row"></div>
        </div>
    </div>


    <template id="spell-suggestion-template">
        <div class="suggestion col-6 p-1" data-spell="${id}">
            <div class="card d-block p-2">
                <span class="level badge text-bg-secondary float-start">${levelText}</span>
                <h3 class="name">${name}</h3>
                <p class="details">${details}</p>
            </div>
        </div>
    </template>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const spellInput = document.getElementById('spellInput');
            const spellOutput = document.getElementById('spellOutput');
            const suggestionsDiv = document.getElementById('suggestions');
            const host = spellInput.dataset.host;
            let debounceTimer;

            const debounce = (func, delay) => {
                return (...args) => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(this, args), delay);
                };
            };

            const fetchSuggestions = async (query) => {
                try {
                    const response = await fetch(`${host}/api/spells?query=${encodeURIComponent(query)}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    return await response.json();
                } catch (error) {
                    console.error('Error fetching suggestions:', error);
                    return [];
                }
            };

            const displaySuggestions = (suggestions) => {
                const template = document.getElementById('spell-suggestion-template');
                suggestionsDiv.innerHTML = '';

                suggestions.forEach(spell => {
                    const levelText = spell.level === 0 ? 'Cantrip' : `Level ${spell.level}`;
                    const clone = document.importNode(template.content, true);

                    clone.querySelector('.suggestion').dataset.spell = spell.id;
                    clone.querySelector('.level').textContent = levelText;
                    clone.querySelector('.name').textContent = spell.name;
                    clone.querySelector('.details').textContent = spell.details;

                    suggestionsDiv.appendChild(clone);
                });
            };

            const debouncedFetch = debounce(async (query) => {
                if (query.length < 2) {
                    suggestionsDiv.innerHTML = '';
                    return;
                }
                const suggestions = await fetchSuggestions(query);
                displaySuggestions(suggestions);
            }, 300);

            spellInput.addEventListener('input', (e) => {
                debouncedFetch(e.target.value);
            });

            // Manage clicks on suggestions
            suggestionsDiv.addEventListener('click', (e) => {
                const suggestionElement = e.target.closest('.suggestion');
                if (suggestionElement) {
                    const spellName = suggestionElement.querySelector('.name').textContent;
                    const spellId = suggestionElement.dataset.spell;
                    spellInput.value = spellName;
                    spellOutput.value = spellId;
                    suggestionsDiv.innerHTML = '';
                }
            });
        });
    </script>


<?php include_once 'partials/editor_bottom_tpl.php'; ?>