<?php

  $id_utente = 1;
  include 'libreria.php';

  /*Gestione dei cookie*/
  //Utilizzo un array dove la key è il codice prodotto e il value è la quantità del prodotto nel Carrello
  $carrello;

  //Controllo se il cookie è impostato
  if(isset($_COOKIE['carrello']))
  {
    //Prendo il cookie e lo assegno al carrello
    $carrello = unserialize($_COOKIE['carrello']);
  }
  else
  {
    //Altrimenti creo un nuovo array
    $carrello = array();
  }

  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
    if(isset($_GET['add']))
    {
      //Prendo il valore di add e lo metto nella variabile dopo averlo testato
      $add = test_input($_GET['add']);

      //Se il prodotto è già presente nel carrello
      if(isset($carrello[$add]))
      {
        //Aumento la quantità del prodotto nel carrello
        $carrello[$add] ++;
      }
      else
      {
        //Altrimenti aggiungo il prodotto ponendo il valore a 1.
        $carrello[$add] = 1;
      }

      //Setto il cookie serializzando l'array
      setcookie('carrello',serialize($carrello),time() + (86400 * GIORNI_SCADENZA_CARRELLO));
    }
  }
  else
  {
    errore("Errore Generale.");
  }
  //print_r($carrello);
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
           <li><a href="carrello.php"><span class="glyphicon glyphicon-shopping-cart"></span> Carrello <span class="badge"><?php echo count_carrello() ?></span></a></li>
           <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
         </ul>
       </div>
     </div>
   </nav>




     <div class="container-fluid">

       <div class="col-xs-12 text-center">
         <h1> Carrello </h1>
       </div>

       <div class="col-xs-12">
         <div class="col-xs-9" style="background-color:red;">
           <div class="col-xs-12"> <!-- Singolo prodotto nel carrello -->
             <div class="panel panel-default">
               <div class="panel body">
                 <div class="col-xs-3">
                   <img class="img" src="product_img/10.jpg" height="50px" width="50px">
                 </div>
               </div>
             </div>
           </div>
         </div>
         <div class="col-xs-3" style="background-color:green;">
       </div>
    </div>


  </body>
</html>
