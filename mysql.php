<?php
  /* my_sql.php created by Simon Pietro 22/11/2015-01:14 */
  //Questo file contiene le funzioni per la gestione del database in mysqli
  //Questo file dovrà essere incluso per la gestione delle connessioni al db

  /*COSTANTI PER LA CONNESSIONE*/

  /* Indirizzo IP del server */
  define("servername","localhost");

  /* Username account DBMS */
  define("username","website");

  /* Password account DBMS */
  define("password","darioesimone");

  /* Nome del database da usare*/
  define("database_name","ecommerce");


  /*TEST AREA*/
  connessione_db();
  /*END TEST AREA*/

  /* Funzione che crea e restituisce una connessione al database selezionato */
  function connessione_db()
  {
    //Provo a connettermi al database
    $conn = mysqli_connect(servername,username,password,database_name);

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

 ?>
