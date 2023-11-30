<?php
// Verificar si se ha enviado información a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Puedes guardar la información en un archivo de registro
    $archivo = 'registros.txt';
    $contenido = "Nombre: $nombre - Email: $email - Mensaje: $mensaje\n";

    // Guardar en el archivo
    file_put_contents($archivo, $contenido, FILE_APPEND | LOCK_EX);

    // Redirigir a una página de confirmación
    header('Location: confirmacion.html');
    exit;
}
?>
