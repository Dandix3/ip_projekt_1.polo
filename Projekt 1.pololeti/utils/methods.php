<?php

class METHODS {
    public static function roomsOrderBy(string $order): string {
        switch ($order) {
            case "nazevDown":
                return 'SELECT * FROM room ORDER BY name';
            case "nazevUp":
                return 'SELECT * FROM room ORDER BY name DESC';
            case "cisloDown":
                return 'SELECT * FROM room ORDER BY no';
            case "cisloUp":
                return 'SELECT * FROM room ORDER BY no DESC';
            case "telDown":
                return 'SELECT * FROM room ORDER BY phone';
            case "telUp":
                return 'SELECT * FROM room ORDER BY phone DESC';
            default:
                return 'SELECT * FROM room';
        }
    }

    public static function employeesOrderBy($order): string {
        switch ($order) {
            case "prijmeniDown":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY surname';
            case "prijmeniUp":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY surname DESC ';
            case "nazevDown":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY r.name';
            case "nazevUp":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY r.name DESC';
            case "telDown":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY r.phone';
            case "telUp":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY r.phone DESC';
            case "poziceDown":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY job';
            case "poziceUp":
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id ORDER BY job DESC';
            default:
                return 'SELECT e.*, r.name AS roomName, r.phone FROM employee e INNER JOIN room r ON e.room = r.room_id';
        }
    }
}
