<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="conctato.css">
  <title>Aqua Pure - Contacto</title>
  
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
    <div class="contact-container">
      <h1 class="contact-heading">Contáctanos</h1>
      
      <div class="contact-content">
        <div class="contact-info">
          <h3>Información de Contacto</h3>
          
          <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
              <p><strong>Dirección:</strong><br>
              Avenida del Agua 123<br>
              001289 Barranquilla, Colombia</p>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-phone-alt"></i>
            <div>
              <p><strong>Teléfono:</strong><br>
              +57 302 252 7991</p>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <div>
              <p><strong>Email:</strong><br>
              info@aquapure.es</p>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-clock"></i>
            <div>
              <p><strong>Horario de Atención:</strong><br>
              Lunes a Viernes: 9:00 - 18:00<br>
              Sábados: 10:00 - 14:00</p>
            </div>
          </div>
        </div>
        
        <div class="contact-form-container">
          <h3>Escribir comentario</h3>
          
          <form class="comment-form">
            <div class="form-row">
              <input type="text" class="form-control" placeholder="Nombre">
              <input type="email" class="form-control" placeholder="Correo electrónico (no se publicará)">
            </div>
            
            <div class="form-row">
              <textarea class="form-control" placeholder="Comentario o pregunta" rows="5"></textarea>
              <div class="photo-area">
                <div>
                  <img src="camara.png" alt="Icono de cámara">
                  <p>Haz clic para adjuntar una foto relacionada con tu comentario</p>
                </div>
              </div>
            </div>
            
            <div class="rating-stars">
              <span>Tu valoración:</span>
              <div class="stars">
                <span class="star active">★</span>
                <span class="star active">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
              </div>
              <span class="rating-value">Más o menos</span>
            </div>
            
            <div class="privacy-check">
              <input type="checkbox" id="privacy">
              <label for="privacy">He leído y acepto la <a href="#" class="privacy-link">política de privacidad</a></label>
            </div>
            
            <button type="submit" class="submit-btn">Enviar comentario</button>
          </form>
        </div>
      </div>
      
      <div class="map-container">
        <!-- Aquí iría un mapa de Google Maps o similar -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d12612.5!2d-74.829060!3d11.000370!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sco!4v1723400000000!5m2!1ses!2sco" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
    
    <div class="meta-ods">
      <img src="ods6.png" alt="ODS 6 Logo" class="ods-logo">
      <img src="ods11.png" alt="ODS 11 Logo" class="ods-logo">
      <img src="ods12.png" alt="ODS 12 Logo" class="ods-logo">
      <p>Estas acciones están alineadas con el <strong>Objetivo de Desarrollo Sostenible 6</strong> de la ONU, que busca garantizar agua limpia y saneamiento para todos antes del 2030.</p>
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

  <!-- Añadir Font Awesome para los iconos -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
  
  <script>
    // Script para la funcionalidad de las estrellas de valoración
    document.addEventListener('DOMContentLoaded', function() {
      const stars = document.querySelectorAll('.star');
      const ratingValue = document.querySelector('.rating-value');
      
      const ratingTexts = ['Muy malo', 'Malo', 'Más o menos', 'Bueno', 'Excelente'];
      
      stars.forEach((star, index) => {
        star.addEventListener('click', () => {
          // Resetear todas las estrellas
          stars.forEach(s => s.classList.remove('active'));
          
          // Activar las estrellas hasta la que se hizo clic
          for(let i = 0; i <= index; i++) {
            stars[i].classList.add('active');
          }
          
          // Actualizar el texto de valoración
          ratingValue.textContent = ratingTexts[index];
        });
      });
    });
  </script>

</body>
</html>