<?php

  /* design.php created by Simon Pietro 27/11/2017-00:09 */
  // Questo file contiene funzioni in php per la creazione di parti
  // grafiche per il sito come title, footer, navbar ecc



  function draw_prodotto($nome, $descrizione, $prezzo, $immagine)
  {
    //Stampa un singolo prodotto
    echo "<div class='col-sm-4 col-xs-12'>";
    echo " <div class='panel panel-primary'>";
    echo "  <div class='panel-heading text-center'>$nome</div>";
    echo "  <div class='panel-body'>";
    echo "      <img src='product_img/$immagine' class='img-responsive center-block' height='200px' width='200px'>";
    echo "      <hr />";
    echo "      <h4> Descrizone:</h4>";
    echo "      <center>";
    echo "        <p>$descrizione</p>";
    echo "      </center>";
    echo "    </div>";
    echo "    <div class='panel-footer'>";
    echo "      <center>";
    echo "        <h3 style='color:green'>€ $prezzo </h3>";
    //echo "      <button class='btn-primary btn'>Compralo!</button>";
    echo "        <button type='button' class='btn btn-primary'>";
    echo "         <span class='glyphicon glyphicon-shopping-cart'></span> Aggiungi al carrello";
    echo "        </button>";
    echo "      </center>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
  }
  ?>
