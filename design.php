<?php

  /* design.php created by Simon Pietro 27/11/2017-00:09 */
  // Questo file contiene funzioni in php per la creazione di parti
  // grafiche per il sito come title, footer, navbar ecc


  function draw_prodotto($id_prodotto, $nome_prodotto, $descrizione, $prezzo, $disponibilita, $foto)
  {
    //$disponibilita =0;
    //Stampa un singolo prodotto
    echo "<div class='col-sm-4 col-xs-12'>";
    echo " <div class='panel panel-primary'>";
    echo "  <div class='panel-heading text-center'>$nome_prodotto</div>";
    echo "  <div class='panel-body'>";
    echo "      <a href='product_img/$foto'><img src='product_img/$foto' class='img-responsive center-block' height='200px' width='200px'></a>";
    echo "      <hr />";
    echo "      <h4>Descrizone:</h4>";
    echo "      <center>";
    echo "        <p>$descrizione</p>";
    echo "      </center>";
    echo "    </div>";
    echo "    <div class='panel-footer'>";
    echo "      <center>";
    if($disponibilita>0)
      echo "       <h3 style='color:green'>€ $prezzo </h3>";
    else
      echo "       <h3 style='color:red'>Prodotto non disponibile</h3>";
    //echo "      <button class='btn-primary btn'>Compralo!</button>";
    echo "        <button type='button' class='btn btn-primary' onclick='location.href = \"carrello.php?add_product=$id_prodotto\"'>";
    echo "         <span class='glyphicon glyphicon-shopping-cart'></span> Aggiungi al carrello";
    echo "        </button>";
    echo "      </center>";
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
