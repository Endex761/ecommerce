<?php
  /* add_product.php  */
  /*
    Il file contiene il codice necessario per aggiungere un prodotto al database
  */

  //Includo la libreria di base.
  include 'libreria.php';

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['ADMIN']))
    reindirizza("login.php?status=not_logged");

    /*   */

  //La variabile controlla se tutti i campi del form sono stati inizializati
  $formOk = true;

  //Controllo se sto utilizzando il metodo POST e acquisisco i dati dal form
  //Mi assicuro che i dati sono stati inizializzati
  //Se i dati sono inizializzati controllo che non ci sia codice malevolo con la funzione test_input
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {

    if(!empty($_POST['nome-prodotto']))
      $nome_prodotto = test_input($_POST['nome-prodotto']);
    else
      $formOk = false;

    if(!empty($_POST['descrizione']))
      $descrizione = test_input($_POST['descrizione']);
    else
      $formOk = false;

    if(!empty($_POST['prezzo']))
      $prezzo = test_input($_POST['prezzo']);
    else
      $formOk = false;

    if(!empty($_POST['disponibilita']))
      $disponibilita = test_input($_POST['disponibilita']);
    else
      $formOk = false;

    //if(!isset($_POST['foto']))
      //$formOk = false;

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

  //Prendo il nome grezzo del file es: foto.jpg
  $nome_file = basename($_FILES["foto"]["name"]);

  //Cartella di destinazione dell'immagine.
  $target_dir = "product_img/";

  //Nome del file da posizionare nella cartella.
  $target_file = $target_dir . basename($_FILES["foto"]["name"]);

  //Flag di controllo
  $uploadOk = true;

  //Prendiamo l'estensione dell'immagine
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  // Controlla se il file caricato è un immagine
  if(isset($_POST["submit"]))
  {
    //Return FALSE on failure
    $check = getimagesize($_FILES["foto"]["tmp_name"]);

    if($check != false)
    {
        $uploadOk = true;
    }
    else
    {
        $uploadOk = false;
        errore("Il file non è una foto.");
    }
  }

  // Verifica il formato del file
  if($imageFileType != "jpg" && $imageFileType != "jpeg")
   {
      errore("Formato file non supportato.");
      $uploadOk = false;
  }

  //Verifichiamo che il flag è ok
  if ($uploadOk == false)
  {
      errore("File non caricato.");
  }
  else //Se è tutto ok prova a caricare il file.
  {
      //La funzione sposta il file nella cartella target, se fallisce ritorna false
      if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file))
      {
        //Prendo il nome del file appena caricato.
        $nome_file = basename($_FILES["foto"]["name"]);
      }
      else
      {
          //Stampiamo un messaggio d'errore
          errore("C'è stato un problema nel caricamento del file." . print_r($_FILES,true));
          die();
      }
  }

  //Mi connetto al db per inserire i dati nel database
  $connessione = connessione_db();

  //Creo la query per inserire i dati e il nome della foto nel database
  $query = "INSERT INTO Prodotto (nome_prodotto,descrizione,prezzo,disponibilita,foto) VALUES ('$nome_prodotto','$descrizione',$prezzo,$disponibilita,'$nome_file');";

  //Lancio la query e metto il risultato nel result_set
  $result_set = mysqli_query($connessione, $query);

  //Controllo se non ci sono errori nella query
  if($result_set == false)
  {
    die(mysqli_error($connessione));
  }

  //Prendo l'id del prodotto appena inserito
  $query = "SELECT id_prodotto FROM Prodotto WHERE foto = '$nome_file' AND nome_prodotto = '$nome_prodotto' AND prezzo = $prezzo;";

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
    //$row è un array associativo contente una tupla con id_prodotto
    $row = mysqli_fetch_assoc($result_set);

    //Prendo l'id_prodotto
    $id = $row['id_prodotto'];

    //Aggiungo all'id prodotto l'estenzione .jpg così facendo avro' tutte le foto di un prodotto con nome id.jpg es 1.jpg
    $id = $id . ".jpg";

    //Rinomino il file con il nome dell'id prodotto
    rename ($target_file, $target_dir . $id);

    //Update del nome del file sul database
    $query = "UPDATE Prodotto SET foto='$id' WHERE foto = '$nome_file' AND nome_prodotto = '$nome_prodotto' AND prezzo = $prezzo;";

    //Lancio la query e metto il risultato nel result_set
    $result_set = mysqli_query($connessione, $query);

    //Controllo se non ci sono errori nella query
    if($result_set == false)
    {
      die(mysqli_error($connessione));
    }
  }
  else
  {
    errore("Errore generale.");
  }

  //Chiudo la connessione al database
  mysqli_close($connessione);

  //Reindirizzo l'admin alla pagina dei prodotti.
  reindirizza("prodotti.php");

  ?>
