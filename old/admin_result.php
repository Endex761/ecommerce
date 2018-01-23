<?php

//includo la libreria
include "libreria.php";

//La variabile controlla se tutti i campi del form sono stati inizializzati
//Se i campi non sono inizializzati mi ritorna false
$formOk= true;

//Controllo se stiamo utilizzando il metodo POST
//Dopo aver controllato l'inizializzazione dei dati, vedo che non ci sono codici malevoli

if($_SERVER["REQUEST_METHOD"]=="POST")
{
  if(!empty($_POST['email']))
  {
    $email = test_input($_POST['email']);
  }
    else
    {
        $formOk = false;
    }
    if(!empty($_POST['password']))
    {
      $password= test_input($_POST['password']);
    }
    else
    {
      $formOk = false;
    }
    if(!$formOk)
    {
      errore("Form non compilato correttamente");
      die();
    }
    else
    {
      errore("Errore generico");
      die();
    }

    //Adesso posso connettermi al SQLiteDatabase
    $connessione = connessione_db();

    //creo la query per controllare che i dati inseriti corrispondo a quelli dell'admin
    $query = "SELECT id_admin, password FROM admin WHERE email = '$email';";

    //Lancio la query
    $result_set = mysqli_query($connessione, $query);

    //Controllo se ci sono errori nella query
    if($result_set == false)
    {
      die(mysqli_error($connessione));
    }
    //se la query restituisce almeno una riga allora ha trovato una corrispondenza
    if(mysqli_num_rows($result_set)>0)
    {
      //Faccio il fetch dell'array associativo
      //$row è un array associativo contente una tupla con id_utente e password
      $row = mysqli_fetch_assoc($result_set);

      //Cripto la password in md5
      $crypt_password = md5($password);

      //Confronto la password per vedere se corrisponde
      if($row['password'] == $crypt_password)
        {
          reindirizza("prodotti.php");
        }
        else
        {
          errore("Password errata");
        }
      }
      else
      {
        errore("Email non presente");
      }

      /* Chiudo la connessiona al database */
      mysqli_close($connessione);


     ?>

    }

































 ?>
