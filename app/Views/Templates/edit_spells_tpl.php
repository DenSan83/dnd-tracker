<?php include_once 'partials/editor_top_tpl.php'; ?>
    <div class="content container text-center">
        <div>
            <div class="float-end d-flex">
                <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newSpellModal"> Add spell</a>
            </div>
            <div class="d-flex">
                <a href="<?= HOST ?>/" class="btn btn-success"> << Return</a>
            </div>
        </div>
        <div class="title px-5 mb-4">
            <h2>Spells</h2>
        </div>
        <?php if (!empty($data['mana_slots'])) { ?>
        <div class="mana-slots mb-4">
            <h4>Mana Slots</h4>
            <form action="<?= HOST ?>/edit/mana" method="post">
                <?php foreach ($data['mana_slots'] as $key => $level) { if ($key == 0) continue; ?>
                    <label>Level <?= $key ?>:</label>
                    <input type="number" min="1" name="mana[<?= $key ?>]" value="<?= array_key_exists($key, $data['mana_slots'])? $data['mana_slots'][$key] : 1 ?>" required>
                <?php } ?>
                <button type="submit" class="btn btn-success w-100 mt-2">Save mana slots</button>
            </form>
        </div>
        <?php } ?>

        <div class="mb-4">
            <h4 class="text-start">Spells list</h4>
            <div class="accordion spells">
                <?php if (!empty($data['spells_by_level'])) {
                    foreach ($data['spells_by_level'] as $levelName => $spells) { ?>
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
                                        <div class="cardmb-2 p-2">
                                            <div>
                                                <div class="float-end">
                                                    <?php if (array_key_exists($spell['id'], $data['notes'])) { ?>
                                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                                             class="d-inline-block me-2 text-success"
                                                             data-bs-custom-class="custom-tooltip"
                                                             data-bs-title="<?= $data['notes'][$spell['id']] ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                            </svg>
                                                        </div>
                                                    <?php } ?>

                                                    <button type="button"
                                                        data-id="<?= $spell['id'] ?>"
                                                        data-name="<?= $spell['name'] ?>"
                                                        class="btn-close float-end deleteModalBtn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteSpellModal"></button>
                                                </div>
                                                <span class="level badge text-bg-secondary float-start"><?= $spell['level'] ?></span>
                                                <h3 class="name"><?= $spell['name'] ?></h3>
                                            </div>
                                            <div>
                                                <p class="details"><?= $spell['details'] ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                } else {
                    echo 'There are no spells on this list yet.';
                } ?>
            </div>
        </div>


        <!-- New Spell Modal -->
        <div class="modal fade" id="newSpellModal" tabindex="-1" aria-labelledby="newSpellModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newSpellModalLabel">Add Spell</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" id="spellForm">
                        <div class="modal-body text-start">
                            <div>
                                <label>Spell</label>
                                <input type="text" data-host="<?= HOST ?>" id="spellInput" class="w-100 input-spells" autocomplete="off" />
                                <input type="hidden" name="spell[find]" id="spellOutput" value="" />
                                <div id="suggestions" class="mt-2 row"></div>
                            </div>
                            <div>
                                <label class="mb-1">Notes</label>
                                <textarea name="spell[notes]" class="w-100"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add spell</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Spell Modal -->
        <div class="modal fade" id="deleteSpellModal" tabindex="-1" aria-labelledby="deleteSpellModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newSpellModalLabel">Delete Spell</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= HOST ?>/edit/spells">
                        <div class="modal-body text-start">
                            <div>
                                <b>Spell: </b><span class="spell-del-name"></span>
                            </div>
                            Are you sure you want to delete this spell?
                            <input type="hidden" id="del_id" name="del_id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete spell</button>
                        </div>
                    </form>
                </div>
            </div>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        // Add a spell to my list
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

            // Delete modal fill deleteModalBtn
            const deleteSpellModalEl = document.getElementById('deleteSpellModal')
            deleteSpellModalEl.addEventListener('show.bs.modal', e => {
                const button = e.relatedTarget;
                const spellId = button.getAttribute('data-id');
                const spellIdField = deleteSpellModalEl.querySelector('#del_id');
                const spellName = button.getAttribute('data-name');
                const spellDelName = deleteSpellModalEl.querySelector('.spell-del-name');
                spellDelName.innerText = spellName;
                spellIdField.value = spellId;
            })

        });
    </script>


<?php include_once 'partials/editor_bottom_tpl.php'; ?>