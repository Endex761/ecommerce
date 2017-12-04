<?php
  /* login_result.php created Simon Pietro 03/12/2017 - 16:05 */
  /*
    Il file contiene il codice necessario per eliminare un prodotto al database e la relativa immagine
  */

  include 'libreria.php';

  //Se mi viene passato un id
  if(isset($_GET['id']))
  {
    //Prendo l'id del Prodotto
    $id_prodotto = $_GET['id'];

    //Mi connetto al database
    $connessione = connessione_db();

    //Creo la query per eliminare il il record
    $query = "DELETE FROM Prodotto WHERE id_prodotto = '$id_prodotto';";

    //Lancio la query e metto il risultato nel result_set
    $result_set = mysqli_query($connessione, $query);

    //Controllo se non ci sono errori nella query
    if($result_set == false)
    {
      die(mysqli_error($connessione));
    }

    mysqli_close($connessione);

    //Elimino la foto del Prodotto
    $base_dir = "product_img/";

    //La funzione unlink permette di eliminare un file locale
    if(!unlink($base_dir . $_GET['id'] . ".jpg"))
    {
      errore("Foro non eliminata.");
    }

    //Infine reindirizzo l'admin alla pagina dei prodotti
    reindirizza("prodotti.php");
  }
  else
  {
    errore("Errore generale.");
  }

  ?>
