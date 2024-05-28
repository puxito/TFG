<?php
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

// Verificar si hay una sesión iniciada
sesionN1();



// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombreUsuario = $_POST["nombreUsuario"];
    $apellidosUsuario = $_POST["apellidosUsuario"];
    $nombreDieta = $_POST["nombreDieta"];
    $tipoDieta = $_POST["tipoDieta"];
    $numComidas = $_POST["numComidas"];

    // Conectar a la base de datos
    $mysqli = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");

    // Verificar conexión
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Insertar los datos de la dieta en la base de datos
    $sql_insert_dieta = "INSERT INTO dietas (usuario_id, nombre, tipo) VALUES (?, ?, ?)";
    $stmt_insert_dieta = $mysqli->prepare($sql_insert_dieta);
    $stmt_insert_dieta->bind_param("iss", $usuario_id, $nombreDieta, $tipoDieta);

    // Obtener el ID del usuario
    $sql_select_usuario_id = "SELECT idUsuario FROM usuarios WHERE nombreUsuario = ? AND apellidosUsuario = ?";
    $stmt_select_usuario_id = $mysqli->prepare($sql_select_usuario_id);
    $stmt_select_usuario_id->bind_param("ss", $nombreUsuario, $apellidosUsuario);
    $stmt_select_usuario_id->execute();
    $result_select_usuario_id = $stmt_select_usuario_id->get_result();
    $row_select_usuario_id = $result_select_usuario_id->fetch_assoc();
    $usuario_id = $row_select_usuario_id["idUsuario"];

    // Verificar si se encontró el ID del usuario
    if ($usuario_id) {
        // Insertar la dieta
        if ($stmt_insert_dieta->execute()) {
            $dieta_id = $stmt_insert_dieta->insert_id;

            // Insertar las comidas de la dieta
            for ($i = 1; $i <= $numComidas; $i++) {
                $sql_insert_comida = "INSERT INTO comidas (dieta_id, numero_comida) VALUES (?, ?)";
                $stmt_insert_comida = $mysqli->prepare($sql_insert_comida);
                $stmt_insert_comida->bind_param("ii", $dieta_id, $i);
                $stmt_insert_comida->execute();
            }

            echo "Los datos se han guardado correctamente.";
        } else {
            echo "Error al guardar los datos de la dieta: " . $stmt_insert_dieta->error;
        }
    } else {
        echo "No se pudo encontrar el ID del usuario.";
    }

    // Cerrar la conexión
    $stmt_insert_dieta->close();
    $stmt_select_usuario_id->close();
    $mysqli->close();
}




$sql = "
SELECT 
    u.nombreUsuario,
    u.apellidosUsuario,
    d.nombre AS nombreDieta,
    d.tipo AS tipoDieta,
    c.numero_comida,
    GROUP_CONCAT(p.nombreProducto SEPARATOR ', ') AS productos
FROM 
    usuarios u
JOIN 
    dietas d ON u.idUsuario = d.usuario_id
JOIN 
    comidas c ON d.id = c.dieta_id
JOIN 
    comidas_productos cp ON c.id = cp.comida_id
JOIN 
    productos p ON cp.producto_id = p.idProducto
GROUP BY 
    u.nombreUsuario,
    u.apellidosUsuario,
    d.nombre,
    d.tipo,
    c.numero_comida
ORDER BY 
    u.nombreUsuario,
    d.nombre,
    c.numero_comida;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario_anterior = null;
    $dieta_anterior = null;
    while($row = $result->fetch_assoc()) {
        if ($usuario_anterior != $row["nombreUsuario"]) {
            echo "<strong>Nombre Usuario:</strong> " . $row["nombreUsuario"] . " " . $row["apellidosUsuario"] . "<br>";
            $usuario_anterior = $row["nombreUsuario"];
        }
        if ($dieta_anterior != $row["nombreDieta"]) {
            echo "<strong>Nombre Dieta:</strong> " . $row["nombreDieta"] . "<br>";
            echo "<strong>Tipo Dieta:</strong> " . $row["tipoDieta"] . "<br>";
            $dieta_anterior = $row["nombreDieta"];
        }
        echo "<strong>Número Comida:</strong> " . $row["numero_comida"] . "<br>";
        echo "<strong>Productos:</strong> " . $row["productos"] . "<br><br>";
    }
} else {
    echo "0 resultados";
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar y ver dietas</title>
</head>
<body>
    <h2>Formulario de Dietas</h2>
    <form action="procesar_formulario.php" method="post">
        <label for="nombreDieta">Nombre de la Dieta:</label><br>
        <input type="text" id="nombreDieta" name="nombreDieta" required><br><br>
        
        <label for="tipoDieta">Tipo de Dieta:</label><br>
        <input type="text" id="tipoDieta" name="tipoDieta" required><br><br>
        
        <label for="numComidas">Número de Comidas:</label><br>
        <input type="number" id="numComidas" name="numComidas" min="1" max="6" required><br><br>
        
        <?php
        // Obtener nombre y apellidos del usuario de la sesión
        $nombreUsuario = $_SESSION["nombreUsuario"];
        $apellidosUsuario = $_SESSION["apellidosUsuario"];
        ?>
        
        <!-- Campos ocultos para enviar nombre y apellidos del usuario -->
        <input type="hidden" id="nombreUsuario" name="nombreUsuario" value="<?php echo $nombreUsuario; ?>">
        <input type="hidden" id="apellidosUsuario" name="apellidosUsuario" value="<?php echo $apellidosUsuario; ?>">
        
        <input type="submit" value="Enviar">
    </form>
</html>