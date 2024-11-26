<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>DnD Tracker - Homepage</title>
    <style>
        body {
            padding-top: 56px;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        .sidebar {
            height: calc(100vh - 56px);
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 20px;
            z-index: 1020;
        }
        .content {
            padding-top: 20px;
            transition: margin-left 0.3s;
        }
        @media (min-width: 993px) {
            .content {
                margin-left: 250px;
            }
            #sidebarToggle {
                display: none;
            }
        }
        #closeSidebar {
            display: none;
        }
        @media (max-width: 992px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-left: 0;
            }
            #closeSidebar {
                display: block;
            }
        }
        .character_image {
            max-width: 100%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Logo</a>
        <div class="" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item">
                    <a href="#" class="nav-link me-2" id="sidebarToggle" aria-label="Toggle navigation">
                        Turn
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= HOST ?>/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="sidebar d-lg-block bg-light border-end" id="sidebar">
    <button id="closeSidebar" class="btn btn-light mb-3">
        <span>&times;</span> Close
    </button>
    <ul class="list-unstyled">
        <?php foreach ($data['character_list'] as $character) { ?>
            <li>
                <span><?= $character->getName() ?></span>
            </li>
        <?php } ?>
    </ul>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1><?= $data['my_character']->getName() ?></h1>
                <p>
                    <img src="./uploads/<?= $data['my_character']->getImage() ?>" class="character_image">
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#sidebarToggle').click(function() {
            $('#sidebar').toggle();
            $('.content').toggleClass('ml-0');
        });

        $('#closeSidebar').click(function() {
            $('#sidebar').hide();
            $('.content').addClass('ml-0');
        });
    });
</script>

</body>
</html>