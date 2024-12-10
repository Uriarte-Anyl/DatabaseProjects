<?php
include("connect.php");

$airlineNameFilter = $_GET['airlineName'];
$aircraftTypeFilter = $_GET['aircraftType'];
$sort = $_GET['sort'];
$order = $_GET['order'];

$flightLogsQuery = "SELECT flightNumber, departureAirportCode, arrivalAirportCode, departureDatetime, arrivalDatetime, flightDurationMinutes, airlineName, aircraftType, passengerCount, ticketPrice, pilotName FROM flightLogs";

if ($airlineNameFilter != '' || $aircraftTypeFilter != '') {
  $flightLogsQuery = $flightLogsQuery . " WHERE";

  if ($airlineNameFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " airlineName='$airlineNameFilter'";
  }

  if ($airlineNameFilter != '' && $aircraftTypeFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " AND";
  }

  if ($aircraftTypeFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " aircraftType='$aircraftTypeFilter'";
  }
}

if ($sort != '') {
  $flightLogsQuery = $flightLogsQuery . " ORDER BY $sort";

  if ($order != '') {
    $flightLogsQuery = $flightLogsQuery . " $order";
  }
}

$flightLogsResult = executeQuery($flightLogsQuery);

$airlineNameQuery = "SELECT DISTINCT(airlineName) FROM flightLogs";
$airlineNameResults = executeQuery($airlineNameQuery);

$aircraftTypeQuery = "SELECT DISTINCT(aircraftType) FROM flightLogs";
$aircraftTypeResults = executeQuery($aircraftTypeQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PUP AIRPORT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<style>
  html,
  body {
    background-color: #343434;
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 0;
  }

  .filter-card {
    background-color: #800000;
    color: #faf9f6;
    padding: 1rem;
  }

  .filter-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 15px;
  }

  .filter-item {
    flex: 1 1 calc(25% - 15px);
    min-width: 180px;
  }

  .filter-item label {
    font-size: 0.9rem;
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
  }

  .filter-item select,
  .filter-item button {
    width: 100%;
  }

  .table-wrapper {
    overflow-x: auto;
  }

  .table {
    white-space: nowrap;
  }

  @media (max-width: 768px) {
    .filter-item {
      flex: 1 1 100%;
    }
  }
</style>

<body>
  <div class="container-fluid p-0">
    <form>
      <div class="filter-card text-center">
        <h5>PUP AIRPORT LOGS</h5>
        <div class="filter-container">
          <div class="filter-item">
            <label for="selectAirlineName">Airline Name</label>
            <select name="airlineName" id="selectAirlineName" class="form-select">
              <option value="">Any</option>
              <?php
              if (mysqli_num_rows($airlineNameResults) > 0) {
                while ($airlineNameRow = mysqli_fetch_assoc($airlineNameResults)) {
                  ?>
                  <option <?php if ($airlineNameFilter == $airlineNameRow['airlineName'])
                    echo "selected"; ?>
                    value="<?php echo $airlineNameRow['airlineName'] ?>">
                    <?php echo $airlineNameRow['airlineName'] ?>
                  </option>
                  <?php
                }
              }
              ?>
            </select>
          </div>

          <div class="filter-item">
            <label for="selectAircraftType">Aircraft Type</label>
            <select name="aircraftType" id="selectAircraftType" class="form-select">
              <option value="">Any</option>
              <?php
              if (mysqli_num_rows($aircraftTypeResults) > 0) {
                while ($aircraftTypeRow = mysqli_fetch_assoc($aircraftTypeResults)) {
                  ?>
                  <option <?php if ($aircraftTypeFilter == $aircraftTypeRow['aircraftType'])
                    echo "selected"; ?>
                    value="<?php echo $aircraftTypeRow['aircraftType'] ?>">
                    <?php echo $aircraftTypeRow['aircraftType'] ?>
                  </option>
                  <?php
                }
              }
              ?>
            </select>
          </div>

          <div class="filter-item">
            <label for="sort">Sort By</label>
            <select id="sort" name="sort" class="form-select">
              <option value="">None</option>
              <option <?php if ($sort == "flightNumber")
                echo "selected"; ?> value="flightNumber">Flight Number</option>
              <option <?php if ($sort == "departureDatetime")
                echo "selected"; ?> value="departureDatetime">Departure
                Datetime</option>
              <option <?php if ($sort == "arrivalDatetime")
                echo "selected"; ?> value="arrivalDatetime">Arrival Datetime
              </option>
              <option <?php if ($sort == "flightDurationMinutes")
                echo "selected"; ?> value="flightDurationMinutes">Flight
                Duration</option>
              <option <?php if ($sort == "passengerCount")
                echo "selected"; ?> value="passengerCount">Passenger Count
              </option>
            </select>
          </div>

          <div class="filter-item">
            <label for="order">Order</label>
            <select id="order" name="order" class="form-select">
              <option <?php if ($order == "ASC")
                echo "selected"; ?> value="ASC">Ascending</option>
              <option <?php if ($order == "DESC")
                echo "selected"; ?> value="DESC">Descending</option>
            </select>
          </div>
        </div>
        <div class="text-center mt-3">
          <button class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>

    <div class="table-wrapper">
      <table class="table table-dark table-hover text-center">
        <thead>
          <tr>
            <th>Flight Number</th>
            <th>Departure Airport Code</th>
            <th>Arrival Airport Code</th>
            <th>Departure Datetime</th>
            <th>Arrival Datetime</th>
            <th>Flight Duration</th>
            <th>Airline Name</th>
            <th>Aircraft Type</th>
            <th>Passenger Count</th>
            <th>Ticket Price</th>
            <th>Pilot Name</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($flightLogsResult) > 0) {
            while ($flightLogsRow = mysqli_fetch_assoc($flightLogsResult)) {
              ?>
              <tr>
                <td><?php echo $flightLogsRow['flightNumber'] ?></td>
                <td><?php echo $flightLogsRow['departureAirportCode'] ?></td>
                <td><?php echo $flightLogsRow['arrivalAirportCode'] ?></td>
                <td><?php echo $flightLogsRow['departureDatetime'] ?></td>
                <td><?php echo date('y-m-d', strtotime($flightLogsRow['arrivalDatetime'])) ?></td>
                <td><?php echo $flightLogsRow['flightDurationMinutes'] ?></td>
                <td><?php echo $flightLogsRow['airlineName'] ?></td>
                <td><?php echo $flightLogsRow['aircraftType'] ?></td>
                <td><?php echo $flightLogsRow['passengerCount'] ?></td>
                <td><?php echo $flightLogsRow['ticketPrice'] ?></td>
                <td><?php echo $flightLogsRow['pilotName'] ?></td>
              </tr>
              <?php
            }
          } else {
            ?>
            <tr>
              <td colspan="11">No flight logs available</td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>