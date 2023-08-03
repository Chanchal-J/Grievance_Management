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
        $_SESSION['adminID'] = $row['id'];
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

// When the admin adds a new category, the form action using post method sends it to admin home page.
// Redirecting in that case to the category page in admin portal.
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'addCategory') {
    $page = 'category';
}

// When the admin adds a new admin, the form action using post method sends it to admin home page.
// Redirecting in that case to the admin page in admin portal.
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'addAdmin') {
    $page = 'admin';
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
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == 'category') {
                            echo 'active';
                        } ?>" href="/project/admin/admin.php?page=category">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == 'admin') {
                            echo 'active';
                        } ?>" href="/project/admin/admin.php?page=admin">Admin</a>
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
        $admin_query = '1';

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
            if ($_POST['inputadminID'] != "All") {
                $admin_query = 'resolved_by_admin_id=' . $_POST['inputadminID'];
            }
        }

        // The Resolve button for each complaint, sends the complaint ID using POST method.
        // Updates the database accordingly.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'resolveComplaint') {
            $complaintID = $_POST['complaintID'];
            $sql1 = "UPDATE complaints SET dt_resolve = CURRENT_TIME(), resolved=true, resolved_by_admin_id=" . $_SESSION['adminID'] . " WHERE id = " . $complaintID;
            $result1 = mysqli_query($conn, $sql1);
        }

        // Displaying the form to receive the details of various filters from the admin.
    
        echo '
            <div class="container-fluid py-5 col-sm-8">
                <form class="row g-3" action="../admin/admin.php" method="post">
                    <div class="col-md-3">
                        <label for="inputCategory" class="form-label">Category</label>
                        <select id="inputCategory" name="inputCategory" class="form-select">
                        <option selected>All</option>';

        // Listing all the categories from the database.
        $sql1 = "SELECT * FROM category";
        $result1 = mysqli_query($conn, $sql1);
        while ($row1 = $result1->fetch_assoc()) {
            echo '<option>' . $row1['category'] . '</option>';
        }

        echo '
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
                        <label for="inputAdminName" class="form-label">Resolved By Admin</label>
                        <select id="inputadminID" name="inputadminID" class="form-select">
                        <option selected>All</option>';

        // Listing all the admin_names from the database.
        $sql1 = "SELECT * FROM admin";
        $result1 = mysqli_query($conn, $sql1);
        while ($row1 = $result1->fetch_assoc()) {
            echo '<option value=' . $row1['id'] . '>' . $row1['admin_name'] . '</option>';
        }

        echo '
                        </select>
                    </div>
                    <div class="col-md-1">
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
                            <th scope="col">Resolved By</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">';
        $sql = "SELECT * FROM complaints WHERE " . $category_query . " AND " . $city_query . " AND " . $resolution_query . " AND " . $admin_query . " ORDER BY id DESC";
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

                // Extracting the admin_name from the resolved_by_admin_id of the complaint.
                $admin_name = "";
                if ($row['resolved_by_admin_id']) {
                    $sql1 = "SELECT * FROM admin WHERE id=" . $row['resolved_by_admin_id'];
                    $result1 = mysqli_query($conn, $sql1);
                    if (mysqli_num_rows($result1) > 0) {
                        $row1 = $result1->fetch_assoc();
                        $admin_name = $row1['admin_name'];
                    }
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
                            <td>' . $admin_name . '</td>
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

        // Categories page of the Admin Portal
    } else if ($page == 'category') {
        // Adding a new Category.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'addCategory') {
            $newCategory = $_POST['inputAddCategory'];
            $sql = "INSERT INTO category (category) VALUES ('$newCategory')";
            $error = '';
            $result = null;
            try {
                $result = mysqli_query($conn, $sql);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if (!$result || $error != '') {
                // Display an alert if the category was not added
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Category could not be added. ' . $error . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aris-hidden="true">&times;</span>
                        </button>
                        </div>';
            }
        }
        echo '
            <div class="container-fluid py-5 col-sm-4 table-responsive">
                <form action="../admin/admin.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Add Category" aria-label="Add Category" aria-describedby="button-addon2"
                        name="inputAddCategory" id="inputAddCategory">
                        <input type="hidden" name="reqType" id="reqType" value="addCategory">
                        <button class="btn btn-outline-secondary" type="submit" id="addCategory">Add</button>
                    </div>
                </form>
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Categories</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">';
        $sql1 = "SELECT * FROM category";
        $result1 = mysqli_query($conn, $sql1);
        while ($row1 = $result1->fetch_assoc()) {
            echo '<tr class="table-light"><td>' . $row1['category'] . '</td></tr>';
        }
        echo '
                    </tbody>
                </table>
            </div>';

        // Add New Admin page of the Admin Portal
    } else if ($page == 'admin') {
        // Adding New Admin Credentials.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'addAdmin') {
            $newAdminName = $_POST['inputAddAdminName'];
            $newAdminPassword = $_POST['inputAddAdminPassword'];
            $sql = "INSERT INTO admin (admin_name,password) VALUES ('$newAdminName','$newAdminPassword')";
            $error = '';
            $result = null;
            try {
                $result = mysqli_query($conn, $sql);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if (!$result || $error != '') {
                // Display an alert if the category was not added
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Category could not be added. ' . $error . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aris-hidden="true">&times;</span>
                        </button>
                        </div>';
            }
        }
        echo '
            <div class="container-fluid py-5 col-sm-4 table-responsive">
                <form action="../admin/admin.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Admin Name" aria-label="Add Admin" aria-describedby="button-addon2"
                        name="inputAddAdminName" id="inputAddAdminName">
                        <input type="password" class="form-control" placeholder="Password" aria-label="Add Password" aria-describedby="button-addon2"
                        name="inputAddAdminPassword" id="inputAddAdminPassword">
                        <input type="hidden" name="reqType" id="reqType" value="addAdmin">
                        <button class="btn btn-outline-secondary" type="submit" id="addAdmin">Add New Admin</button>
                    </div>
                </form>
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Admins</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">';
        $sql1 = "SELECT * FROM admin";
        $result1 = mysqli_query($conn, $sql1);
        while ($row1 = $result1->fetch_assoc()) {
            echo '<tr class="table-light"><td>' . $row1['admin_name'] . '</td></tr>';
        }
        echo '
                    </tbody>
                </table>
            </div>';
    }
    ?>
</body>