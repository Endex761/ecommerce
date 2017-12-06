<?php

  include "libreria.php";

  //Apro la connessione per poi utilizzarla nelle query
  $connessione = connessione_db();

  /*QUERY DI RICERCA PRODOTTI */

  //Seleziona 9 prodotti casuali da mostrare nello shop
  $search_query = "SELECT * FROM prodotto WHERE disponibilita > 0 ORDER BY rand() LIMIT 9;";


  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
    if(isset($_GET['ricerca']))
    {
        $ricerca = test_input($_GET['ricerca']);
        $search_query = "SELECT * FROM prodotto WHERE disponibilita > 0 AND (nome_prodotto LIKE '%{$ricerca}%' OR descrizione LIKE '%{$ricerca}%');";
    }
  }




 ?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
    <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_bootstrap(); ?>
  </head>
  <body>

    <nav class="navbar navbar-inverse">
    <div class="">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">SR Furnitures</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <form class="col-xs-6 navbar-form navbar-left" action="shop.php" method="get">
            <div class="input-group">
              <input name="ricerca" type="text" class="form-control" placeholder="Mobili, Comodini, Sedie ..">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">Cerca</button>
              </div>
            </div>
          </form>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Simon Pietro </a></li>
          <li><a href="carrello.php"><span class="glyphicon glyphicon-shopping-cart"></span> Carrello <span class="badge"><?php echo count_carrello() ?></span></a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>




    <div class="container-fluid">
      <div class="col-xs-12 text-center">
        <h1> Shop </h1>
      </div>

      <!-- prodotti -->
      <div class="col-xs-12">

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
              $counter = 0;
              echo "<div class='row'>";
              //Faccio il fetch dell'array associativo
              while($row = mysqli_fetch_assoc($result_set))
              {
                $id_prodotto =    $row['id_prodotto'];
                $nome_prodotto =  $row['nome_prodotto'];
                $descrizione =    $row['descrizione'];
                $prezzo =         $row['prezzo'];
                $disponibilita =  $row['disponibilita'];
                $foto =           $row['foto'];
                //stampo il prodotto
                draw_prodotto($id_prodotto, $nome_prodotto, $descrizione, $prezzo, $disponibilita, $foto);
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

  mysqli_close($connessione);
 ?>
