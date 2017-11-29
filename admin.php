<?php
  include "libreria.php";
 ?>
<!--Pagina login per l'admin -->
<html>
<head>
  <title>Login per l'amministratore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
  <?php include_bootstrap(); ?>
</head>
<body>
  <div class = "container-fluid col-xs-12">

    <div class = "col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" style="border: 2px solid grey; border-radius:10px; background:#F9F9F9;">

  <h2>Login per l'amministratore</h2>
  <form action="/action_page.php">

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>

    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>

    <div class="checkbox">
      <label><input type="checkbox" name="remember"> Remember me</label>
    </div>

    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  </div>
</div>

</body>
</html>
