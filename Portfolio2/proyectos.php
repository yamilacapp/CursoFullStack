<?php 
$msg="proyectos";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
 <link rel="stylesheet" href="css/fontawesome/fontawesome-free-5.13.1-web/css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome/fontawesome-free-5.13.1-web/css/fontawesome.min.css">
<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<section id="proyectos">
<div class="container">
   <div class="row">
       <div class="col-12">
           <div class="row">
           
           <?php include_once "menu.php"; ?>

</div>

                   <div class="row">
                       <div class="col-8 my-5">
                          <h1>Mi proyectos</h1>
                          <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae error sequi debitis magni ipsam esse minima. Totam praesentium consectetur ea in inventore nostrum optio perferendis blanditiis. Fugit, officia repellat. Nemo!</p>
                       
                       </div>
                   </div>
                   <div class="row mb-3">
                      <div class="col-12">
                          <div class="row">
                         <div class="col-4 ">
                             <div class="border rounded shadow article">
                                 <div  class="border rounded shadow m-2"><img src="img/imagenes/abm.png" alt="" class="img-fluid"></div>
                                 <h6 class="p-3">ABM CLIENTES</h6>
                                 <P class="p-2">Alta, baja, modificacion de un registro de clientes empleando: Realizado en HTML, CSS, Bootstrap, PHP, y Json</P>
                                 <button class="btn bg-red m-2">VER PROYECTO</button> <a href="" class="float-right mr-3 mt-3">CODIGO FUENTE</a>
                             </div>
                         </div>
                         <div class="col-4 ">
                             <div class="border rounded shadow article">
                                 <div  class="border rounded shadow m-2"><img src="img/imagenes/ventas.png" alt="" class="img-fluid"></div>
                                 <h6 class="p-3">SISTEMA DE GESTIÓN DE VENTAS</h6>
                                 <P class="p-2">Sistema de gestión de clientes, productos y ventas. Realizado en HTML, CSS, PHP, MVC, Bootstrap, Js, Ajax, JQuery y MySQL de base de datos.</P>
                                 <button class="btn bg-red m-2">VER PROYECTO</button> <a href="" class="float-right mr-3 mt-3">CODIGO FUENTE</a>
                             </div>
                         </div>
                         <div class="col-4">
                             <div class="border rounded shadow article">
                                 <div  class="border rounded shadow m-2"><img src="img/imagenes/proyecto.png" alt="" class="img-fluid"></div>
                                 <h6 class="p-3">PROYECTO INTEGRADOR</h6>
                                 <P class="p-2">Proyecto Full Stack desarrollado en PHP, Laravel, Javascript, JQuery, Ajax, HTML, CSS, con panel administrador, gestor de usuarios, módulo de permisos, y funcionalidades afines.</P>
                                 <button class="btn bg-red m-2">VER PROYECTO</button> <a href="" class="float-right mr-3 mt-3">CODIGO FUENTE</a>
                             </div>
                         </div>
                        </div>
                      </div>
                   
                   </div>
                
             
        <?php include_once "footer.php"; ?>
       
       </div>
   
   </div>
  
</div>

</section>




 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>
</html>