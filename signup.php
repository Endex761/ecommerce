<?php


 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
    <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </head>
  <body>

    <section >
      <div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <div class="col-sm-2 col-sm-offset-5 col-xs-6 col-xs-offset-3 img-center">
          <a href="home.php">
            <center><img src="img/logo.png" class="img-responsive img-rounded" width="100px" height="auto"></center>
          </a>
        </div>

        <!-- col-*-offset-* per centrare il contenuto -->
        <div class="col-lg-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" style="border: 2px solid grey; border-radius: 10px; background:#F9F9F9;">


          <div class="col-lg-8 col-md-8 col-sm-8 col-xm-12">
            <h2>Nuovo account</h2>
          </div>


        <form  method="post" name="signup-form" id="signup" action="signup_result.php">
            <div class="form-group"> <!-- form-attributes----------------------->


            <!-- Nome -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input name="nome" type="text" class="form-control input-sm" id="nome" autocomplete="off" required>
                </div>
            </div>

            <!-- Cognome -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="cognome">Cognome</label>
                    <input name="cognome" type="text" class="form-control input-sm" id="cognome" autocomplete="off" required>
                </div>
            </div>

            <!-- E-mail -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" type="email" class="form-control input-sm" id="email"  autocomplete="off" required>
                </div>
            </div>

            <!-- Password -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group contact-field">
                    <label for="password">Password</label>
                    <input name="password" type="password"  class="form-control input-sm" id="password" placeholder="Almeno 8 caratteri" minlength="8" maxlength="16" autocomplete="off" required>
                </div>
            </div>

            <!-- Conferma password -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="conferma-password">Conferma password</label>
                    <input name="conferma-password" type="password" class="form-control input-sm" id="conferma-password" oninput="checkPassword(this);" maxlength="16" autocomplete="off" required>
                </div>
            </div>

            <!-- Recupero password  -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="risposta-recupero-psw">Recupero password</label>
                    <input name="risposta-recupero-psw" type="text" class="form-control input-sm" id="risposta-recupero-psw" placeholder="Qual è il cognome da nubile di tua madre?" autocomplete="off" required>
                </div>
            </div>

            <!-- Indirizzo spedizione -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="indirizzo">Indirizzo spedizione</label>
                    <input name="indirizzo" type="text" class="form-control input-sm" id="indirizzo" autocomplete="off" placeholder="Via, Città, CAP .." required>
                </div>
            </div>

            <div class="col-xs-12">

              <!-- Bottone Registrati -->
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                      <button type="submit" id="form-submit" class="btn btn-info">Registrati</button>
                  </div>
              </div>

              <!-- Checkbox condizioni -->
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <div class="checkbox">
                  <label><input type="checkbox" required>Ho letto e accetto le condizioni.</label>
                </div>
              </div>

            </div>


          </div>
        </form>

        <div class="col-xs-12" style="margin-bottom:17px;">
          <hr />
          <div class="col-xs-12 text-center">
            <a href="login.php"><button type="button" class="btn btn-warning">Già registrato? Accedi!</button></a>
          </div>
        </div>

      </div>
  </div><!--content-->
  </section>

  <footer>
    <div class="col-xs-12 text-center" id="footer">
      <p>SR Furnitures Copyright @ 2017 Simon Pietro Romeo & Dario Stella</p>
    </div>
  </footer>

  <script type="text/javascript" src="js/functions.js"></script>
  </body>
</html>
