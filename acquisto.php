<?php
  include 'libreria.php';
 ?>

 <html>
   <head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
     <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
     <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <?php include_bootstrap(); ?>
   </head>
   <body>

     <div class="container-fluid">

       <div class="col-xs-12 text-center" >
         <h1> Spedizione & Pagamento </h1>
       </div>

       <div class="col-xs-3 pull-right" style="background-color:green;">
         c
       </div>

       <div class="col-xs-9" style="border-radius: 5px; padding:5px; background-color:#F9F9F9">
         <div class="col-xs-12" style="padding:10px;">
           <div class="col-xs-3">
             <h4>Indirizzo spedizione:</h4>
           </div>
           <div class="col-xs-9">
             <input type="text" class="form-control" value="Via Ciaculli 14, Palermo, Italia.">
             <br>
             <a>Cambia indirizzo di spedizione predefinito</a>
           </div>
         </div>

         <div class="col-xs-12" style="padding:10px;">
           <div class="col-xs-3">
             <h4>Indirizzo fatturazione:</h4>
           </div>
           <div class="col-xs-9">
             <input type="text" class="form-control" value="Via Ciaculli 14, Palermo, Italia.">
             <br>
             <label><input type="checkbox"> Utilizza questo indirizzo come indirizzo di fatturazione.</label>
           </div>
         </div>
       </div>



       <div class="col-xs-9">
         <div class="col-xs-3">
           <h4>Metodo Pagamento:</h4>
         </div>
         <div class="col-xs-9">
           <div class="col-xs-12">
              <select class="form-control">
                <option>Mastercard</option>
              </select>
            </div>
         </div>
       </div>




     <?php draw_footer(); ?>
   </body>
</html>
