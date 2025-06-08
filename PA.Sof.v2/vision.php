<?php
// Iniciamos la sesión para poder acceder a variables de sesión si se necesita en el futuro
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="vision.css">
  <title>Aqua Pure - Nuestra Visión</title>
</head>
<body>

  <?php include 'header.php'; ?>

  <main>
    <div class="vision-container">
      <h1 class="vision-heading">Quiénes Somos</h1>
      
      <section id="vision" class="vision-section">
        <h2>Nuestra Visión</h2>
        <p>
          En Aqua-Pure, soñamos con un futuro donde todas las comunidades colombianas tengan acceso a agua potable y segura. 
          Nuestro objetivo es empoderar a las personas mediante la educación y herramientas digitales para lograr un saneamiento efectivo del agua.
        </p>
        
        <img src="nenetomaagua.png" alt="Comunidad con acceso a agua limpia" class="vision-image">
        
        <p>
          Creemos que el acceso al agua limpia es un derecho fundamental y que la tecnología puede ser una herramienta poderosa para democratizar este recurso vital. 
          A través de nuestra plataforma, no solo proporcionamos información sobre métodos de purificación del agua, sino que también construimos una comunidad comprometida 
          con la conservación y el uso responsable de este recurso esencial.
        </p>
        
        <p>
          Cada gota cuenta, y juntos podemos marcar la diferencia. Nuestra visión trasciende la mera provisión de soluciones técnicas; 
          aspiramos a cultivar una cultura de conciencia hídrica que perdure por generaciones.
        </p>
      </section>
      
      <section class="mission-values">
        <div class="value-card">
          <div class="value-icon">💧</div>
          <h3>Sostenibilidad</h3>
          <p>Promovemos prácticas que garanticen la disponibilidad del recurso hídrico para las generaciones futuras.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">🔍</div>
          <h3>Transparencia</h3>
          <p>Nos comprometemos con información clara y accesible sobre el estado del agua y las soluciones disponibles.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">🤝</div>
          <h3>Colaboración</h3>
          <p>Creemos en el poder de la comunidad y el conocimiento compartido para resolver desafíos complejos.</p>
        </div>
      </section>
      
      <section class="team-section">
        <div class="team-intro">
          <h2>Nuestro Equipo</h2>
          <p>
            Somos un equipo multidisciplinario de profesionales apasionados por el acceso universal al agua potable y 
            la conservación de los recursos hídricos en Colombia.
          </p>
        </div>
        
        <div class="team-grid">
          <div class="team-member">
            <div class="member-photo-container">
              <img src="juanpererz.png" alt="Foto de Juan Pérez" class="member-photo">
            </div>
            <div class="member-info">
              <h3 class="member-name">Juan Pérez</h3>
              <p class="member-title">Director Ejecutivo</p>
              <p class="member-bio">Ingeniero ambiental con más de 15 años de experiencia en proyectos de acceso al agua en zonas rurales.</p>
            </div>
          </div>
          
          <div class="team-member">
            <div class="member-photo-container">
              <img src="mariagonzales.png" alt="Foto de María González" class="member-photo">
            </div>
            <div class="member-info">
              <h3 class="member-name">María González</h3>
              <p class="member-title">Directora de Tecnología</p>
              <p class="member-bio">Especialista en desarrollo de plataformas digitales con enfoque en soluciones para el desarrollo sostenible.</p>
            </div>
          </div>
          
          <div class="team-member">
            <div class="member-photo-container">
              <img src="carlosramirez.png" alt="Foto de Carlos Ramírez" class="member-photo">
            </div>
            <div class="member-info">
              <h3 class="member-name">Carlos Ramírez</h3>
              <p class="member-title">Coordinador de Programas</p>
              <p class="member-bio">Sociólogo dedicado a la implementación de programas comunitarios para la gestión del agua.</p>
            </div>
          </div>
          
          <div class="team-member">
            <div class="member-photo-container">
              <img src="anamartinez.png" alt="Foto de Ana Martínez" class="member-photo">
            </div>
            <div class="member-info">
              <h3 class="member-name">Ana Martínez</h3>
              <p class="member-title">Especialista en Educación</p>
              <p class="member-bio">Pedagoga con experiencia en el desarrollo de materiales educativos sobre conservación del agua.</p>
            </div>
          </div>
        </div>
        
        <div class="meta-ods">
          <img src="ods6.png" alt="ODS 6 Logo" class="ods-logo">
          <img src="ods11.png" alt="ODS 11 Logo" class="ods-logo">
          <img src="ods12.png" alt="ODS 12 Logo" class="ods-logo">
          <p>Estas acciones están alineadas con el <strong>Objetivo de Desarrollo Sostenible 6</strong> de la ONU, que busca garantizar agua limpia y saneamiento para todos antes del 2030.</p>
        </div>
      </section>
    </div>
  </main>

  <?php include 'footer.php'; ?>

  <!-- Añadir Font Awesome para los iconos -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</body>
</html>
