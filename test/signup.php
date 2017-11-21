<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
  </head>
  <body>
    <section>
      <h2>Nuovo account</h2>
        <form class="contact-form" method="post" name="signup-form" id="signup" action="home.php">
            <label for="nome">Nome</label>
            <input type="text"  id="nome" required>

            <label for="cognome">Cognome</label>
            <input type="text"  id="cognome" required>

            <label for="email">E-mail</label>
            <input type="email"  id="eemail" required>

            <label for="psw">Password</label>
            <input  type="password"  id="password" placeholder="Almeno 8 caratteri" minlength="8" maxlength="16" required>

            <label for="conferma-psw">Conferma password</label>
            <input type="password"  id="conferma-password" oninput="checkPassword(this);" required>

            <label for="domanda-recupero-psw">Recupero password</label>
            <input type="text" id="risposta-password" placeholder="Qual è il cognome da nubile di tua madre?" required>

            <label for="indirizzo">Indirizzo spedizione</label>
            <input type="text" id="indirizzo" required>

            <button type="submit" id="form-submit">Submit</button>

        </form>
  </section>
  <script>
    function checkPassword(input)
    {
      if(input.value != document.getElementById('password'))
        input.setCustomValidity("La password non corrisponde.");
      else
        input.setCustomValidity("");
      }
  </script>
  </body>
</html>
