<?php

  include "design.php";

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
        <a class="navbar-brand" href="#">WebSiteName</a>
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
          <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Carrello <span class="badge">5</span></a></li>
          <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
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
        <!-- carosello -->
        <div class="row">
          <!-- prodotto  di test -->
          <!--<div class="col-sm-4 col-xs-12">
            <div class="panel panel-primary text-center">
              <div class="panel-heading">Prodotto 1</div>
              <div class="panel-body">
                <img src="product_img/1.jpeg" class="img-responsive center-block" height="200px" width="200px"  alt="Image">
                <hr />
                <h4> Descrizone: </h4>
                <center>
                  <p>Comodino che fa invidia ai migliori produttori di comodini al mondo, unico nel suo genere</p>
                </center>
              </div>
              <div class="panel-footer">
                <center>
                  <h3 style="color:green;">€ 3.90 </h3>
                  <button type="button" class="btn btn-primary">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Aggiungi al carrello
                  </button>
                </center>



              </div>
            </div>
          </div> -->
          <?php
          draw_prodotto("Comodino","Bel comodino fatto in legno di mogano.", "70.50", "2.jpeg");
          draw_prodotto("Tavolo in metallo","Tavolo in metallo per interni, acciao inossidabile!", "23.99", "3.jpeg");
          draw_prodotto("Cassettiera","Cassettiera in legno di mogano.", "45.00", "1.jpeg");
          ?>

        </div><!-- row -->

        <div class="row">
          <?php
          draw_prodotto("Comodino","Bel comodino fatto in legno di mogano.", "3.90", "1.jpeg");
          draw_prodotto("Comodino","Bel comodino fatto in legno di mogano.", "3.90", "1.jpeg");
          draw_prodotto("Comodino","Bel comodino fatto in legno di mogano.", "3.90", "1.jpeg");
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
