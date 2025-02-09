<div class="sidebar d-lg-block bg-light border-end p-1" id="sidebar">
    <div class="d-flex justify-content-end">
        <button id="closeSidebar" class="btn">
            <span>&times;</span>
        </button>
    </div>

    <a class="btn btn-outline-secondary" href="<?= HOST ?>/dm/new-enemy">Create enemy</a>
    <button class="btn btn-outline-secondary" href="<?= HOST ?>/dm/end-turn" disabled>End turn</button>
    <h3 class="mt-3">Enemies</h3>
    <div class="mx-2">
        <div class="row">
            <?php foreach ($data['enemies'] as $enemy) { ?>
                <div class="col-6 mb-2">
                    <div class="card" data-id="<?= $enemy->getId() ?>">
                        <?php
                            $enemyData = json_decode($enemy->getData(), true);
                            $headerColor = $enemyData['show'] === 'true' ? 'success' : 'secondary';
                        ?>
                        <div class="card-header bg-<?= $headerColor ?> text-white">
                            <div class="float-end">
                                <div class="dropdown">
                                    <a href="" class="text-decoration-none text-white" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div><a href="<?= HOST ?>/dm/edit-enemy/<?= $enemy->getId() ?>" class="dropdown-item" type="button">Edit</a></div>
                                        <div><a href="<?= HOST ?>/dm/clone-enemy/<?= $enemy->getId() ?>" class="dropdown-item" type="button">Clone</a></div>
                                        <div><a href="<?= HOST ?>/dm/delete-enemy/<?= $enemy->getId() ?>" class="dropdown-item" type="button">Delete</a></div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= HOST ?>/dm/see-enemy/<?= $enemy->getId() ?>" class="text-decoration-none text-white">
                                <?= $enemy->getName() ?>
                            </a>
                        </div>
                        <div class="card-body">
                            <img src="<?= HOST. $enemy->getImage() ?>" class="w-100 icon-image">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>