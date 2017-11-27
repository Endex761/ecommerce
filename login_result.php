<?php
  /* login_result.php created Simon Pietro 22/11/2017 -11:18 */
  /*
    Il file contiene il codice necessario per fare il login al sitoweb
  */

  include 'libreria.php';

  //La variabile controlla se tutti i campi del form sono stati inizializati
  $formOk = true;

  //Controllo se sto utlizzando il metodo POST e acquisisco i dati dal form
  //Mi assicuro che i dati sono stati inizializati
  //Se i dati sono inizializzati controllo che non ci sia codice malevolo con la funzione test_input
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {

    if(!empty($_POST['email']))
      $email = test_input($_POST['email']);
    else
      $formOk = false;

    if(!empty($_POST['password']))
      $password = test_input($_POST['password']);
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
    errore("Errore generico");
    die();
  }

  //A questo punto posso creare la connessione al database con la funzione connessione_db
  $connessione = connessione_db();

  //Creo la query per controllare che i dati inseriti corrispondano a un account e che le credenziali siano giuste
  $query = "SELECT id_utente, password FROM utente WHERE email='$email';";

  //Lancio la query e metto il risultato nel result_set
  $result_set = mysqli_query($connessione, $query);

  //Controllo se non ci sono errori nella query
  if($result_set == false)
  {
    die(mysqli_error($connessione));
  }

  //Se la query restituisce almeno una riga allora ha trovato una corrispondenza
  if(mysqli_num_rows($result_set) > 0 )
  {
    //Faccio il fetch dell'array associativo
    //$row è un array associativo contente una tupla con id_utente e password
    $row = mysqli_fetch_assoc($result_set);

    //Cripto la password in md5
    $crypt_password = md5($password);

    //Confronto la password per vedere se corrisponde
    if($row['password'] == $crypt_password)
    {
      reindirizza("shop.php");
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
