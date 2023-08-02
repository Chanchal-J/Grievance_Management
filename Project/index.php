<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grievance Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Bootstrap libraries -->
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
    $page = 'index';
    require('nav.php');

    // To display alert message when you try to Register/view complaints without logging in.
    
    if (isset($_GET["loginAlert"]) && $_GET["loginAlert"] == true) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Please Login/Signup first to register or view status of a complaint.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aris-hidden="true">&times;</span>
        </button>
        </div>';
    }

    // To display alert message when the admin login credentials are incorrect.
    
    if (isset($_GET["adminAlert"]) && $_GET["adminAlert"] == true) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>Invalid Credentials
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aris-hidden="true">&times;</span>
        </button>
        </div>';
    }

    ?>

    <!-- Displaying a carousel -->
    <div class="mx-auto p-4">
        <div class="container-fluid">
            <div id="carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/project/images/1.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/project/images/2.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/project/images/3.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item ">
                        <img src="/project/images/4.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item ">
                        <img src="/project/images/5.jpeg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <?php

    // To extract from the database - the number of users
    //                              - the number of complaints registered
    //                              - the number of complaints resolved
    
    $users = 0;
    $complaints = 0;
    $resolved_complaints = 0;

    include 'common/dbconnect.php';

    $sql = "SELECT COUNT(*) FROM signup";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $row = $result->fetch_row();
        $users = $row[0];
    } else {
        $showerror = "Invalid Credentials";
    }

    $sql = "SELECT COUNT(*) FROM complaints";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $row = $result->fetch_row();
        $complaints = $row[0];
    } else {
        $showerror = "Invalid Credentials";
    }

    $sql = "SELECT COUNT(*) FROM complaints WHERE resolved=true";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $row = $result->fetch_row();
        $resolved_complaints = $row[0];
    } else {
        $resolved_complaints = "Invalid Credentials";
    }
    ?>


    <div class="container">
        <div class="row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <?php echo $users; ?>
                        </h3>
                        <p class="card-text">Users Registered</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <?php echo $complaints; ?>
                        </h3>
                        <p class="card-text">Complaints Registered</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <?php echo $resolved_complaints; ?>
                        </h3>
                        <p class="card-text">Complaints Resolved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    require('footer.php');
    ?>
</body>

</html>