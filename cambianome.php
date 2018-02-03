<?php

  /*
    Il file permette di cambiare il nome o il cognomo della persona.
  */

  include "libreria.php";

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?=not-logged");
    /*   */

  //Prendo l'id dell'utente loggato
  $id_utente = $_SESSION['id_utente'];


  //La variabile controlla se tutti i campi del form sono stati inizializati
  $formOk = true;

  //Apro la connessione per poi utilizzarla nelle query
  $connessione = connessione_db();

  //Se richiesto modifico l'indirizzo di spedizone predefinito
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    //La variabile controlla se tutti i campi del form sono stati inizializati
    $formOk = true;

    if(!empty($_POST['nuovo_nome']))
      $nuovo_nome = test_input($_POST['nuovo_nome']);
    else
      $formOk = false;

    if(!empty($_POST['nuovo_cognome']))
      $nuovo_cognome = test_input($_POST['nuovo_cognome']);
    else
      $formOk = false;

    if(!$formOk)
    {
      errore("Form non compilato correttamente");
      die();
    }

    //Prendo la password attuale
    $query = "UPDATE utente SET nome='$nuovo_nome', cognome='$nuovo_cognome' WHERE id_utente = $id_utente;";

    //Invio la query al db
    $result_set = mysqli_query($connessione, $query);

     //Controllo se non ci sono errori nella query
     if($result_set == false)
     {
       die(mysqli_error($connessione));
     }
   }

     reindirizza("impostazioni.php");

     mysqli_close($connessione);
