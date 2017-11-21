<!DOCTYPE html>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <link rel="stylesheet" type="text/css" href="css/basic.css">
    <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Legnomarket</title>
  </head>
  <body class="body">
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#"><img class="img-responsive" height="70px" width="50px" src="img/logo.png"/></a>
            </div>
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">About Us</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
          </div>
        </nav>
    </header>
    <br/>
    <br/>
    <div class="row">
      <section id="main"> <!-- check sidebar1 and aside as ID -->
        <div class="col-md-4">
          <div class="panel panel-primary">
            <div class="panel-heading">Legno di mogano</div>
            <div class="panel-body"><img src="product_img/1.jpeg" class="img-responsive img-prd" height="200px" width="200px"  alt="Image"></div>
            <div class="panel-footer">
              <p>Fantastico mobile in legno di mogano<p>
              <button class="btn-primary btn">Compralo!</button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-primary">
            <div class="panel-heading">Comodino comodo</div>
            <div class="panel-body"><img src="product_img/2.jpeg" class="img-responsive img-prd" height="200px" width="200px"  alt="Image"></div>
            <div class="panel-footer">
              <p>Comodino fatto con parti comode<p>
              <button class="btn-primary btn">Compralo</button>
            </div>
          </div>
        </div>





        <!--<article class="article">
          <header>
            <h2>Legno di mogano</h2>
          </header>
          <img class="article-img" src="product_img/1.jpeg"/>
          <p>Fantastico mobile in legno di mogano</p>
          <button class="btn">Compralo</button>
        </article>
        <br/>
        <article class="article">
          <header>
            <h2>Comodino comodo</h2>
          </header>
          <img class="article-img" src="product_img/2.jpeg"/>
          <p>Comodino fatto con parti comode</p>
          <button class="btn">Compralo</button>
        </article>-->
      </section>
    </div>

      <footer class="col-md-12">
        <p>SR Furnitures Copyright @ 2017 Simon Pietro Romeo</p>
      </footer>



  </body>
</html>
