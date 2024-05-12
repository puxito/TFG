<?php
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD_PDO();

sesionN1();
// Obtener la lista de categorías
$sql_eventos = "SELECT title, start, end, color FROM eventos";
$stmt_eventos = $conn->prepare($sql_eventos);
$stmt_eventos->execute();
$resultado = $stmt_eventos->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($resultado);