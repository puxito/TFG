<?php
function conectarBBDD()
{
    $servidor = "localhost";
    $usuario = "ivanpuxito";
    $clave = "1234";
    $bbdd = "BD_FitFood";

    // Objeto conexión
    $conn = new mysqli($servidor, $usuario, $clave, $bbdd);

    if ($conn->connect_error) {
        die("Error de Conexión: " . $conn->connect_error);
    }

    return $conn;
}

// SESIONES PARA USUARIOS NORMALES
function sesionN1()
{
    // Iniciar la sesión si no está iniciada
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Salir de la sesión si se ha enviado la solicitud 'salir'
    if (isset($_REQUEST['cerses'])) {
        session_destroy();
        header("Location: ../php/login.php");
        exit();
    }


    if (isset($_GET['cerses']) && $_GET['cerses'] == 'true') {
        echo "<script>alert('Tu sesión ha sido cerrada.');</script>";
    }

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION["correoElectronicoUsuario"])) {
        return true; // Usuario ha iniciado sesión
    } else {
        return false; // Usuario no ha iniciado sesión
    }
}

// SESIONES PARA USUARIOS ADMINISTRADORES
function sesionN2()
{
    session_start();

    // Salir de la sesión si se ha enviado la solicitud 'salir'
    if (isset($_REQUEST['cerses'])) {
        session_destroy();
        header("Location: ../php/login.php");
        exit();
    }
    
    if (isset($_GET['cerses']) && $_GET['cerses'] == 'true') {
        echo "<script>alert('Tu sesión ha sido cerrada.');</script>";
    }

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION["correoElectronicoUsuario"])) {
        // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: ../php/login.php");
        exit();
    }
    


    // VERIFICAR USUARIO ADMINISTRADOR
    $conn = conectarBBDD();
    $correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
    $sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correoElectronicoUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $rol = $fila["idRolFK"];
    $stmt->close();
    $conn->close();

    // Verificar si el usuario es administrador (idRolFK = 1)
    if ($rol != 1) {
        // El usuario no es administrador, redirigir a una página de acceso denegado
        header("Location:../php/denegado.php");
        exit();
    }
}

// SESIONES PARA USUARIOS ADMINISTRADORES
function sesionN3()
{
    session_start();

    // Salir de la sesión si se ha enviado la solicitud 'salir'
    if (isset($_REQUEST['cerses'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
    if (isset($_GET['cerses']) && $_GET['cerses'] == 'true') {
        echo "<script>alert('Tu sesión ha sido cerrada.');</script>";
    }

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION["correoElectronicoUsuario"])) {
        // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: login.php");
        exit();
    }


    // VERIFICAR USUARIO ADMINISTRADOR
    $conn = conectarBBDD();
    $correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
    $sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correoElectronicoUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $rol = $fila["idRolFK"];
    $stmt->close();
    $conn->close();

    // Verificar si el usuario es administrador (idRolFK = 1)
    if ($rol != 1) {
        // El usuario no es administrador, redirigir a una página de acceso denegado
        header("Location:denegado.php");
        exit();
    }
}

// SESIONES PARA USUARIOS ADMINISTRADORES
function sesionN4()
{
    session_start();

    // Salir de la sesión si se ha enviado la solicitud 'salir'
    if (isset($_REQUEST['cerses'])) {
        session_destroy();
        header("Location: php/login.php");
        exit();
    }
    
    if (isset($_GET['cerses']) && $_GET['cerses'] == 'true') {
        echo "<script>alert('Tu sesión ha sido cerrada.');</script>";
    }

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION["correoElectronicoUsuario"])) {
        // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: php/login.php");
        exit();
    }


    // VERIFICAR USUARIO ADMINISTRADOR
    $conn = conectarBBDD();
    $correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
    $sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correoElectronicoUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $rol = $fila["idRolFK"];
    $stmt->close();
    $conn->close();

    // Verificar si el usuario es administrador (idRolFK = 1)
    if ($rol != 1) {
        // El usuario no es administrador, redirigir a una página de acceso denegado
        header("Location: php/denegado.php");
        exit();
    }
}



// INICIO DE SESION
function inicioSesion($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Consulta SQL para buscar por correo electrónico
        $sql = "SELECT correoElectronicoUsuario, contraseña FROM usuarios WHERE correoElectronicoUsuario = ?";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("s", $email);

        // Ejecutar la sentencia
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $fila = $result->fetch_assoc();
            $hash_almacenado = $fila["contraseña"];

            // Verificar si la contraseña coincide
            if (password_verify($password, $hash_almacenado)) {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION["correoElectronicoUsuario"] = $fila["correoElectronicoUsuario"];
                // Redirigir a la página de inicio
                header("Location: menubienvenida.php");
                echo "¡Inicio de sesión exitoso!";
                exit();
            } else {
                echo "Correo electrónico o contraseña incorrectos";
            }
        } else {
            echo "Correo electrónico o contraseña incorrectos.";
        }

        if ($stmt->error) {
            echo "Error en la ejecución de la consulta: " . $stmt->error;
            exit();
        }

        // Cerrar la sentencia
        $stmt->close();
    }
}


// Función para obtener la ruta de la imagen del usuario actual
function obtenerRutaImagenUsuario() {
    // Verificar si el usuario ha iniciado sesión
    sesionN1(); // Cambia a la función de sesión correspondiente si es necesario

    // Obtener la ruta de la imagen del usuario actual desde la base de datos
    $conn = conectarBBDD();
    $correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
    $sql = "SELECT imagenUsuario FROM usuarios WHERE correoElectronicoUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correoElectronicoUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $ruta_imagen = $fila["imagenUsuario"];
    $stmt->close();
    $conn->close();

    return $ruta_imagen;
}

function obtenerNombreUsuario(){
    // Verificar si el usuario ha iniciado sesión
    sesionN1(); // Cambia a la función de sesión correspondiente si es necesario

    // Obtener el nombre del usuario actual desde la base de datos
    $conn = conectarBBDD();
    $correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
    $sql = "SELECT nombreUsuario FROM usuarios WHERE correoElectronicoUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correoElectronicoUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $nombreUsuario = $fila["nombreUsuario"];
    $stmt->close();
    $conn->close();

    return $nombreUsuario;
}

function verificarrol(){
    sesionN1();
    $conn = conectarBBDD();
    $correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
    $sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $correoElectronicoUsuario); // Cambiado a "s" para cadena de texto
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $idRolFK = $fila["idRolFK"];
    $stmt->close();
    $conn->close();

    return $idRolFK;
}