<?php

  include "design.php";
  include "libreria.php";

  //Apro la connessione per poi utilizzarla nelle query
  $connessione = connessione_db();

 ?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
    <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </head>
  <body>


      <!-- Navbar -->
    <!--  <nav class="navbar navbar-inverse">
        <div class="container-fluid">

          <div class="navbar-header">
            <a class="navbar-brand" href="shop.php">SF Furnitures</a>
          </div>

          <form class="col-xs-6 navbar-form navbar-left">
            <div class="input-group">
              <input  type="text" class="form-control" placeholder="Mobili, Comodini, Sedie ..">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">Cerca</button>
              </div>
            </div>
          </form>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Simon Pietro </a></li>
            <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Carrello</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </div>
      </nav> -->

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
          <form class="col-xs-6 navbar-form navbar-left">
            <div class="input-group">
              <input  type="text" class="form-control" placeholder="Mobili, Comodini, Sedie ..">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">Cerca</button>
              </div>
            </div>
          </form>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Simon Pietro </a></li>
          <li><a href="carrello.php"><span class="glyphicon glyphicon-shopping-cart"></span> Carrello <span class="badge">5</span></a></li>
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
            //Selezioni 9 prodotti casuali da mostrare nello shop
            $query = "SELECT * FROM prodotto WHERE disponibilita > 0 ORDER BY rand() LIMIT 9;";

            //Invio la query al db
            $result_set = mysqli_query($connessione, $query);

            //Controllo se non ci sono errori nella query
            if($result_set == false)
            {
              die(mysqli_error($connessione));
            }

            //Controllo se ci sono righe nel risultato
            if(mysqli_num_rows($result_set) > 0)
            {
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
              }

            }



          ?>
        </div> <!-- row -->


      </div>
    </div>

    <footer style="background-colo: grey;">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" id="footer">
        <p>SR Furnitures Copyright @ 2017 Simon Pietro Romeo & Dario Stella</p>
      </div>
    </footer>
  </body>
</html>

<?php

  mysqli_close($connessione);
 ?>
