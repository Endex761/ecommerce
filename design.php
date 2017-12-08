<?php

  /* design.php created by Simon Pietro 27/11/2017-00:09 */
  // Questo file contiene funzioni in php per la creazione di parti
  // grafiche per il sito come title, footer, navbar ecc


  function draw_prodotto($id_prodotto, $nome_prodotto, $descrizione, $prezzo, $disponibilita, $foto)
  {
    //Stampa un singolo prodotto
    $disabled = "";
    $script = "location.href = \"carrello.php?add=$id_prodotto\"";
    //$disponibilita = 0;

    echo "<div class='col-sm-4 col-xs-12'>";
    echo " <div class='panel panel-primary'>";
    echo "  <div class='panel-heading text-center'>$nome_prodotto</div>";
    echo "    <div class='panel-body'>";
    echo "      <a href='product_img/$foto'><img src='product_img/$foto' class='img-responsive center-block' height='200px' width='200px'></a>";
    echo "      <hr />";
    echo "      <h4>Descrizone:</h4>";
    echo "      <center>";
    echo "        <p>$descrizione</p>";
    echo "      </center>";
    echo "    </div>";
    echo "    <div class='panel-footer'>";
    echo "      <center>";

    if($disponibilita==0)
    {
      echo "       <h3 style='color:red'>Prodotto non disponibile</h3>";
      $disabled = "disabled"; //Se non dispobile disabilita il pulzante di acquisto
      $script = ""; // E elimina il reindirizzamento
    }
    else
      echo "       <h3 style='color:green'>€ $prezzo </h3>";

    echo "         <button type='button' class='btn btn-primary $disabled' onclick='$script'>";
    echo "         <span class='glyphicon glyphicon-shopping-cart'></span> Aggiungi al carrello";
    echo "        </button>";
    echo "      </center>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
  }

  function draw_prodotto_carrello($id_prodotto, $nome_prodotto, $prezzo, $disponibilita, $foto, $quantita)
  {
    echo "<div class='col-xs-12 text-center' style='background-color:#F9F9F9; padding:5px; margin-bottom:5px;'>";

    echo "  <div class='col-sm-3 col-xs-12'>";
    echo "    <a href='product_img/$foto'><img class='img-thumbnail' src='product_img/$foto' height='150px' width='150px'></a>";
    echo "  </div>";

    echo "  <div class='col-sm-6 col-xs-12'>";
    echo "    <div class='col-xs-12'>";
    echo "     <h3 class='text-primary'> $nome_prodotto </h3>";
    echo "    </div>";
    echo "    <div class='col-xs-12'>";
    echo "     <h6> Disponibilità:$disponibilita</h6>";
    echo "      <a href='carrello.php?remove=$id_prodotto'> Rimuovi </a>";
    echo "    </div>";
    echo "  </div>";

    echo "  <div class='col-sm-3 col-xs-12'>";
    echo "    <div class='col-xs-12'>";
    echo "      <h4>Prezzo</h4>";
    echo "      <h3 style='color:green;'>€$prezzo</h3>";
    echo "    </div>";
    echo "    <div class='col-xs-12'>";
    echo "      <h5>Quantità:$quantita</h5>";

    if($quantita>1)
      echo "      <a href='carrello.php?minus=$id_prodotto'><span class='glyphicon glyphicon-minus'></a>";
    else
      echo "      <a href='#'><span class='glyphicon glyphicon-minus'></a>";

    if($disponibilita>$quantita)
      echo "      <a href='carrello.php?add=$id_prodotto'><span class='glyphicon glyphicon-plus'></a>";
    else
      echo "      <a href='#'><span class='glyphicon glyphicon-plus'></a>";
    echo "    </div>";
    echo "  </div>";

    echo "</div>";
  }

  function draw_footer()
  {
    echo "<footer class='footer'>";
    echo "  <div class='col-xs-12 text-center' style='background:#F9F9F9; padding:10px;'>";
    echo "    <span class='text-muted'>SR Furnitures Copyright @ 2017 Simon Pietro Romeo & Dario Stella</span>";
    echo "  </div>";
    echo "</footer>";
  }


  function include_bootstrap()
  {
    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>";
  }
  ?>
