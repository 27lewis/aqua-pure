<?php
// Iniciar sesión para manejar la sesión del usuario tras registro exitoso
session_start();

// Variables para mensajes de error y valores del formulario
$error = "";
$nombre = "";
$email = "";
$registro_exitoso = false;

// Verificar si el formulario ha sido enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // No sanitizamos para no alterar la contraseña
    $confirm_password = $_POST['confirm-password'];
    
    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Por favor, complete todos los campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingrese un correo electrónico válido.";
    } elseif (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Aquí iría la conexión a la base de datos y el registro del usuario
        // Este es un ejemplo simplificado, en una aplicación real deberías:
        // 1. Conectarte a la base de datos
        // 2. Verificar si el email ya está registrado
        // 3. Hashear la contraseña con password_hash()
        // 4. Insertar el nuevo usuario en la base de datos
        
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
        
        // Verificar si el email ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Este correo electrónico ya está registrado. Por favor, utilice otro o inicie sesión.";
        } else {
            // Hashear la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insertar nuevo usuario
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, fecha_registro) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $nombre, $email, $hashed_password);
            
            if ($stmt->execute()) {
                // Registro exitoso
                $registro_exitoso = true;
                
                // Opcional: iniciar sesión automáticamente tras el registro
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $conn->insert_id;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['email'] = $email;
                
                // Redirigir a página de bienvenida o panel de usuario
                header("Location: bienvenida.php");
                exit;
            } else {
                $error = "Error al registrar el usuario: " . $stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
        */
        
        // Para este ejemplo, simularemos un registro exitoso
        // IMPORTANTE: Esto es solo para demostración, debe reemplazarse con código real
        $registro_exitoso = true;
        $_SESSION['loggedin'] = true;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['email'] = $email;
        
        // Redirigir a la página de bienvenida
        header("Location: bienvenida.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="registrarse.css">
  <title>Aqua Pure - Registrarse</title>
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
        <h1>Registrarse</h1>
      </div>
      <div class="formulario">
        <?php if (!empty($error)): ?>
          <div class="mensaje-error">
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>
        
        <?php if ($registro_exitoso): ?>
          <div class="mensaje-exito">
            ¡Registro exitoso! Redirigiendo...
          </div>
        <?php else: ?>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="campo">
              <label for="nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <div class="campo">
              <label for="email">Correo Electrónico</label>
              <input type="email" id="email" name="email" placeholder="Ingresa tu correo" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="campo">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
              <small>La contraseña debe tener al menos 8 caracteres</small>
            </div>
            <div class="campo">
              <label for="confirm-password">Confirmar Contraseña</label>
              <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirma tu contraseña" required>
            </div>
            <button type="submit" class="btn-form">Registrarse</button>
            <p class="enlace">¿Ya tienes una cuenta? <a href="iniciarsesion.php">Inicia sesión aquí</a></p>
          </form>
        <?php endif; ?>
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