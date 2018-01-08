<?php
  //Questo file effettua il logout rimuovendo id_utente, nome e cognome dalla sessione
  include 'libreria.php';
  session_start();
  unset($_SESSION['id_utente']);
  unset($_SESSION['nome']);
  unset($_SESSION['cognome']);

  reindirizza("home.php");
 ?>
