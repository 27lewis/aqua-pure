<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="inicio.css">
  <title>Aqua Pure - Inicio</title>
</head>
<body>
    <?php include 'header.php'; ?>
  <main>
    <div class="importancia-agua">
      <h2>¿Por qué es importante cuidar el agua?</h2>
      <img src="agua.png" alt="Imagen de cuidado del agua" class="imagen-agua">
      <p>
        El agua es esencial para la vida. Sin ella, los seres humanos, los animales y las plantas no podrían sobrevivir. Cuidarla significa proteger nuestra salud, nuestra seguridad alimentaria y nuestros ecosistemas.
      </p>
      <p>
        Su uso responsable nos permite tener acceso al agua potable, regar cultivos, generar energía y mantener limpios nuestros espacios. Además, es vital para el saneamiento e higiene.
      </p>
      <p>
        Si no la cuidamos, enfrentaremos escasez, enfermedades, pérdida de biodiversidad y conflictos por el acceso. La contaminación y el desperdicio agravan estos problemas, poniendo en riesgo el bienestar de millones de personas.
      </p>
    </div>

    <div class="meta-ods">
      <img src="ods6.png" alt="ODS 6 Logo" class="ods-logo">
      <img src="ods11.png" alt="ODS 11 Logo" class="ods-logo">
      <img src="ods12.png" alt="ODS 12 Logo" class="ods-logo">
      <p>Estas acciones están alineadas con el <strong>Objetivo de Desarrollo Sostenible 6</strong> de la ONU, que busca garantizar agua limpia y saneamiento para todos antes del 2030.</p>
    </div>
  </main>

<?php include 'footer.php'; ?>

</body>
</html>
