<?php
  /* singup_result.php created by Simon Pietro */

  /*
    Il file contiene il codice necessario per inserire un nuovo utente all'interno del database
  */

  include 'libreria.php';

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?=status=not_logged");
    /*   */

  //La variabile controlla se tutti i campi del form sono stati inizializati
  $formOk = true;

  //Controllo se sto utlizzando il metodo POST e acquisisco i dati dal form
  //Mi assicuro che i dati sono stati inizializati
  //Se i dati sono inizializzati controllo che non ci sia codice malevolo con la funzione test_input
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST['denominazione']))
      $denominazione = test_input($_POST['denominazione']);
    else
      $formOk = false;

    if(!empty($_POST['intestatario']))
      $intestatario = test_input($_POST['intestatario']);
    else
      $formOk = false;

    if(!empty($_POST['numero_carta']))
      $numero_carta = test_input($_POST['numero_carta']);
    else
      $formOk = false;

    if(!empty($_POST['codice_sicurezza']))
      $codice_sicurezza = test_input($_POST['codice_sicurezza']);
    else
      $formOk = false;

    if(!empty($_POST['mese_scadenza']))
      $mese_scadenza = test_input($_POST['mese_scadenza']);
    else
      $formOk = false;

    if(!empty($_POST['anno_scadenza']))
      $anno_scadenza = test_input($_POST['anno_scadenza']);
    else
      $formOk = false;

    if(!$formOk)
    {
      errore("Form non compilato correttamente");
      die();
    }

  }
  else
  {
    errore("Errore generale");
    die();
  }

  //A questo punto posso creare la connessione al database con la funzione connessione_db
  $connessione = connessione_db();

  //Creo la query di inserimento della Carta
  $id_utente = $_SESSION['id_utente'];
  $query = "INSERT INTO Carta (intestatario,numero_carta,mese_scadenza,anno_scadenza,codice_sicurezza,denominazione,id_utente) VALUES ('$intestatario','$numero_carta','$mese_scadenza','$anno_scadenza','$codice_sicurezza','$denominazione',$id_utente);";

  //Invio la query al db
  $result_set = mysqli_query($connessione, $query);

  //Controllo se non ci sono errori nella query
  if($result_set == false)
  {
    die(mysqli_error($connessione));
  }
  else
  {
    reindirizza("impostazioni.php");
  }
