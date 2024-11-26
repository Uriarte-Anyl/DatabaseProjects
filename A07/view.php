<?php
include("connect.php");

$userInfoID = $_GET['userInfoID'];

if (isset($_POST['btnEdit'])) {
    $firstName = ucwords($_POST['firstName']);
    $lastName = ucwords($_POST['lastName']);
    $birthDay = $_POST['birthDay'];
    $sex = ucwords($_POST['sex']);

    $editQuery = "UPDATE usersinfo SET firstName='$firstName', lastName='$lastName', birthDay='$birthDay', sex='$sex' WHERE userInfoID='$userInfoID'";
    executeQuery($editQuery);

    header('Location: ./');
}


$query = "SELECT * FROM usersinfo WHERE userInfoID = '$userInfoID'";
$result = executeQuery($query);
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php if (mysqli_num_rows($result) > 0) {
        while ($userInformation = mysqli_fetch_assoc($result)) { ?>

            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-6 mt-5">
                        <form method="post">
                            <div class="my-3">
                                <label for="First name" class="form-label">First name</label>
                                <input value="<?php echo $userInformation['firstName'] ?>" type="text" class="form-control"
                                    name="firstName" placeholder="First name" required>
                            </div>
                            <div class="my-3">
                                <label for="Last name" class="form-label">Last name</label>
                                <input value="<?php echo $userInformation['lastName'] ?>" type="text" class="form-control"
                                    name="lastName" placeholder="Last name" required>
                            </div>
                            <div class="my-3">
                                <label for="Birthday" class="form-label">Birthday</label>
                                <input value="<?php echo $userInformation['birthDay'] ?>" type="text" class="form-control"
                                    name="birthDay" placeholder="Birthday" required>
                            </div>
                            <div class="my-3">
                                <label for="Sexual orientation" class="form-label">Sexual orientation</label>
                                <input value="<?php echo $userInformation['sex'] ?>" type="text" class="form-control" name="sex"
                                    placeholder="sex" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3" name="btnEdit">Save</button>

                        </form>
                    </div>
                </div>
            </div>

        <?php }
    } ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>