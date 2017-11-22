<?php
  /* libreria.php created by Simon Pietro 22/11/2015-01:14 */
  //Questo file contiene le funzioni per la gestione del database in mysqli
  //Questo file dovrà essere incluso per la gestione delle connessioni al db


  /*Costante IP che consente il reindirizzamento per un corretto funzionamento delle sessioni.*/
  //define("IP","localhost:8080");
  define("IP","2.237.61.241:8080");



  /*COSTANTI PER LA CONNESSIONE*/

  /* Indirizzo IP del server */
  define("DB_SERVERNAME","localhost");

  /* Username account DBMS */
  define("DB_USERNAME","website");

  /* Password account DBMS */
  define("DB_PASSWORD","darioesimone");

  /* Nome del database da usare*/
  define("DATABASE_NAME","ecommerce");


  /*TEST AREA*/
  $conn = connessione_db();
  mysqli_close($conn);

  /*END TEST AREA*/

  /* Funzione che crea e restituisce una connessione al database selezionato */
  /* Ricordarsi di chiudere la connessione dopo averla utilizzata*/
  function connessione_db()
  {
    //Provo a connettermi al database
    $conn = mysqli_connect(DB_SERVERNAME,DB_USERNAME,DB_PASSWORD,DATABASE_NAME);

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
    header("Location:" . "http://" . IP . "/ecommerce/error_page.php" . "?message=$message");
    die();
  }

  /* Funzione definita da W3Schools per controllare gli input ed evitare exploit */
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



 ?>
