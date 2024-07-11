<?php
// ARCHIVO DE INICIO DE SESIÓN Y REGISTRO
require_once 'conexion.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

    if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
        $error_login = 'Por favor, complete todos los campos';
    } else {
        
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        // Verificar credenciales en la base de datos
        $sql_login = "SELECT * FROM usuario WHERE usua_correo = '$correo' AND usua_password = '$contrasena'";
        $result_login = $conn->query($sql_login);

        if ($result_login->num_rows == 1) {
            
            $_SESSION['correo'] = $correo; 
            
            header("Location: inicio.php"); 
            exit();
        } else {
            $error_login = 'Correo electrónico o contraseña incorrectos';
        }
    }
}

// Procesamiento del formulario de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Verificar si se enviaron todos los campos requeridos
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['contrasena'])) {
        $error_register = 'Por favor, complete todos los campos';
    } else {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        // Verificar si el correo ya está registrado en la base de datos
        $sql_correo = "SELECT * FROM usuario WHERE usua_correo = '$correo'";
        $result_correo = $conn->query($sql_correo);

        if ($result_correo->num_rows > 0) {
            $error_register = 'El correo electrónico ya está registrado';
        } else {
            // Insertar usuario si no está registrado previamente
            $sql_insert = "INSERT INTO usuario (usua_nombre, usua_correo, usua_password) VALUES ('$nombre', '$correo', '$contrasena')";

            if ($conn->query($sql_insert) === TRUE) {
                // Registro exitoso
                $success_register = 'Registro exitoso';
            } else {
                $error_register = 'Error al registrar usuario: ' . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión y Registro</title>
</head>
<body>
   
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inicio de Sesión y Registro</title>
</head>
<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Crea una Cuenta</h1>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit" name="register">Crear</button>
            </form>
            <span><?php echo $error; ?></span>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Iniciar Sesión</h1>
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit" name="login">Iniciar Sesión</button>
            </form>
            <span><?php echo $error; ?></span>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bienvenido</h1>
                    <p>Ingrese sus datos personales para acceder al sitio</p>
                    <button class="hidden" id="login">Iniciar Sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hola!</h1>
                    <p>Ingrese sus datos personales para acceder al sitio</p>
                    <button class="hidden" id="register">Crear Cuenta</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
