<?php

// Verifying the login credentials recieved from the login modal

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'login') {

    $login = false;
    $showerror = false;
    include 'common/dbconnect.php';
    $username = $_POST['username'];
    $password = $_POST['pass2'];


    $sql = "SELECT * FROM signup WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $login = true;
        $row = $result->fetch_assoc();
        $s_no = $row['s_no'];
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['s_no'] = $s_no;
    } else {
        $showerror = "Invalid Credentials";
    }

    if ($login) {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            You are logged in.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aris-hidden="true">&times;</span>
            </button>
            </div>';
    } else if ($showerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>' . $showerror . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aris-hidden="true">&times;</span>
        </button>
        </div>';
    }
}

// Registering the credentials recieved from the signup modal

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'signup') {

    $showAlert = false;
    $showError = false;
    include 'common/dbconnect.php';
    $username = $_POST['SignupName'];
    $email = $_POST['mail'];
    $phone_number = $_POST['Phone'];
    $adhar_number = $_POST['Adhar'];
    $password = $_POST['pass3'];
    $cpassword = $_POST['cpass'];
    $exists = false;
    if (($password == $cpassword) && ($exists == false)) {
        $sql = "INSERT INTO signup (username , email , phone_no , adhar_no , password ) VALUES('$username','$email',$phone_number,$adhar_number,'$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
        }

    } else {
        $showError = "passwords do not match";
    }

    if ($showAlert) {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Your data has been recorded.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aris-hidden="true">&times;</span>
                </button>
                </div>';
    } else if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! </strong>' . $showError . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aris-hidden="true">&times;</span>
            </button>
            </div>';
    }
}
?>

<!-- Navigation Bar -->

<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Grievance Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'index') {
                        echo 'active';
                    } ?>" href="/project/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'about') {
                        echo 'active';
                    } ?>" href="/project/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'complaint') {
                        echo 'active';
                    } ?>" href="/project/complaint.php">Register Complaint</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'status') {
                        echo 'active';
                    } ?>" href="/project/status.php">Complaint Status</a>
                </li>
            </ul>

            <?php

            // To change the nav bar according to the login status 
            
            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                echo '
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                        data-bs-target="#adminModal">Admin</button>
                    <button type="button" class="btn btn-outline-info" type="submit" data-bs-toggle="modal"
                        data-bs-target="#loginModal">Login</button>
                    <button type="button" class="btn btn-outline-info" type="submit" data-bs-toggle="modal"
                        data-bs-target="#signupModal">SignUp</button>
                </div>';

            } else {
                echo '
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="navbar-brand" href="#">Hi ' . $_SESSION['username'] . '</a>
                    <a class="btn btn-outline-light" href="/project/logout.php">Logout</a>
                </div>';

            }

            ?>

        </div>
    </div>
</nav>




<!-- Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-bg-dark p-3" data-bs-theme="dark">
                <h1 class="modal-title fs-5" id="adminModalLabel">Admin Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Redirects to the admin.php page -->
                <form action="/project/admin/admin.php" method="post">
                    <div class="mb-3">
                        <label for="AdminName" class="form-label">Admin name</label>
                        <input type="name" class="form-control" name="AdminName" id="AdminName"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Password</label>
                        <input type="password" name="pass" class="form-control" id="pass">
                        <!-- Hidden input type which differentiates between various forms -->
                        <input type="hidden" name="reqType" id="reqType" value="admin">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-bg-dark p-3" data-bs-theme="dark">
                <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/project/index.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Enter your Username</label>
                        <input type="name" name="username" class="form-control" id="username"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="pass2" class="form-label">Enter your Password</label>
                        <input type="password" name="pass2" class="form-control" id="pass2">
                        <!-- Hidden input type which differentiates between various forms -->
                        <input type="hidden" name="reqType" id="reqType" value="login">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <p> Are you a new user?</p>
                        <button type="button" class="btn btn-secondary" type="submit" data-bs-toggle="modal"
                            data-bs-target="#signupModal">Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-bg-dark p-3" data-bs-theme="dark">
                <h1 class="modal-title fs-5" id="signupModalLabel">Signup</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/project/index.php" method="post">
                    <div class="mb-3">
                        <label for="SignupName" class="form-label"> Enter your username</label>
                        <input type="name" name="SignupName" class="form-control" id="SignupName"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="mail" class="form-label">Enter your Email address</label>
                        <input type="email" name="mail" class="form-control" id="mail" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="Phone" class="form-label">Enter your Phone number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+91</span>
                            <input type="text" name="Phone" class="form-control" id="Phone" aria-label="Username"
                                aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Adhar" class="form-label">Enter your Adhaar number</label>
                        <input type="text" name="Adhar" class="form-control" id="Adhar">
                    </div>
                    <div class="mb-3">
                        <label for="pass3" class="form-label">Set a Password</label>
                        <input type="password" name="pass3" class="form-control" id="pass3">
                    </div>
                    <div class="mb-3">
                        <label for="cpass" class="form-label">Confirm your Password</label>
                        <input type="password" name="cpass" class="form-control" id="cpass">
                        <!-- Hidden input type which differentiates between various forms -->
                        <input type="hidden" name="reqType" id="reqType" value="signup">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <p> Already have an account ?</p>
                        <button type="button" class="btn btn-secondary" type="submit" data-bs-toggle="modal"
                            data-bs-target="#loginModal">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>