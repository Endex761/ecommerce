<?php
  /* login_result.php created Simon Pietro 02/12/2017 - 18:56 */
  /*
    Il file contiene il codice necessario per aggiungere un prodotto al database
  */

  include 'libreria.php';

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

  $nome_file = basename($_FILES["foto"]["name"]);
  $target_dir = "product_img/";
  $target_file = $target_dir . basename($_FILES["foto"]["name"]);
  $uploadOk = true;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"]))
  {
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if($check != false)
    {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = true;
    }
    else
    {
        echo "File is not an image.";
        $uploadOk = false;
    }
  }

  // Controlla se il file esiste
  if (file_exists($target_file))
  {
      errore("File già presente.");
      $uploadOk = false;
  }

  // Verifica il formato del file
  if($imageFileType != "jpg" && $imageFileType != "jpeg")
   {
      errore("Formato file non supportato.");
      $uploadOk = false;
  }

  if ($uploadOk == false)
   {
      errore("File non caricato.");
  }
  else //Se è tutto ok prova a caricare il file.
  {
      if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file))
      {
          $nome_file = basename($_FILES["foto"]["name"]);
      }
      else
      {
          errore("C'è stato un problema nel caricamento del file." . print_r($_FILES,true));
      }
  }

  //Mi connetto al db per inserire i dati nel database
  $connessione = connessione_db();

  //Creo la query per inserire i dati
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

    $id = $id . ".jpg";

    //Rinomino il file con il nome dell'id prodotto
    rename ($target_file, $target_dir . $id);

    //update del nome del file sul database
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

  mysqli_close($connessione);

  reindirizza("prodotti.php");

  ?>
