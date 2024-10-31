<?php
include('connect.php');

$sql = "SELECT *FROM usersinfo";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LinkME</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Quicksand:wght@300..700&display=swap"
    rel="stylesheet">
</head>

<style>
  html,
  body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
  }

  [data-bs-theme="light"] {
    --bs-body-bg: #faf9f6;
  }

  [data-bs-theme="dark"] {
    --bs-body-bg: #28282B;
  }

  [data-bs-theme="dark"] .btnMode {
    --bs-body-bg: #28282B;
    color: #f9f6ee;
  }

  [data-bs-theme="dark"] .btnShowInfo {
    --bs-body-bg: #28282B;
    background-color: #71797E;
    color: #f9f6ee;
  }

  [data-bs-theme="dark"] .card {
    --bs-body-bg: #28282B;
    background-color: #faf9f6;
    color: #28282B;
  }

  .logo {
    font-size: 20px;
    color: white;
    font-family: 'Paytone One', sans-serif;
  }

  .navbar {
    background-color: #28282B;
  }

  .options {
    color: white;
    font-family: 'Quicksand', sans-serif;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: .75rem;
  }

  .btnMode {
    border: none;
    border-radius: 10px;
    font-size: .75rem;
    border: none;
  }

  .btnShowInfo {
    border-radius: 10px;
    font-family: 'Quicksand', sans-serif;
    font-size: 1.25rem;
    margin: 20px 0px 10px 0px;
    border: none;
    background-color: #C0C0C0;
  }

  .btnShowFriends {
    border-radius: 10px;
    font-family: 'Quicksand', sans-serif;
    font-size: 1.25rem;
    margin: 20px 0px 10px 0px;
    border: none;
    background-color: #C0C0C0;
  }

  .card {
    margin: 20px 5px 20px 5px;
  }

  .fullName {
    display: flex;
    align-items: center;
    gap: .3125rem;
  }
</style>


<body id="body" data-bs-theme="light">
  <div class="container-fluid">
    <div class="row navbar">
      <div class="col d-flex justify-content-between">
        <div class="logo">LinkMe with friends</div>
        <div class="options">
          <span>
            Home
          </span>
          <span>
            <button class="btnMode" id="btnMode" onclick="changeBgColorMode()">Dark Mode</button>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col d-flex justify-content-center">
        <button class="btnShowInfo" id="btnShowInfo" onclick="btnExpand()">Users Information</button>
      </div>
    </div>
  </div>

  <div class="container" id="friendRequestContent" style="display: none;">
    <div class="row">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '
              <div class="col-12 col-md-6 col-lg-3">
                  <div class="card">
                      <img class="card-img-top">
                      <div class="card-body">
                          <div class="fullName">
                              <h5 class="card-firstName">' . htmlspecialchars($row["firstName"]) . '</h5>
                              <h5 class="card-lastName">' . htmlspecialchars($row["lastName"]) . '</h5>
                          </div>
                          <p class="card-sex">Sex: ' . htmlspecialchars($row["sex"]) . '</p>
                          <p class="card-birthDay">Birthday: ' . htmlspecialchars($row["birthDay"]) . '</p>
                      </div>
                  </div>
              </div>';
        }
      }
      ?>
    </div>
  </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script>
    var bgColorMode = "light";
    function changeBgColorMode() {
      if (bgColorMode == "light") {
        document.getElementById("body").setAttribute("data-bs-theme", "dark");
        document.getElementById("btnMode").innerHTML = "Light Mode";
        bgColorMode = "dark";
      } else {
        document.getElementById("body").setAttribute("data-bs-theme", "light");
        document.getElementById("btnMode").innerHTML = "Dark Mode";
        bgColorMode = "light";
      }
    }

    var display = "none";

    function btnExpand() {
      var fRContent = document.getElementById("friendRequestContent");
      var btnShowInfo = document.getElementById("btnShowInfo");

      if (display == "none") {
        fRContent.style.display = "block";
        display = "block";
        btnShowInfo.innerHTML = "Collapse";
      } else {
        fRContent.style.display = "none";
        display = "none";
        btnShowInfo.innerHTML = "Users Information";
      }
    }
  </script>
</body>

</html>
