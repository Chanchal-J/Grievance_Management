<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grievance Management System </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
        crossorigin="anonymous"></script>


    <?php

    session_start();

    // To appropriately display the nav bar
    
    $page = 'about';
    require('nav.php');
    ?>


    <div class="text-center container my-5">
        <div class="bg-body-tertiary p-5 rounded">
            <div class="col-sm-9 py-5 mx-auto">
                <h1 class="display-5 fw-normal">Grievance Management</h1>
                <p class="fs-5 py-5">Grievance management is the process by which our government tries to deals with the
                    citizen's grievances.
                    Grievance management is an important part of maintaining a healthy locality.
                    This web page helps one to register their complaints regarding the issues and difficulties faced by
                    common people in their street / colony / ward / region.
                    One can file a report about the inconvenience faced by them by logging into this page after creating
                    their profile.<br>


                </p>
            </div>
        </div>
    </div>

    <?php
    require('footer.php');
    ?>
</body>