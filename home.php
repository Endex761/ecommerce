<?php

  /*
    File: home.php
    Il file mostra una breve descrizione del sito, alcuni dei prodotti all'interno del database con foto e descrizone.
    La pagina da la possibilità all'utente di loggasi o registrarsi.
  */

  //Includo la libreria di base
  include "libreria.php";

  //Apro la connessione per poi utilizzarla nelle query
  $connessione = connessione_db();

  //Seleziona 9 prodotti casuali da mostrare nello shop
  $search_query = "SELECT * FROM prodotto WHERE disponibilita > 0 ORDER BY rand() LIMIT 9;";

 ?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Home </title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_bootstrap(); ?>

  </head>
  <body background="img/bg.jpg">

    <nav class='navbar navbar-inverse'>
      <div>
        <div class='navbar-header'>
          <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
          <a class='navbar-brand' href='#'>RS Furnitures</a>
        </div>
        <div class='collapse navbar-collapse' id='myNavbar'>
          <ul class='nav navbar-nav'>
            <li><a href="#chisiamo"> Chi siamo </a></li>
            <li><a href="#prodotti"> Prodotti </a></li>
          </ul>
          <ul class='nav navbar-nav navbar-right'>
            <li><a href='signup.php'><span class='glyphicon glyphicon-star'></span> Registrati </a></li>
            <li><a href='login.php'><span class='glyphicon glyphicon-log-in'></span> Login </a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="col-sm-10 col-sm-offset-1 col-xs-12 container" >
    <div class="jumbotron" id="chisiamo">
      <h1 style="color:orange;">RS Furnitures</h1>
      <p>Siamo una piccola azienda siciliana che si occupa della produzione e della vendita di arredamento per case e uffici.</p>
      <p>Il nostro obiettivo è quello di fornire ai nostri clienti prodotti unici che rispondano esattamente alle loro esigenze.</p>
      <p><a href="signup.php">Iscriviti</a> subito, inizia a consultare il nostro catalogo e  ricorda che la spedizione è gratuita su tutto il territorio italiano.</p>
    </div>
  </div>

    <div class="container-fluid">
      <div class="col-sm-6 col-sm-offset-3 col-xs-12 text-center" id="prodotti" style="background-color:white; border-radius: 5px; margin-bottom:10px;">
        <h1> Ecco alcuni dei nostri prodotti </h1>
      </div>


      <!-- prodotti -->
      <div class="col-xs-12" >

        <div class="row">

          <?php


            //Invio la query al db
            $result_set = mysqli_query($connessione, $search_query);

            //Controllo se non ci sono errori nella query
            if($result_set == false)
            {
              die(mysqli_error($connessione));
            }

            //Controllo se ci sono righe nel risultato
            if(mysqli_num_rows($result_set) > 0)
            {
              //Counter mi serve per stampare i prodotti a riga ogni 3 prodotti stampati creo una riga
              $counter = 0;

              echo "<div class='row'>";
              //Faccio il fetch dell'array associativo
              while($row = mysqli_fetch_assoc($result_set))
              {
                //Prendo le caratteristiche del prodotto

                $nome_prodotto  = $row['nome_prodotto'];
                $descrizione    = $row['descrizione'];
                $foto           = $row['foto'];

                //stampo il prodotto

                echo "<div class='col-sm-4 col-xs-12'>";
                echo " <div class='panel panel-primary'>";
                echo "  <div class='panel-heading text-center'>$nome_prodotto</div>";
                echo "    <div class='panel-body'>";
                echo "      <a href='product_img/$foto'><img src='product_img/$foto' class='img-responsive center-block' height='200px' width='200px'></a>";
                echo "      <hr/>";
                echo "      <h4>Descrizione:</h4>";
                echo "      <center>";
                echo "        <p>$descrizione</p>";
                echo "      </center>";
                echo "    </div>";
                echo "   </div>";
                echo "</div>";

                //Aumento il counter
                $counter++;

                //Ogni tre prodotti chiudo una riga.
                if($counter%3 == 0)
                  echo "</div><div class='row'>";

                //Per l'ultimo prodotto chiudo il  div
                if($counter == 9)
                  echo "</div>";
              }
            }
            else
            {
              //Se non ci sono righe nel result_set stampo "nessun risultato.".
              echo "<h3 class='text-center'> Nessun risultato. </h3>";
            }
          ?>
        </div> <!-- row -->
      </div>
    </div>
    <?php
      draw_footer();
    ?>

  </body>
</html>

<?php
  //Chiudo la connessione al db
  mysqli_close($connessione);
 ?>
