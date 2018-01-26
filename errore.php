<?php
  //Includo la libreria
  include "libreria.php";

  //Prendo il messaggio passatomi dal GET
  $message = $_GET['message'];
 ?>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Errore </title>
    <script src="js/functions.js"></script>
    <?php include_bootstrap(); ?>

  </head>

  <body>
    <div class="container-fluid col-xs-12 text-center">
      <h1>Si è verificato un errore</h1>
      <br>
      <h3 style="color:#AA0000;"><?php echo $message ?></h3>
      <a href="#" onclick="tornaIndietro()">Torna indietro</a>
    </div>
  </body>


</html>
