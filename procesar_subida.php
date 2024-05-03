<?php
session_start();
include "php/funciones.php"; // Asegúrate de incluir tu archivo de funciones aqu
include "php/errores.php";

// Verificar si el usuario ha iniciado sesión
sesionN1(); // Cambia a la función de sesión correspondiente si es necesario

// Verificar si se ha enviado un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagen"])) {
    $imagen = $_FILES["imagen"];

    // Directorio donde se guardarán las imágenes
    $directorio_destino = "users/";

    // Nombre único para la imagen
    $nombre_imagen = uniqid('img_') . '_' . $imagen['name'];

    // Ruta completa de la imagen
    $ruta_imagen = $directorio_destino . $nombre_imagen;

    // Mover el archivo cargado al directorio de destino
    if (move_uploaded_file($imagen["tmp_name"], $ruta_imagen)) {
        // Actualizar la ruta de la imagen en la base de datos
        $conn = conectarBBDD();
        $correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
        $sql = "UPDATE usuarios SET imagenUsuario = ? WHERE correoElectronicoUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $ruta_imagen, $correoElectronicoUsuario);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        echo "La imagen se ha subido correctamente.";
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "No se ha enviado ninguna imagen.";
}
