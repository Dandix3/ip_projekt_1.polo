<?php
require_once("../utils/db_connect.php");
require_once("../utils/methods.php");
$pdo = DB::connect();
$order = filter_input(INPUT_GET, "poradi", FILTER_SANITIZE_STRING);
$stmt = $pdo->query(METHODS::roomsOrderBy($order?? ""));
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../utils/header_partial.php') ?>
    <title>Seznam místností</title>
</head>
<body class="container">
<h1>Seznam místností</h1>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th>Název <a <?php echo $order=="nazevDown" ? 'class="active"' : " ";?> href="seznamMistnosti.php?poradi=nazevDown"><i class="fas fa-arrow-down"></i></a>
                  <a <?php echo $order=="nazevUp" ? 'class="active"' : " ";?> href="seznamMistnosti.php?poradi=nazevUp"><i class="fas fa-arrow-up"></i></a></th>
        <th>Číslo <a <?php echo $order=="cisloDown" ? 'class="active"' : " ";?> href="seznamMistnosti.php?poradi=cisloDown"><i class="fas fa-arrow-down"></i></a>
                  <a <?php echo $order=="cisloUp" ? 'class="active"' : " ";?> href="seznamMistnosti.php?poradi=cisloUp"><i class="fas fa-arrow-up"></i></a></th>
        <th>Telefon <a <?php echo $order=="telDown" ? 'class="active"' : " ";?> href="seznamMistnosti.php?poradi=telDown"><i class="fas fa-arrow-down"></i></a>
                    <a <?php echo $order=="telUp" ? 'class="active"' : " ";?> href="seznamMistnosti.php?poradi=telUp"><i class="fas fa-arrow-up"></i></a></th>
        </tr>
    </thead>
    <tbody>
    <?php
    while ($room = $stmt->fetch(PDO::FETCH_OBJ)){
        echo "<tr>";
        echo "<td><a href='kartaMistnosti.php?room_id={$room->room_id}'>{$room->name}</a></td>";
        echo "<td>{$room->no}</td>";
        if ($room->phone){
            echo "<td>{$room->phone}</td>";
        } else {
            echo "<td>-----</td>";
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<a href="../index.php"><i class="fas fa-arrow-left"></i>Zpět na prohlížeč databáze</a>
</body>
</html>
