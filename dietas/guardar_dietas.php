<?php
require("../php/funciones.php");

$data = json_decode(file_get_contents('php://input'), true);
$nombreDieta = $data['nombreDieta'];
$tipoDieta = $data['tipoDieta'];
$observacionesDieta = $data['observacionesDieta'];
$idUsuario = obtenerIDUsuario();
$comidas = $data['comidas'];

$conn = conectarBBDD();
$conn->begin_transaction();

try {
    // Insertar dieta
    $sqlDieta = "INSERT INTO dietas (nombreDieta, tipoDieta, observacionesDieta, idUsuarioFK) VALUES (?, ?, ?, ?)";
    $stmtDieta = $conn->prepare($sqlDieta);
    $stmtDieta->bind_param("sssi", $nombreDieta, $tipoDieta, $observacionesDieta, $idUsuario);
    $stmtDieta->execute();
    $idDieta = $stmtDieta->insert_id;
    $stmtDieta->close();

    foreach ($comidas as $comida) {
        $nombreComida = $comida['nombreComida'];

        // Insertar comida
        $sqlComida = "INSERT INTO comidas (nombreComida) VALUES (?)";
        $stmtComida = $conn->prepare($sqlComida);
        $stmtComida->bind_param("s", $nombreComida);
        $stmtComida->execute();
        $idComida = $stmtComida->insert_id;
        $stmtComida->close();

        // Asociar comida con dieta
        $sqlDietaComida = "INSERT INTO dietascomidas (idDietaFK, idComidaFK) VALUES (?, ?)";
        $stmtDietaComida = $conn->prepare($sqlDietaComida);
        $stmtDietaComida->bind_param("ii", $idDieta, $idComida);
        $stmtDietaComida->execute();
        $stmtDietaComida->close();

        foreach ($comida['productos'] as $producto) {
            $idProducto = $producto['idProducto'];
            $cantidad = $producto['cantidad'];

            // Obtener datos nutricionales del producto
            $sqlProducto = "SELECT caloriasProducto, grasasProducto, proteinasProducto, hcarbonoProducto FROM productos WHERE idProducto = ?";
            $stmtProducto = $conn->prepare($sqlProducto);
            $stmtProducto->bind_param("i", $idProducto);
            $stmtProducto->execute();
            $stmtProducto->bind_result($caloriasProducto, $grasasProducto, $proteinasProducto, $hcarbonoProducto);
            $stmtProducto->fetch();
            $stmtProducto->close();

            // Calcular valores nutricionales de la comida
            $caloriasComida = $caloriasProducto * $cantidad;
            $grasasComida = $grasasProducto * $cantidad;
            $proteinasComida = $proteinasProducto * $cantidad;
            $hcarbonoComida = $hcarbonoProducto * $cantidad;

            // Insertar producto en la comida
            $sqlComidaProducto = "INSERT INTO comidasproductos (idComidaFK, idProductoFK, cantidad) VALUES (?, ?, ?)";
            $stmtComidaProducto = $conn->prepare($sqlComidaProducto);
            $stmtComidaProducto->bind_param("iid", $idComida, $idProducto, $cantidad);
            $stmtComidaProducto->execute();
            $stmtComidaProducto->close();
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->
    getMessage()]);
}

$conn->close();
