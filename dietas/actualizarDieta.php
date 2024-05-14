<?php
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD_PDO();
sesionN1();
// Manejar la actualización del evento en la base de datos
if (isset($_POST['editEventId'])) {
    $eventId = $_POST['editEventId'];
    $title = $_POST['editTitle'];
    $start = $_POST['editStart'];
    $end = $_POST['editEnd'];
    $color = $_POST['editColor'];

    // Actualizar el evento en la base de datos
    $sql_update = "UPDATE eventos SET title = ?, start = ?, end = ?, color = ? WHERE idEvento = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->execute([$title, $start, $end, $color, $eventId]);

    header("Location: ../perfil.php");
} else {
    // Si no se reciben datos por POST, puedes manejarlo de acuerdo a tus necesidades
    echo "No se han recibido datos por POST";
}
