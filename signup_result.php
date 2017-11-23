<?php
  /* singup_result.php created by Simon Pietro */

  /*
    Il file contiene il codice necessario per inserire un nuovo utente all'interno del database
  */

  include 'libreria.php';

  //La variabile controlla se tutti i campi del form sono stati inizializati
  $formOk = true;

  //Controllo se sto utlizzando il metodo POST e acquisisco i dati dal form
  //Mi assicuro che i dati sono stati inizializati
  //Se i dati sono inizializzati controllo che non ci sia codice malevolo con la funzione test_input
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST['nome']))
      $nome = test_input($_POST['nome']);
    else
      $formOk = false;

    if(!empty($_POST['cognome']))
      $cognome = test_input($_POST['cognome']);
    else
      $formOk = false;

    if(!empty($_POST['email']))
      $email = test_input($_POST['email']);
    else
      $formOk = false;

    if(!empty($_POST['password']))
    {
      //Controllo inoltre che le due password siano uguali
      if(!empty($_POST['conferma-password']) && ($_POST['conferma-password'] == $_POST['password']))
      {
        $password = test_input($_POST['password']);
      }
      else
      {
        $formOk = false;
      }
    }
    else
    {
      $formOk = false;
    }


    if(!empty($_POST['risposta-recupero-psw']))
      $risposta_recupero_psw = test_input($_POST['risposta-recupero-psw']);
    else
      $formOk = false;

    if(!empty($_POST['indirizzo']))
      $indirizzo = test_input($_POST['indirizzo']);
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

  //Ora controllo che non ci sia una mail uguale nel database con una query
  $query = "SELECT id_utente FROM utente WHERE email = '$email';";

  //Lancio la query e metto il risultato nel result_set
  $result_set = mysqli_query($connessione, $query);

  //Controllo se non ci sono errori nella query
  if($result_set == false)
  {
    die(mysqli_error($connessione));
  }


  //Se la query restituisce almeno una riga allora l'email è già presente
  if(mysqli_num_rows($result_set) > 0)
  {
    errore("Email già presente");
    die();
  }


  //Cripto la password in md5
  $crypt_password = md5($password);

  //Creo la query per l'inserimento dei dati
  $query_inserimento = "INSERT INTO utente (nome, cognome, email, password, risposta_psw, indirizzo_spedizione) VALUES ('$nome','$cognome','$email','$crypt_password','$risposta_recupero_psw','$indirizzo');";

  //Eseguo la query
  $query_inserimento_ok = mysqli_query($connessione, $query_inserimento);

  if(!$query_inserimento_ok)
    errore("Errore registrazione");
  else
    echo "INSERITA CORRETTAMENTE";


  //Chiudo la connessione al DATABASE_NAME
  mysqli_close($connessione);

 ?>
