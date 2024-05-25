<?php
session_start();
include "../php/funciones.php";
include "../php/errores.php";

sesionN1();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagenProducto"])) {
    $imagenProducto = $_FILES["imagenProducto"];

    $directorio_destino = "../media/prods/";

    $nombre_imagen = uniqid('img_') . '_' . basename($imagenProducto['name']);

    $ruta_imagen = $directorio_destino . $nombre_imagen;

    if (move_uploaded_file($imagenProducto["tmp_name"], $ruta_imagen)) {

        $conn = conectarBBDD();


        $idProducto = $_POST["idProducto"];

        $sql = "UPDATE productos SET imgProducto = ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $ruta_imagen, $idProducto);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: ../cruds/crud_productos.php");
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "No se ha enviado ninguna imagen.";
}
