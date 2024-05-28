<?php
require("../php/errores.php");
require("../php/funciones.php");

$conn = conectarBBDD();

// Recibir los datos de la dieta desde la solicitud
$data = json_decode(file_get_contents("php://input"), true);

$nombreDieta = $data['nombreDieta'];
$tipoDieta = $data['tipoDieta'];
$numComidas = $data['numComidas'];
$comidas = $data['comidas'];

// Insertar la dieta en la base de datos
$sql_dieta = "INSERT INTO dietas (nombreDieta, tipoDieta, idUsuarioFK) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql_dieta);
$stmt->bind_param("ssi", $nombreDieta, $tipoDieta, $idUsuario);
$stmt->execute();
$id_dieta = $stmt->insert_id;
$stmt->close();

// Insertar cada comida y sus productos
foreach ($comidas as $comida) {
    // Insertar la comida
    $sql_comida = "INSERT INTO comidas (idDietaFK) VALUES (?)";
    $stmt = $conn->prepare($sql_comida);
    $stmt->bind_param("i", $id_dieta);
    $stmt->execute();
    $id_comida = $stmt->insert_id;
    $stmt->close();

    // Insertar los productos de la comida
    foreach ($comida as $producto) {
        $id_producto = $producto['idProducto'];
        $cantidad_gramos = $producto['cantidad'];

        $sql_comida_producto = "INSERT INTO comidasProductos (idComidaFK, idProductoFK, cantidadGramos) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_comida_producto);
        $stmt->bind_param("iii", $id_comida, $id_producto, $cantidad_gramos);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

echo json_encode(["success" => true]);
