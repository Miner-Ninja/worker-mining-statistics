<!DOCTYPE html>
<html>
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3522P3B6LW"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-3522P3B6LW');
</script>

    <title>Pooltemp.Qubic.Solutions - Mining Statistics</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #05070d;
            color: #61e0ff;
            padding-top: 5px; /* Add padding to body to move content below the top */
            text-align: center; /* Center-align content */
        }
        h1 {
            margin-top: 20px; /* Add margin to H1 text */
            color: #61e0ff; /* Text color */
        }
        h4 {
            color: #61e0ff; /* Text color */
            font-size: 18px; /* Decrease font size */
        }
        h5 {
            color: #61e0ff; /* Text color */
            font-size: 14px; /* Font size for h5 */
        }
        h6 {
            color: #213173; /* Text color */
            font-size: 10px; /* Decrease font size */
        }
        .table {
            border-top: 1px solid #61e0ff;
            border-collapse: collapse;
            width: 100%;
            color: #61e0ff; /* Table text color */
        }
        .table th {
            border-top: 1px solid #61e0ff;
            background-color: #101a45;
        }
        th, td {
            border: 1px solid #61e0ff; /* Table border color */
            text-align: left;
            padding: 8px;
            cursor: pointer; /* Add cursor pointer to indicate clickable */
            width: calc(100% / 3); /* Equal width for each column */
        }
        tr:hover {
            background-color: #0f2040; /* Change background color on hover */
        }

    </style>
</head>
<body>

<h1>Pooltemp.Qubic.Solutions - Workers mining statistics</h1>
<h5>This page shows statistics only for the last EP.</h5>
<h5>All statistics will be reset with each new EP.</h5>

<div class="container mt-5">
    <form method="get" class="form-inline">
        <input type="text" id="miner" name="miner" pattern="[A-Za-z0-9]+" title="Only alphabetical characters and digits are allowed" required class="form-control mr-2" style="width: 90%; background-color: #0f2040; color: #61e0ff; border-color: #61e0ff;" value="<?php if(isset($_GET['miner'])) { echo $_GET['miner']; } ?>" placeholder="Please enter your QUBIC wallet ID" placeholder="Please enter your QUBIC wallet ID">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
    if(isset($_GET['miner'])){
        $miner_id = $_GET['miner'];
        $url = "https://pooltemp.qubic.solutions/info?miner=$miner_id&list=true";

        // Fetch JSON data from URL
        $json_data = file_get_contents($url);

        // Decode JSON data into associative array
        $data = json_decode($json_data, true);

        if ($data) {
            // Display additional row for iterrate, devices, solutions
            echo "<table class='table mt-4'>";
            echo "<tr><th>&#x2622; Iterrates (Hashrate)</th><th>&#x2692; Devices</th><th>&#9745; Solutions</h6></th></tr>";
            echo "<tr>";
            echo "<td>{$data['iterrate']}</td>";
            echo "<td>{$data['devices']}</td>";
            echo "<td>{$data['solutions']}</td>";
            echo "</tr>";
            echo "</table>";

            // Display device_list data in table
            echo "<br>";
            echo "<table id='deviceTable' class='table'>";
            echo "<tr><th onclick='sortTable(0)'>Worker Name (Label) &#8645;</th><th onclick='sortTable(1)'>Last Itterate &#8645;</th><th onclick='sortTable(2)'>Solutions &#8645;</th></tr>";
            foreach ($data['device_list'] as $device) {
                echo "<tr>";
                echo "<td>{$device['label']}</td>";
                echo "<td>{$device['last_iterrate']}</td>";
                echo "<td>{$device['solutions']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='mt-4'>Please wait to many requests. Failed to fetch data from the URL.</p>";
        }
    }
    ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("deviceTable");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                if (dir === "asc") {
                    if (columnIndex === 0) {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                } else if (dir === "desc") {
                    if (columnIndex === 0) {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

</body>
</html>
