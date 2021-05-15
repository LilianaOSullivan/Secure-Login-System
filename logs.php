<?php
    require_once('_pages/_logs.php');
?>
<html>
<head>
    <title>View Logs</title>
    <link rel="stylesheet" href="static/css/main.css">
    <link rel="stylesheet" href="static/css/logs.css">
    <script src="static/js/logs.js"></script>
</head>

<body>
    <?php include("static/components/navigation.php"); ?>
    <div>
        <div class="form_outline">
            <div style="margin:30px">
                <table id="logs_table" style="width:100%;">
                    <thead>
                        <tr>
                            <th onclick="sort_table(0)">ID</th>
                            <th onclick="sort_table(1)">Action</th>
                            <th onclick="sort_table(2)">IP</th>
                            <th onclick="sort_table(3)" class="desc">Timestamp</th>
                            <th onclick="sort_table(4)">Outcome</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($row = $result->fetch_assoc())
                            {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['action'] . "</td>";
                                echo "<td>" . $row['ip'] . "</td>";
                                echo "<td>" . $row['timestamp'] . "</td>";
                                echo "<td>" . $row['outcome'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>