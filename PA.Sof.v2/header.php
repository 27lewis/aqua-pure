<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
