<?php
// Iniciar sesión para manejar la sesión del usuario
session_start();

// Variables para mensajes de error y valores del formulario
$error = "";
$email = "";

// Verificar si el formulario ha sido enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // No aplicamos sanitización a la contraseña para no alterarla
    
    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Aquí iría la conexión a la base de datos y la verificación de credenciales
        // Este es un ejemplo simplificado, en una aplicación real deberías:
        // 1. Conectarte a la base de datos
        // 2. Consultar si existe el usuario con ese email
        // 3. Verificar la contraseña hash con password_verify()
        
        // Ejemplo de conexión a base de datos MySQL (descomenta y configura según tus necesidades)
        /*
        $servername = "localhost";
        $username = "usuario_db";
        $password_db = "contraseña_db";
        $dbname = "aquapure_db";
        
        // Crear conexión
        $conn = new mysqli($servername, $username, $password_db, $dbname);
        
        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        // Preparar la consulta (usando sentencias preparadas para evitar inyección SQL)
        $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                // Credenciales correctas
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $email;
                
                // Redirigir a la página de inicio o panel del usuario
                header("Location: panel_usuario.php");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "No se encontró ninguna cuenta con ese correo electrónico.";
        }
        
        $stmt->close();
        $conn->close();
        */
        
        // Para este ejemplo, vamos a simular una autenticación exitosa
        // IMPORTANTE: Esto es solo para demostración, debe reemplazarse con código real
        if ($email === "usuario@ejemplo.com" && $password === "contraseña123") {
            $_SESSION['loggedin'] = true;
            $_SESSION['nombre'] = "Usuario de Ejemplo";
            $_SESSION['email'] = $email;
            
            // Redirigir a la página de inicio o panel del usuario
            header("Location: panel_usuario.php");
            exit;
        } else {
            $error = "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="iniciarsesion.css">
  <title>Aqua Pure - Iniciar Sesión</title>
</head>
<body>
   <header>
    <nav>
      <img src="logo.png" alt="Aqua Pure logo representando la conservación del agua" class="logo" loading="lazy">
      <ul class="nav-links">
        <li><a href="inicio.php">Inicio</a></li>
        <li><a href="guia.php">Guías</a></li>
        <li>
          <a href="#" aria-haspopup="true" aria-expanded="false">Quiénes Somos</a>
          <ul class="sub-menu" role="menu">
            <li><a href="vision.php" role="menuitem">Nuestra Visión</a></li>
            <li><a href="organizacion.php" role="menuitem">Organización</a></li>
            <li><a href="comotrabajamos.php" role="menuitem">Cómo Trabajamos</a></li>
            <li><a href="dondetrabajamos.php" role="menuitem">Dónde Trabajamos</a></li>
          </ul>
        </li>
        <li><a href="foro.php">Foro</a></li>
        <li><a href="contacto.php">Contacto</a></li>
      </ul>
      <div class="auth-buttons">
        <a href="iniciarsesion.php" class="btn">Iniciar Sesión</a>
        <a href="registrarse.php" class="btn">Registrarse</a>
      </div>
    </nav>
  </header>
  <main>
    <div class="contenido">
      <div class="intro">
        <h1>Iniciar Sesión</h1>
      </div>
      <div class="formulario">
        <?php if (!empty($error)): ?>
          <div class="mensaje-error">
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <div class="campo">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="Ingresa tu correo" value="<?php echo htmlspecialchars($email); ?>" required>
          </div>
          <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
          </div>
          <button type="submit" class="btn-form">Iniciar Sesión</button>
          <p class="enlace">¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a></p>
        </form>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 Aqua Pure - Todos los derechos reservados</p>
    <p>Comprometidos con la conservación del agua y el medio ambiente</p>
    <div class="social-links">
      <a href="#">Facebook</a>
      <a href="#">Twitter</a>
      <a href="#">Instagram</a>
      <a href="#">YouTube</a>
    </div>
  </footer>
</body>
</html>