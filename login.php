<?php

  /*
    File:login.php
    Il file consente ad un utente già registrato o ad un admin di effettuare l'accesso al sitoweb
  */
  include 'libreria.php';

  //Messaggio d'errore da stampare in base allo status
  $errore = "";

  //Email inserita automaticamente nel caso del recupero password
  $email = "";

  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
    if(isset($_GET['status']))
    {
      //Prendo lo status dal GET
      $status = test_input($_GET['status']);

      //Status non loggato
      if($status == 'not_logged')
        $errore = "Devi effettuare l'accesso per accedere a questa pagina.";

      //Status password errata
      if($status == 'wrong_password')
        $errore = "La password inserita non corrisponde.";

      //Status nessuna e-mail presente
      if($status == 'wrong_email')
        $errore = "L'e-mail inserita non corrisponde a nessun account.";
    }

    //Questo campo solitamente è imostata quando si effettual il cambio della password
    if(isset($_GET['email']))
    {
      //Se è impostato prendo l'email
      $email = test_input($_GET['email']);
    }
  }

  //Se l'email non è nulla reindirizzo l'utente alle impostazioni dopo il login
  if($email!="")
    $impostazioni = "<input type='text' name='impostazioni' value='true' style='disply:none;'>";
  else
    $impostazioni = "";


?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Login </title>
    <?php include_bootstrap(); ?>

  </head>
  <body>

    <section >
      <div class="container-fluid  col-xs-12">


        <div class="col-sm-2 col-sm-offset-5 col-xs-6 col-xs-offset-3 img-center">
          <a href="home.php">
            <center><img src="img/logo.png" class="img-responsive img-rounded" width="100px" height="auto"></center>
          </a>
        </div>

        <!-- col-*-offset-* per centrare il contenuto -->
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" style="border: 2px solid grey; border-radius: 10px; background:#F9F9F9;">


          <div class="col-lg-12 col-xs-12">
            <h2>Accedi</h2>
            <h6 style="color:red;"><?php echo $errore ?></h6>
          </div>


        <form  class="" method="post" name="login-form" id="login" action="login_result.php">
            <div class="form-group"> <!-- form-attributes----------------------->
            <?php echo $impostazioni //Codice che permette di andare direttamente alle impostazioni per resettare la password dopo il login?>
            <!-- E-mail -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" type="email" class="form-control input-sm" id="email" value="<?php echo $email ?>" required>
                </div>
            </div>


            <!-- Password -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group contact-field">
                    <label for="password">Password</label>
                    <input name="password" type="password"  class="form-control input-sm" id="password" minlength="8" maxlength="16"  required>
                </div>
            </div>


            <!-- div che contiene il bottone sara una colonna da 12 -->
            <div class="col-xs-12">

              <!-- Bottone Accedi -->
              <div class=" col-xs-12">
                  <div class="form-group">
                      <button type="submit" id="form-submit" class="btn btn-info ">Accedi</button>
                  </div>
              </div>

              <center><a href="recupero.php">Password dimenticata? </a></center>

            </div>

          </div>
        </form>

        <div class="col-xs-12" style="margin-bottom:17px;">
          <hr />
          <div class="col-xs-12 text-center">
            <a href="signup.php"><button type="button" class="btn btn-warning">Nuovo utente? Registrati!</button></a>
          </div>
        </div>

      </div>
  </div><!--content-->
  </section>

  <?php
    draw_footer();
  ?>

  <script type="text/javascript" src="js/functions.js"></script>
  </body>
</html>
