<?php 


include_once "config.php";
include_once "entidades/producto.php";
include_once "entidades/tipoproducto.php";

$tipoproducto=new TipoProducto();
$aTipoProducto=$tipoproducto->obtenerTodos();
$producto = new Producto();
$producto->cargarformulario($_REQUEST);

if($_POST){
  if(isset($_POST["btnGuardar"])){

    if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
        $nombreRandom = date("Ymdhmsi");
        $archivoTmp = $_FILES["archivo"]["tmp_name"];
        $nombreArchivo = $_FILES["archivo"]["name"];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreImagen = "$nombreRandom.$extension";
        move_uploaded_file($archivoTmp, "files/$nombreImagen");
    }else{
      $nombreImagen=$producto->imagen;
    }


    if(isset($_GET["id"])&&$_GET["id"]>0){
        $producto->actualizar();
        if(isset($producto->imagen)&&$nombreImagen!=$producto->imagen){
          
            unlink("files/".$aClientes[$id]["imagen"]);


    }else{
      $producto->insertar();
      $producto->imagen=$nombreImagen;
    }
  }else if(isset($_POST["btnBorrar"])){
     $producto->eliminar();
     header("location: productos-listado.php");

  }
}

if(isset($_GET["id"])&&$_GET["id"]>0){
   $producto->obtenerPorId();
  

}


if(!isset($_SESSION["nombre"])){
 header("Location: login.php");

}


if($_POST){
if(isset($_POST["btnCerrar"])){
  session_destroy();
  header("Location: login.php");
}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ABM Ventas</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
<form method="POST" action=""  >
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ABM Ventas</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Inicio</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
       Administración
       </div>

      
          <?php  include_once("menu.php");   ?>
   

    

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
      <?php  include_once "navbar.php"; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Productos</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>
          </div>

          <!-- Content Row -->
        <div class="row">
           <div class="col-10">
            <form action="" method="POST" enctype="multipart/form-data"></form>
              <div class="row">
               <div class="col-12">
               <button class="btn btn-primary"><a href="productos-listado.php">Listado</a> </button>
               <button class="btn btn-secondary"><a href="producto-formulario.php"> Nuevo</a></button>
               <button class="btn btn-success" name="btnGuardar">Guardar</button>
               <button class="btn btn-warning">Borrar</button>
              </div>
             </div>
             <div class="row my-3">
           
              <div class="col-6 form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $producto->nombre ?>">
              </div >
              <div class="col-6 form-group">
                <label for="">Tipo de Producto:</label>
                <select name="tipoProducto" id="tipoProducto" class="form-control">
               <option value="" selected disabled>seleccionar</option>
                <?php foreach($aTipoProducto as $tipoProducto): ?>
                 <?php if($tipoProducto->idtipoproducto === $producto->idtipoproducto): ?>
                    <option selected value="<?php echo $tipoProducto->idtipoproducto; ?> " class="form-control"><?php echo $tipoProducto->nombre; ?></option>
                 <?php else: ?>
                    <option value="<?php echo $tipoProducto->idtipoproducto; ?> " class="form-control"><?php echo $tipoProducto->nombre; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
               
               </select>
              </div >
             <div class="col-6 form-group">
                <label for="txtCantidad">Cantidad:</label>
                <input type="text" class="form-control" id="txtCantidad" name="txtCantidad" value="<?php echo $producto->cantidad ?>" >
             
              </div >
              <div class="col-6 form-group">
                <label for="txtPrecio">Precio:</label>
                <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" value="<?php echo $producto->precio ?>">
             
              </div >
              <div class="col-6 form-group">
                <label for="archivo">Imagen:</label>
                <input type="file" class="form-control" id="archivo" name="archivo" >
             
              </div >


              <div class="col-12 form-group">
              <label for="txtDescripcion">Descripcion:</label>
              <textarea type="text" name="txtDescripcion" id="txtDescripcion" cols="30" rows="10" class="form-control" value="<?php echo $producto->descripcion ?>"></textarea>
              </div>
          
              
          
            
          
            
           </form>
          
          
          
          
          </div>

           

          
            

          
          </div>

          <!-- Content Row -->

         

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

            
             

            

            </div>

            <div class="col-lg-6 mb-4">

              

             

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Desea cerrar Seción?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Seleccione "Cerrar seción" debajo si estas listo para cerrar tu seción.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="submit" name="btnCerrar" data-dismiss="modal">Cancel</button>
          <button type="submit" name="btnCerrar" class="btn btn-primary" ">Cerrar Cesión</button>
        </div>
      </div>
    </div>
  </div>
</form>
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script>
        ClassicEditor
            .create( document.querySelector( '#txtDescripcion' ) )
            .catch( error => {
            console.error( error );
            } );
        </script>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>


</html>
