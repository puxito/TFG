<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Foto de Perfil</title>
</head>
<body>
    <h2>Subir Foto de Perfil</h2>
    <form action="procesar_subida.php" method="post" enctype="multipart/form-data">
        <label for="imagen">Seleccione una imagen:</label><br>
        <input type="file" id="imagen" name="imagen" accept="image/*"><br>
        <input type="submit" value="Subir Foto">
    </form>
</body>
</html>
