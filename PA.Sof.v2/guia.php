
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="guia.css">
  <title>Aqua Pure - Cuidado del Agua</title>
  </head>
<body>
<?php include 'header.php'; ?>
  <main>
    <div class="contenido">
      <section class="intro">
        <h1>Recomendaciones para el Cuidado y Conservación del Agua</h1>
        <p>El agua es un recurso esencial y limitado. Con pequeñas acciones cotidianas podemos contribuir a su conservación y garantizar su disponibilidad para las futuras generaciones.</p>
      </section>
      
      <section class="seccion">
        <h2>Uso Responsable del Agua en Casa</h2>
        <div class="consejos">
          <div class="consejo">
            <h3>Ducha Breve</h3>
            <p>Prefiere ducharte en vez de bañarte en tina. Una ducha corta (5 minutos) usa unos 50 litros de agua.</p>
            <span class="ahorro">Ahorro: 150 litros por baño</span>
          </div>
          
          <div class="consejo">
            <h3>Cepillado Eficiente</h3>
            <p>Cierra el grifo mientras te cepillas los dientes. Usa un vaso para enjuagarte.</p>
            <span class="ahorro">Ahorro: 12 litros por cepillado</span>
          </div>
          
          <div class="consejo">
            <h3>Afeitado Consciente</h3>
            <p>Evita dejar la llave abierta al afeitarte. Abre el grifo solo para enjuagar la navaja o tu cara.</p>
            <span class="ahorro">Ahorro: 20 litros por afeitada</span>
          </div>
          
          <div class="consejo">
            <h3>Lavado Eficiente</h3>
            <p>Utiliza la lavadora y el lavavajillas con carga completa. Espera a que estén llenos antes de ponerlos en funcionamiento.</p>
            <span class="ahorro">Ahorro: 30-50 litros por ciclo</span>
          </div>
          
          <div class="consejo">
            <h3>Lavavajillas vs. Manual</h3>
            <p>Usa el lavavajillas en lugar de lavar platos a mano. El lavavajillas consume menos agua que el lavado manual.</p>
            <span class="ahorro">Ahorro: 36 litros diarios</span>
          </div>
          
          <div class="consejo">
            <h3>Inodoro Eficiente</h3>
            <p>Instala sistemas que reduzcan el consumo de agua en el inodoro, como una botella con arena en la cisterna.</p>
            <span class="ahorro">Ahorro: 1,5 litros por descarga</span>
          </div>
        </div>
      </section>
      
      <section class="seccion">
        <h2>Evita la Contaminación del Agua</h2>
        <div class="consejos">
          <div class="consejo">
            <h3>Productos Químicos</h3>
            <p>Modera el uso de productos como la lejía. El exceso puede alterar el equilibrio bacteriano de las plantas depuradoras.</p>
          </div>
          
          <div class="consejo">
            <h3>Desechos Adecuados</h3>
            <p>No viertas contaminantes por el inodoro o el fregadero. Productos como aceites y toallitas son muy dañinos.</p>
          </div>
          
          <div class="consejo">
            <h3>Compra Inteligente</h3>
            <p>Ten en cuenta el consumo al comprar electrodomésticos. Elige opciones eficientes en agua y energía.</p>
          </div>
          
          <div class="consejo">
            <h3>Reúso Creativo</h3>
            <p>Reutiliza el agua de la pecera para regar plantas. También puedes recoger el agua fría de la ducha mientras esperas la caliente.</p>
          </div>
        </div>
      </section>
      
      <section class="seccion">
        <h2>Jardinería Sostenible</h2>
        <div class="consejos">
          <div class="consejo">
            <h3>Aspersores Optimizados</h3>
            <p>Revisa y ajusta tus aspersores para evitar regar zonas que no lo necesiten.</p>
          </div>
          
          <div class="consejo">
            <h3>Horario de Riego</h3>
            <p>Riega plantas temprano por la mañana para minimizar la evaporación por el sol y el viento.</p>
          </div>
          
          <div class="consejo">
            <h3>Plantas Adecuadas</h3>
            <p>Opta por plantas que requieran poca agua. Son ideales para conservar el recurso en jardines o terrazas.</p>
          </div>
        </div>
      </section>
      
      <div class="conclusion">
        <h3>Reflexión Final</h3>
        <p>El agua es un recurso esencial y limitado. Cuidarla es fundamental para la vida y el equilibrio ambiental.</p>
        <div class="meta-ods">
          <img src="ods6.png" alt="ODS 6 Logo" class="ods-logo">
          <img src="ods11.png" alt="ODS 11 Logo" class="ods-logo">
          <img src="ods12.png" alt="ODS 12 Logo" class="ods-logo">
          <p>Estas acciones están alineadas con el <strong>Objetivo de Desarrollo Sostenible 6</strong> de la ONU, que busca garantizar agua limpia y saneamiento para todos antes del 2030.</p>
        </div>
      </div>
    </div>
  </main>
  
<?php include 'footer.php'; ?>

</body>
</html>