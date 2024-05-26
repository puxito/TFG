<?php
require("../php/funciones.php");

$conn = conectarBBDD();

$sql = "SELECT idProducto, nombreProducto, hcarbonoProducto, caloriasProducto, grasasProducto, proteinasProducto FROM productos";
$result = $conn->query($sql);

$productos = array();
while($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);

$conn->close();
