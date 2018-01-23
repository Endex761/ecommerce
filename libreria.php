<?php
  /* libreria.php created 22/11/2017-01:14 */
  //Questo file contiene le funzioni per la gestione del database in mysqli
  //Questo file dovrà essere incluso per la gestione delle connessioni al db

  include "design.php";

  /*Costante IP che consente il reindirizzamento per un corretto funzionamento delle sessioni.*/
  //define("IP","localhost:8080");
  define("IP","2.237.61.241:8080");

  /*COSTANTE PER LA SCADENZA DEI COOKIE */
  define("GIORNI_SCADENZA_CARRELLO",7);

  /*COSTANTI PER LA CONNESSIONE*/

  /* Indirizzo IP del server */
  define("DB_SERVERNAME","localhost");

  /* Username account DBMS */
  define("DB_USERNAME","website");

  /* Password account DBMS */
  define("DB_PASSWORD","darioesimone");

  /* Nome del database da usare*/
  define("DB_NAME","ecommerce");

  /* Email administrator */
  define("ADMIN_EMAIL","admin@rsfurniture.it");

  /* Passwrrd administrator */
  define("ADMIN_PASSWORD","administrator");


  /*TEST AREA*/


  /*END TEST AREA*/

  /* Funzione che crea e restituisce una connessione al database selezionato */
  /* Ricordarsi di chiudere la connessione dopo averla utilizzata*/
  function connessione_db()
  {
    //Provo a connettermi al database
    $conn = mysqli_connect(DB_SERVERNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);

    //Testo la connessione
    if(!$conn)
    {
      //Se non mi connetto termino e mando un errore.
      die("connessione_db: Impossibile collegarsi::" . mysqli_connect_error());
    }
    else
    {
      //Altrimenti ritorno la connessione al database
      return $conn;
    }
  }

  /*Funzione che reindirizza alla pagina error_page.php e restituisce il valore di errore*/
  function errore($message)
  {
    header("Location:" . "http://" . IP . "/ecommerce/errore.php" . "?message=$message");
    die();
  }

  /*Funzione che reindirizza alla pagina passata come parametro*/
  function reindirizza($pagina)
  {
    header("Location:" . "http://" . IP . "/ecommerce/" . "$pagina");
  }

  /* Funzione definita da W3Schools per controllare gli input ed evitare exploit */
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /* Funzione che ritorna il numero di articoli all'interno del carrello */
  function count_carrello()
  {
    if(isset($_COOKIE['carrello']))
    {
      //Prendo il cookie e lo assegno al carrello
      $carrello = unserialize($_COOKIE['carrello']);
      $count = 0;
      foreach ($carrello as $value)
      {
        $count += $value;
      }

      return $count;
    }
    else
    {
      //Altrimenti ritorno 0
      return 0;
    }
  }

 ?>
