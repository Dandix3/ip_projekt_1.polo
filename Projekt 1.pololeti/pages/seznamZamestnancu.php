<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../utils/db_connect.php");
require_once("../utils/methods.php");
$pdo = DB::connect();
$order = filter_input(INPUT_GET, "poradi");
$stmt = $pdo->query(METHODS::employeesOrderBy($order?? ""));
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../utils/header_partial.php') ?>
    <title>Seznam Zaměstanců</title>
</head>
<body class="container">
<h1>Seznam zaměstnanců</h1>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th>Jméno <a <?php echo $order=="prijmeniDown" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=prijmeniDown"><i class="fas fa-arrow-down"></i></a>
                      <a <?php echo $order=="prijmeniUp" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=prijmeniUp"><i class="fas fa-arrow-up"></i></a></th>
            <th>Místnost <a <?php echo $order=="nazevDown" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=nazevDown"><i class="fas fa-arrow-down"></i></a>
                         <a <?php echo $order=="nazevUp" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=nazevUp"><i class="fas fa-arrow-up"></a></th>
            <th>Telefon <a <?php echo $order=="telDown" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=telDown"><i class="fas fa-arrow-down"></i></a>
                        <a <?php echo $order=="telUp" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=telUp"><i class="fas fa-arrow-up"></a></th>
            <th>Pozice <a <?php echo $order=="poziceDown" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=poziceDown"><i class="fas fa-arrow-down"></i></a>
                       <a <?php echo $order=="poziceUp" ? 'class="active"' : " ";?> href="seznamZamestnancu.php?poradi=poziceUp"><i class="fas fa-arrow-up"></a></th>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($employee = $stmt->fetch(PDO::FETCH_OBJ)){
                echo "<tr>";
                echo "<td><a href='kartaUzivatele.php?employee_id={$employee->employee_id}'>{$employee->surname} {$employee->name}</a></td>";
                echo "<td>{$employee->roomName}</td>";
                echo "<td>{$employee->phone}</td>";
                echo "<td>{$employee->job}</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
<a href="../index.php"><i class="fas fa-arrow-left"></i>Zpět na prohlížeč databáze</a>
</body>
</html>

