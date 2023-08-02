<?php

// To redirect to 'home' page if not logged in

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php?loginAlert=true");
    exit;
}
?>

<?php
$showAlert = false;
$showerror = false;

// Registering the complaint in the database
// The data entered by user in the form is recieved in the $_POST variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['reqType'] == 'complaint') {
    include 'common/dbconnect.php';

    $category = $_POST['inputCategory'];
    $description = $_POST['inputDesc'];
    $address = $_POST['inputAddress'];
    $city = $_POST['inputCity'];
    $state = $_POST['inputState'];
    $pincode = $_POST['inputPin'];
    $s_no = $_SESSION['s_no'];
    $exists = false;
    if ($exists == false) {
        $sql = "INSERT INTO complaints (category , description , address , city , state , pincode , s_no ) VALUES('$category','$description','$address','$city','$state',$pincode,$s_no)";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
        }

    } else {
        $showerror = "ERROR !!!";
    }
}

// To diplay appropriate alert messages

if ($showAlert) {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Your data has been recorded.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aris-hidden="true">&times;</span>
            </button>
            </div>';
} else if ($showerror) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>' . $showError . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aris-hidden="true">&times;</span>
        </button>
        </div>';
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

    $page = 'complaint';

    require('nav.php');
    ?>

    <!-- Form to recieve the details of the complaint -->

    <div class="container-fluid py-5 col-sm-8">
        <form class="row g-3" action="/project/complaint.php" method="post">
            <h1 class="h3 mb-3 fw-normal">Register Complaint</h1>
            <div class="col-12">
                <label for="inputCategory" class="form-label">Category</label>
                <select id="inputCategory" class="form-select" name="inputCategory">
                    <option selected>Street light</option>
                    <option>Road conditions</option>
                    <option>Stray animals</option>
                    <option>Electric supply</option>
                    <option>Water supply</option>
                    <option>Power line</option>
                    <option>Other</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="inputDesc" class="form-label">Description</label>
                <input type="text" textarea class="form-control" id="inputDesc" rows="3"
                    placeholder="Elaborate the Issue" name="inputDesc">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St"
                    name="inputAddress">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity" name="inputCity">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-select" name="inputState">
                    <option selected>Rajasthan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputPin" class="form-label">Pincode</label>
                <input type="text" class="form-control" id="inputPin" name="inputPin">
                <input type="hidden" name="reqType" id="reqType" value="complaint">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>


    <?php
    require('footer.php');
    ?>
</body>