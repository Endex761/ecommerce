<?php

  include 'libreria.php';

  //Se status == not_logged stampero' un messaggio di errore
  $logged = true;
  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
    if(isset($_GET['status']))
    {
      $status = test_input($_GET['status']);
      if($status == 'not_logged')
        $logged = false;
    }
  }

  if($logged)
  {
    $errore = "";
  }
  else
  {
      $errore = "Devi effettuare l'accesso per accedere a questa pagina.";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
    <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
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

            <!-- E-mail -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" type="email" class="form-control input-sm" id="email"  required>
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
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                      <button type="submit" id="form-submit" class="btn btn-info ">Accedi</button>
                  </div>
              </div>


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
  <!--<footer>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" id="footer">
      <p>SR Furnitures Copyright @ 2017 Simon Pietro Romeo & Dario Stella</p>
    </div>
  </footer> -->

  <script type="text/javascript" src="js/functions.js"></script>
  </body>
</html>
