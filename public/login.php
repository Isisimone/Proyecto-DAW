<?php
session_start();

require '../vendor/autoload.php';

// Si ya hay una sesión activa, redirigir al dashboard
if (isset($_SESSION['COD_USUARIO'])) {
    if (in_array('Admin',$_SESSION['ROLES'])){
        header('Location: administracion.php');
        exit();
    }
    if (in_array('Empleado',$_SESSION['ROLES'])){
        header('Location: empleado.php');
        exit();
    }
    if (in_array('Conserje',$_SESSION['ROLES'])){
        header('Location: wellcome.php');
        exit();
    }
    
}

use Clases\Usuario;
use Clases\Rol;
use Clases\Transaccion;

$error="";

// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Crear un objeto de la clase Usuario y verificar las credenciales
    $usuarioObj = new Usuario;
    echo $usuario." - ". $contrasena;
    if ($usuarioObj->iniciarSesion($usuario, $contrasena)) {
        $error="";
        //header('Location: wellcome.php'); // Redirigir al dashboard si el login es correcto
        //exit();
    } else {
        $error = 'Usuario o contraseña incorrectos'; // Mostrar error si las credenciales son incorrectas
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <!-- Espacio reservado para mostrar errores -->
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>

