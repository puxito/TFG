<?php
require("../php/errores.php");
require("../php/funciones.php");

sesionN1();
// CONEXION
$conn = conectarBBDD_PDO();
// Obtener el correo electrónico del usuario actualmente conectado
$correoElectronicoUsuario = obtenerCorreoElectronicoUsuario();

// Obtener el ID del usuario correspondiente al correo electrónico
$idUsuario = obtenerIDUsuarioPorCorreo($correoElectronicoUsuario);

// Obtener los datos del formulario de edición
$eventId = $_POST['editEventId'];
$idUsuario = $_POST['idUsuario']; 
$title = $_POST['editTitle']; 
$start = $_POST['editStart']; 
$end = $_POST['editEnd']; 
$color = $_POST['editColor']; 

// Actualizar el evento en la base de datos
$sql_update = "UPDATE eventos SET title = ?, start = ?, end = ?, color = ? WHERE idEvento = ? AND idUsuario = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->execute([$title, $start, $end, $color, $eventId, $idUsuario]);

header("Location: ../perfil.php");
