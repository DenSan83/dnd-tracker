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
                                        <?= ICONS['three-dots'] ?>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div><a href="<?= HOST ?>/dm/edit-enemy/<?= $enemy->getId() ?>" class="dropdown-item" type="button">Edit</a></div>
                                        <div><a href="<?= HOST ?>/dm/clone-enemy/<?= $enemy->getId() ?>" class="dropdown-item" type="button">Clone</a></div>
                                        <div>
                                            <button class="dropdown-item enemy-delete-btn" data-bs-toggle="modal" data-bs-target="#deleteEnemy" type="button"
                                                data-id="<?= $enemy->getId() ?>" data-name="<?= $enemy->getName() ?>" data-img="<?= $enemy->getImage() ?>" data-hcolor="<?= $headerColor ?>">
                                                Delete
                                            </button>
                                        </div>
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

<!-- Modal -->
<div class="modal fade" id="deleteEnemy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-host="<?= HOST ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete enemy</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Enemy?
                <div class="card mx-auto mt-2" style="width: 150px">
                    <div class="card-header modal-class-head text-white">
                        <span class="modal-name text-decoration-none text-white">FruitFly 2</span>
                    </div>
                    <div class="card-body">
                        <img src="" class="w-100 icon-image modal-img">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="" type="button" class="btn btn-danger btn-deleter">Delete enemy</a>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<script>
    const enemyDeleteModal = document.getElementById('deleteEnemy');
    if (enemyDeleteModal) {
        const HOST = enemyDeleteModal.getAttribute('data-host');
        const enemyDeleteBtns = document.getElementsByClassName('enemy-delete-btn');
        let curHcolor = 'success';

        Array.from(enemyDeleteBtns).forEach(btn => {
            btn.addEventListener('click', e => {
                const curBtn = e.target;
                const curId = curBtn.getAttribute('data-id');
                const curName = curBtn.getAttribute('data-name');
                const curImg = curBtn.getAttribute('data-img');
                curHcolor = curBtn.getAttribute('data-hcolor');
                const btnLink = enemyDeleteModal.querySelector('.btn-deleter');

                btnLink.href = `${HOST}/dm/delete-enemy/${curId}`;
                enemyDeleteModal.querySelector('.modal-name').textContent = curName;
                enemyDeleteModal.querySelector('.modal-img').src = `${HOST}${curImg}`;
                enemyDeleteModal.querySelector('.modal-class-head').classList.add('bg-' + curHcolor);
            });
        });

        enemyDeleteModal.addEventListener('hidden.bs.modal', e => {
            enemyDeleteModal.querySelector('.modal-class-head').classList.remove('bg-' + curHcolor);
        })
    }

</script>