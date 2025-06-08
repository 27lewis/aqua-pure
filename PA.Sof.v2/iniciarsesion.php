<?php
require_once 'conexion.php'; // <-- UNCOMMENT THIS LINE!
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor ingresa tu correo y contraseña.';
    } else {
        try { // Added try-catch for database operations
            // Buscar usuario en la base de datos
            $stmt = $conn->prepare("SELECT id, nombre, email, password, tipo_usuario FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // This line now has $conn defined
            
            if ($user && password_verify($password, $user['password'])) {
                // Iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_type'] = $user['tipo_usuario'];
                
                // Redirigir según el tipo de usuario
                if ($user['tipo_usuario'] == 'moderador') {
                    header('Location: panel_moderador.php');
                } else {
                    header('Location: perfil.php');
                }
                exit();
            } else {
                $error = 'Correo electrónico o contraseña incorrectos.';
            }
        } catch (PDOException $e) {
            // Catch any database errors
            $error = 'Error en la base de datos: ' . $e->getMessage();
            // In a production environment, you might log this error instead of displaying it.
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
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="perfil.php" class="btn">Mi Perfil</a>
        <a href="logout.php" class="btn">Cerrar Sesión</a>
      <?php else: ?>
        <a href="iniciarsesion.php" class="btn">Iniciar Sesión</a>
        <a href="registrarse.php" class="btn">Registrarse</a>
      <?php endif; ?>
    </div>
  </nav>
  </header>
  
  <main>
    <div class="contenido">
      <div class="seccion">
        <h2>Iniciar Sesión</h2>
        
        <?php if ($error): ?>
          <div class="error-message" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="iniciarsesion.php" method="post" class="form-login">
          <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
          </div>
          
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
          </div>
          
          <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>
        
        <p style="margin-top: 20px;">¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a></p>
        <p><a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a></p>
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