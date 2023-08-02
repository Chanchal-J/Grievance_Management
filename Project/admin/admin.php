<?php

session_start();

// To verify the admin login credentials sent from the Admin Modal using POST method.

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'admin') {

    include '../common/dbconnect.php';
    $adminName = $_POST['AdminName'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM admin WHERE admin_name='$adminName' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['adminName'] = $adminName;
    } else {
        // In case of Invalid Credentials redirect to 'home' page.
        header("location:/project/index.php?adminAlert=true");
    }
}

$page = 'complaints';

if (isset($_GET["page"])) {
    $page = $_GET["page"];
}

// When the admin searches for a username, the form action using post method sends it to admin home page.
// Redirecting in that case to the users page in admin portal.
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'adminSearchUser') {
    $page = 'users';
}

?>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
        crossorigin="anonymous"></script>


    <!-- Admin side Nav bar-->
    <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Grievance Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == 'complaints') {
                            echo 'active';
                        } ?>" href="/project/admin/admin.php">Complaints</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == 'users') {
                            echo 'active';
                        } ?>" href="/project/admin/admin.php?page=users">Users</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a class="navbar-brand" href="#">Hi
                            <?php echo $_SESSION['adminName'] ?>
                        </a>
                        <a class="btn btn-outline-light" href="/project/logout.php">Logout</a>
                    </div>';
                </form>
            </div>
        </div>
    </nav>


    <?php

    include '../common/dbconnect.php';

    // Complaints page of the Admin Portal
    if ($page == 'complaints') {

        $category_query = '1';
        $city_query = '1';
        $resolution_query = '1';

        // Filters for Admin to view the complaints send using POST method from the form.
        // Adjusting the sql query accordingly.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'adminComplaints') {
            if ($_POST['inputCategory'] != "All") {
                $category_query = 'category="' . $_POST['inputCategory'] . '"';
            }
            if ($_POST['inputCity'] != "All") {
                $city_query = 'city="' . $_POST['inputCity'] . '"';
            }

            if ($_POST['inputResoln'] != "All") {
                $resolution_query = 'resolved=' . $_POST['inputResoln'];
            }
        }

        // The Resolve button for each complaint, sends the complaint ID using POST method.
        // Updates the database accordingly.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'resolveComplaint') {
            $complaintID = $_POST['complaintID'];
            $sql1 = "UPDATE complaints SET dt_resolve = CURRENT_TIME(), resolved=true WHERE id = " . $complaintID;
            $result1 = mysqli_query($conn, $sql1);
        }

        // Displaying the form to receive the details of various filters from the admin.
    
        echo '
            <div class="container-fluid py-5 col-sm-8">
                <form class="row g-3" action="../admin/admin.php" method="post">
                    <div class="col-md-3">
                        <label for="inputCategory" class="form-label">Category</label>
                        <select id="inputCategory" name="inputCategory" class="form-select">
                        <option selected>All</option>
                        <option>Street light</option>
                        <option>Road conditions</option>
                        <option>Stray animals</option>
                        <option>Electric supply</option>
                        <option>Water supply</option>
                        <option>Power line</option>
                        <option>Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="inputCity" class="form-label">City</label>
                        <select id="inputCity" name="inputCity" class="form-select">
                        <option selected>All</option>';

        // Listing all the distinct cities from the complaints registered in the database.
        $sql1 = "SELECT DISTINCT city FROM complaints";
        $result1 = mysqli_query($conn, $sql1);
        while ($row1 = $result1->fetch_assoc()) {
            echo '<option>' . $row1['city'] . '</option>';
        }

        echo '
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="inputResoln" class="form-label">Resolution</label>
                        <select id="inputResoln" name="inputResoln" class="form-select">
                        <option selected>All</option>
                        <option value="true">Resolved</option>
                        <option value="false">Unresolved</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="hidden" name="reqType" id="reqType" value="adminComplaints">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>';

        // Displaying the Table of Complaints.
        echo '
            <div class="container-fluid py-5 col-sm-8 table-responsive">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">City</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description of issue</th>
                            <th scope="col">Complaint Date</th>
                            <th scope="col">Resolution Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">';
        $sql = "SELECT * FROM complaints WHERE " . $category_query . " AND " . $city_query . " AND " . $resolution_query . " ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            while ($row = $result->fetch_assoc()) {
                $resol = "light";
                $resol_dt = "";
                if ($row['resolved']) {
                    $resol = "success";
                    $resol_dt = $row['dt_resolve'];
                } else {
                    // If the complaint is not resolved, giving a resolve button to change the status.
                    // Hidden input is used here to send the complaint ID in the post method.
                    $resol_dt = '
                    <form action="../admin/admin.php" method="post">
                        <div class="col-md-3">
                            <input type="hidden" name="reqType" id="reqType" value="resolveComplaint">
                            <input type="hidden" name="complaintID" id="complaintID" value="' . $row['id'] . '">
                            <button type="submit" class="btn btn-primary btn-sm">Resolve</button>
                        </div>
                    </form>
                    ';
                }

                // Extracting the username from the s_no(user_ID) of the complaint.
                $username = "";
                $sql1 = "SELECT * FROM signup WHERE s_no=" . $row['s_no'];
                $result1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($result1) > 0) {
                    $row1 = $result1->fetch_assoc();
                    $username = $row1['username'];
                }

                // Displayiing the complaint details in the table row.
                echo '
                        <tr class="table-' . $resol . '">
                            <th scope="row">' . $row['id'] . '</th>
                            <td>' . $username . '</td>
                            <td>' . $row['city'] . '</td>
                            <td>' . $row['category'] . '</td>
                            <td>' . $row['description'] . '</td>
                            <td>' . $row['dt'] . '</td>
                            <td>' . $resol_dt . '</td>
                        </tr>';
            }

        }

        echo '
                    </tbody>
                </table>
            </div>';

        // Users page of the Admin Portal
    } else if ($page == 'users') {

        // Form that allows admin to search and access user details using username.
    
        echo '
            <div class="container-fluid py-5 col-sm-8 table-responsive">
                <form action="../admin/admin.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="button-addon2"
                        name="searchUsername" id="searchUsername">
                        <input type="hidden" name="reqType" id="reqType" value="adminSearchUser">
                        <button class="btn btn-outline-secondary" type="submit" id="searchButton">Search</button>
                    </div>
                </form>';

        // To edit the SQL query according to the filter send by the admin.
        $usersQueryDisplay = '1';
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'adminSearchUser') {
            $username = $_POST['searchUsername'];
            $sql = "SELECT * FROM signup WHERE username='" . $username . "'";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if ($num > 0) {
                $usersQueryDisplay = 'username="' . $username . '"';
            } else {
                // Display an alert if the username is not found.
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        User with username ' . $username . ' not found.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aris-hidden="true">&times;</span>
                        </button>
                        </div>';
            }
        }

        // Display the details of the users registered.
        echo '
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Complaints Registered</th>
                            <th scope="col">Complaints Resolved</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">';
        $sql = "SELECT * FROM signup WHERE " . $usersQueryDisplay;
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            while ($row = $result->fetch_assoc()) {
                // Extracting the number of registered complaints and resolved complaints for each user.
                $no_c = 0;
                $no_c_r = 0;

                $sql1 = "SELECT COUNT(*) FROM complaints WHERE s_no=" . $row['s_no'];
                $result1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($result1) > 0) {
                    $no_c = $result1->fetch_row()[0];
                }

                $sql1 = "SELECT COUNT(*) FROM complaints WHERE s_no=" . $row['s_no'] . ' AND resolved=true';
                $result1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($result1) > 0) {
                    $no_c_r = $result1->fetch_row()[0];
                }

                // Displayiing the user details in the table row.
                echo '
                        <tr class="table-light">
                            <th scope="row">' . $row['username'] . '</th>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['phone_no'] . '</td>
                            <td>' . $no_c . '</td>
                            <td>' . $no_c_r . '</td>
                        </tr>';
            }

        }
        echo '
                    </tbody>
                </table>
            </div>';
    }
    ?>
</body>