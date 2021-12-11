<?php
$roomId = filter_input(INPUT_GET, "room_id", FILTER_VALIDATE_INT);
require_once('../utils/db_connect.php');
if ($roomId == null) {
    http_response_code(400);
    echo "<h1>400: Bad request</h1>";
    echo "<h3>Chybný požadavek</h3>";
    echo "<a href='../index.php'>Zpět na prohlížeč databáze</a>";
    echo "<title>400: Bad request</title>";
    exit;
} else {
    $pdo = DB::connect();
    $query = "SELECT r.*, e.name AS employeeName, e.surname AS employeeSur, e.employee_id, (SELECT AVG(e.wage) FROM employee e WHERE e.room = r.room_id) AS avgSalary FROM room r LEFT JOIN employee e ON r.room_id = e.room WHERE r.room_id=?";
    $stmtRoom = $pdo->prepare($query);
    $stmtRoom->execute([$roomId]);

    if ($stmtRoom->rowCount() == 0) {
        http_response_code(404);
        echo "<h1>404: Not found</h1>";
        echo "<h3>Místnost nenalezena</h3>";
        echo "<a href='../index.php'>Zpět na prohlížeč databáze</a>";
        echo "<title>404: Not found</title>";
        exit;
    } else {
        $employees = [];
        while ($row = $stmtRoom->fetch()) {
            $employees[] = $row;
            $room = $row;
        }

        $stmtKey = $pdo->prepare("SELECT a.name, a.surname, a.employee_id FROM employee a INNER JOIN `key` k on a.employee_id = k.employee WHERE k.room=?");
        $stmtKey->execute([$roomId]);
        $keys = [];
        while ($row = $stmtKey->fetch()) {
            $keys[] = $row;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../utils/header_partial.php') ?>
    <title>Karta místnosti č. <?php echo "{$room->no}" ?></title>
</head>
<body class="container">
<h1 class="h1">Místnosti č. <?php echo "{$room->no}"; ?></h1>
<table class="table-sm">
    <tr><th>Číslo</th><td><?php echo $room->no; ?></td></tr>
    <tr><th>Název</th><td><?php echo $room->name; ?></td></tr>
    <tr><th>Telefon</th><td><?php echo $room->phone ?? "----"; ?></td></tr>
    <tr><th>Lidé</th>
        <?php
        if ($room->employee_id){
            $last = end($employees);
            foreach ($employees as $employee) {
                $name = substr($employee->employeeName, 0, 1) . ".";
                echo "<td><a href='kartaUzivatele.php?employee_id={$employee->employee_id}'>{$employee->employeeSur} {$name}</a></td></tr>";
                if ($last != $employee) {
                    echo "<tr><th>&nbsp;</th>";
                }
            }
        } else {
            echo "<td>----</td></tr>";
        }
        ?>
    <tr><th>Průměrná&nbsp;mzda</th><td><?php echo $room->avgSalary ?? "----"; ?></td></tr>
    <tr><th>Klíče</th>
        <?php
        $last = end($keys);
        foreach ($keys as $key) {
            $name = substr($key->name, 0, 1) . ".";
            echo "<td><a href='kartaUzivatele.php?employee_id={$key->employee_id}'>{$key->surname} {$name}</a></td></tr>";
            if ($last != $key) {
                echo "<tr><th>&nbsp;</th>";
            }
        }
        ?>
</table>
<br>
<a href="seznamMistnosti.php"><i class="fas fa-arrow-left"></i>Zpět na seznam místností</a>
</body>
</html>
