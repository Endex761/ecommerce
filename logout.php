<?php
  //Questo file effettua il logout rimuovendo id_utente, nome e cognome dalla sessione
  include 'libreria.php';

  //Avvio la sessione
  session_start();

  //Unsetto tutti i possibili campi settati nel login
  unset($_SESSION['id_utente']);
  unset($_SESSION['nome']);
  unset($_SESSION['cognome']);
  unset($_SESSION['ADMIN']);


  //Riporto l'utente alla home
  reindirizza("home.php");
 ?>
