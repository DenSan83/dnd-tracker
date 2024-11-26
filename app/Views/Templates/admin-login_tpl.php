<?php
if (isset($_SESSION['return'])) {
    $return = $_SESSION['return'];
    unset($_SESSION['return']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>DnD Tracker - Admin login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center py-4">
<style>
    html, body {
        height: 100%;
        background: url("./public/images/entrance-dragon.jpg") no-repeat center / cover;
    }

    .form-signin {
        max-width: 800px;
        padding: 1rem;

        @media screen and (max-width: 800px)  {
            max-width: 100vw;
        }
    }

    .holder {
        width: 35%;
        min-width: 200px;
    }

    .form-signin {
        z-index: 2;

        & input[type="email"] {
            margin-bottom: -1px;
            border-radius: 0.375rem 0.375rem 0 0!important;
        }

        & input[type="password"] {
            margin-bottom: 10px;
            margin-left: 0!important;
            border-radius: 0 0 0.375rem 0.375rem!important;
        }
    }

    .invalid-feedback {
        border-radius: 4px;
    }

    main {
        background-color: #ffffff99;
        border-radius: 5px;
    }
</style>
<main class="form-signin w-100 m-auto">
    <div class="holder align-items-center d-flex justify-content-center h-100 mt-5 mx-auto">
        <form method="post" action="<?= HOST ?>/admin">
            <h1>Admin login</h1>
            <div class="input-group has-validation d-flex felx-column">
                <input type="email" name="admin[email]" class="form-control w-100" placeholder="Email">
                <input type="password" name="admin[password]" class="form-control w-100" placeholder="Password">
                <?php if (!empty($return['error'])) { ?>
                    <div class="invalid-feedback bg-opacity-75 mb-2 mt-0 text-bg-danger d-block text-center"><?= $return['error'] ?></div>
                <?php } ?>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
            <p class="mt-md-3 mb-3 text-body-secondary text-center">DnD tracker© v.1.0 - 2024</p>
        </form>
    </div>
</main>

</body>
</html>