<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aqua Pure - Foro de la Comunidad</title>
  <link rel="stylesheet" href="foro.css" />
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
        <h1>Foro de la Comunidad</h1>
        <p>Comparte ideas, dudas y sugerencias con otros usuarios.</p>
      </div>

      <div class="foro-container">
        <div class="foro-mensajes" id="foro-mensajes">
          <!-- Aquí se verán los mensajes -->
          <div class="mensaje">
            <strong>Usuario1:</strong> ¡Hola a todos! ¿Cómo podemos ahorrar más agua?
          </div>
          <div class="mensaje">
            <strong>Usuario2:</strong> Una idea es reutilizar el agua de la lavadora para el baño.
          </div>
        </div>

        <form class="foro-form" id="foro-form">
          <textarea id="mensaje" rows="3" placeholder="Escribe tu mensaje aquí..." required></textarea>
          <button type="submit">Enviar</button>
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

  <script>
    const form = document.getElementById('foro-form');
    const mensajes = document.getElementById('foro-mensajes');

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const input = document.getElementById('mensaje');
      const texto = input.value.trim();

      if (texto) {
        const nuevo = document.createElement('div');
        nuevo.classList.add('mensaje');
        nuevo.innerHTML = '<strong>Tú:</strong> ' + texto;
        mensajes.appendChild(nuevo);
        mensajes.scrollTop = mensajes.scrollHeight;
        input.value = '';
      }
    });
  </script>
</body>
</html>
