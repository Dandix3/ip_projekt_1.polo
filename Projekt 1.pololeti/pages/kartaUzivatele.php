<?php
$employeeId = filter_input(INPUT_GET, "employee_id", FILTER_VALIDATE_INT);
require_once("../utils/db_connect.php");
if ($employeeId == null) {
    http_response_code(400);
    echo "<h1>Bad request</h1>";
    echo "<h3>Chybný požadavek</h3>";
    echo "<a href='../index.php'>Zpět na prohlížeč databáze</a>";
    echo "<title>400: Bad request</title>";
    exit;
} else {
    $query = "SELECT * FROM employee WHERE employee_id=?";
    $pdo = DB::connect();
    $stmtEmployee = $pdo->prepare($query);
    $stmtEmployee->execute([$employeeId]);
    if ($stmtEmployee->rowCount() == 0) {
        http_response_code(404);
        echo "<h1>Not found</h1>";
        echo "<h3>Uživatel nenalezen</h3>";
        echo "<a href='../index.php'>Zpět na prohlížeč databáze</a>";
        echo "<title>404: Not found</title>";
        exit;
    } else {
        $employee = $stmtEmployee->fetch();

        $stmtRoom = $pdo->prepare("SELECT a.name, a.room_id FROM room a INNER JOIN `key` k ON a.room_id = k.room WHERE employee=?");
        $rooms = [];
        while ($row = $stmtRoom->fetch()) {
            $rooms[$row->room_id] = $row;
        }

        $sur = substr($employee->surname, 0, 1) . ".";
        $wage = number_format($employee->wage, 2, ',', '.');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../utils/header_partial.php') ?>
    <title>Karta uživatele <?php echo "{$employee->name} {$sur}" ?></title>
</head>
<body class="container">
<h1 class="h1">Karta osoby: <?php echo "{$employee->name} {$sur}"; ?></h1>
<table class="table-sm">
    <tr><th>Jméno</th><td><?php echo "{$employee->name}"; ?></td></tr>
    <tr><th>Příjmení</th><td><?php echo "{$employee->surname}"; ?></td></tr>
    <tr><th>Pozice</th><td><?php echo "{$employee->job}"; ?></td></tr>
    <tr><th>Mzda</th><td><?php echo "{$wage}"; ?></td></tr>
    <tr><th>Místnost</th><td><a href="kartaMistnosti.php?room_id=<?php echo "{$rooms[$employee->room]->room_id}" ?>"><?php echo "{$rooms[$employee->room]->name}"; ?></a></td></tr>
    <tr><th>klíče</th>
        <?php
        $last = end($rooms);
        foreach ($rooms as $room) {
            echo "<td><a href='kartaMistnosti.php?room_id={$room->room_id}'>{$room->name}</a></td></tr>";
            if ($last != $room) {
                echo "<tr><th>&nbsp;</th>";
            }
        }
        ?>
</table>
<br>
<a href="seznamZamestnancu.php"><i class="fas fa-arrow-left"></i>Zpět na seznam zaměstnanců</a>
</body>
</html>
