<?php
require_once 'conexion.php';
session_start();

// Redirigir si no está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: iniciarsesion.php');
    exit();
}

// Obtener información del usuario
$stmt = $conn->prepare("SELECT nombre, email, tipo_usuario, fecha_registro FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: iniciarsesion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="miperfil.css">
  <title>Aqua Pure - Mi Perfil</title>
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
        <a href="perfil.php" class="btn">Mi Perfil</a>
        <a href="logout.php" class="btn">Cerrar Sesión</a>
      </div>
    </nav>
  </header>
  
  <main>
    <div class="contenido">
      <div class="seccion">
        <h2>Mi Perfil</h2>
        
        <div class="profile-info">
          <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user['nombre']); ?></p>
          <p><strong>Correo electrónico:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
          <p><strong>Tipo de usuario:</strong> <?php echo $user['tipo_usuario'] == 'moderador' ? 'Moderador' : 'Cliente'; ?></p>
          <p><strong>Miembro desde:</strong> <?php echo date('d/m/Y', strtotime($user['fecha_registro'])); ?></p>
        </div>
        
        <div class="profile-actions">
          <a href="editar_perfil.php" class="btn-action">Editar Perfil</a>
          <a href="cambiar_contrasena.php" class="btn-action">Cambiar Contraseña</a>
          <?php if ($user['tipo_usuario'] == 'moderador'): ?>
            <a href="panel_moderador.php" class="btn-action">Panel de Moderador</a>
          <?php endif; ?>
        </div>
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