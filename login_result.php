<?php
  /* login_result.php */
  /*
    Il file contiene il codice necessario per fare il login al sitoweb
  */

  include 'libreria.php';

  /*Inizializzo la sessione*/
  session_start();

  //La variabile controlla se tutti i campi del form sono stati inizializati
  $formOk = true;

  $mail = true;

  //Controllo se sto utilizzando il metodo POST e acquisisco i dati dal form
  //Mi assicuro che i dati sono stati inizializzati
  //Se i dati sono inizializzati controllo che non ci sia codice malevolo con la funzione test_input
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_GET['impostazioni']))
      $mail = test_input($_GET['impostazioni']);
    else
      $mail = false;

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

  /* admin login */
  if($email == ADMIN_EMAIL and $password == ADMIN_PASSWORD)
  {
    $_SESSION['ADMIN'] = "yes";
    reindirizza("prodotti.php");
    die();
  }

  //A questo punto posso creare la connessione al database con la funzione connessione_db
  $connessione = connessione_db();

  //Creo la query per controllare che i dati inseriti corrispondano a un account e che le credenziali siano giuste
  $query = "SELECT id_utente, nome, cognome, password FROM utente WHERE email='$email';";

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
      //Imposto l'id_utente il nome e il cognome all'interno della sessione
      $_SESSION['id_utente']  = $row['id_utente'];
      $_SESSION['nome']       = $row['nome'];
      $_SESSION['cognome']    = $row['cognome'];

      if($mail)
        reindirizza("impostazioni.php#password_vecchia");
      else
        reindirizza("shop.php");
    }
    else
    {
      //Se la password non corrisponde
      reindirizza("login.php?status=wrong_password");
    }
  }
  else
  {
    //Se non esiste nessun account con la mail inserita
    reindirizza("login.php?status=wrong_email");
  }

  /* Chiudo la connessiona al database */
  mysqli_close($connessione);


 ?>
