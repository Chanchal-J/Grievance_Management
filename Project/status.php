<?php
session_start();

// To move back to the home page if not logged in

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php?loginAlert=true");
    exit;
}
?>

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

    $page = 'status';

    require('nav.php');
    ?>

    <!-- Table displaying the complaints -->


    <div class="container-fluid py-5 col-sm-8 table-responsive">
        <table class="table align-middle">
            <thead class="table-secondary">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description of issue</th>
                    <th scope="col">Complaint Date</th>
                    <th scope="col">Resolution Date</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php

                //Reading the data of the user logged in from the database
                
                include 'common/dbconnect.php';
                $s_no = $_SESSION['s_no'];
                $sql = "SELECT * FROM complaints WHERE s_no='$s_no' ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                if ($num > 0) {
                    while ($row = $result->fetch_assoc()) {

                        // To show the resolved problems in 'green' or 'success' color of bootstrap
                
                        $resol = "light";
                        $resol_dt = "To be Resolved";
                        if ($row['resolved']) {
                            $resol = "success";
                            $resol_dt = $row['dt_resolve'];
                        }
                        echo '
                        <tr class="table-' . $resol . '">
                            <th scope="row">' . $row['id'] . '</th>
                            <td>' . $row['category'] . '</td>
                            <td>' . $row['description'] . '</td>
                            <td>' . $row['dt'] . '</td>
                            <td>' . $resol_dt . '</td>
                        </tr>';
                    }

                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    require('footer.php');
    ?>
</body>