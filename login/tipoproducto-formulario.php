<?php 


include_once "config.php";
include_once "entidades/tipoproducto.php";
$tipoproducto = new TipoProducto();
$tipoproducto->cargarformulario($_REQUEST);
$msg=array();

if($_POST){
  if(isset($_POST["btnGuardar"])){
    if(isset($_GET["id"])&&$_GET["id"]>0){
        $tipoproducto->actualizar();
        $msg=array("mensaje"=>"Actualizado correctamente", "color"=>"primary");
    }else{
      $tipoproducto->insertar();
      $msg=array("mensaje"=>"Ingresado correctamente", "color"=>"secondary");
    }
  }else if(isset($_POST["btnBorrar"])){
    
    $tipoproducto->eliminar();
    $msg=array("mensaje"=>"Eliminado correctamente", "color"=>"danger");
    header("location:tipoproductos-listado.php");
    
  }



}

if(isset($_GET["id"])&&$_GET["id"]>0){
  $tipoproducto->obtenerPorId();
  
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
<link href="css/estilos.css" type="text/css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
<form method="POST" action="">
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
        <a class="nav-link" href="index.php">
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
            <h1 class="h3 mb-0 text-gray-800">Tipo de Producto</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>
          </div>

          <?php if(isset($msg["mensaje"])&&$msg["mensaje"]!=""): ?>
          <div class="row">
             <div class="col-10">
               <div class="alert alert-<?php echo $msg["color"];?>" role="alert">
                 <?php echo $msg["mensaje"]; ?>
               </div>
             </div>
           </div>
         <?php endif; ?>

          <!-- Content Row -->
          <div class="row">

            <div class="col-12 button">
               <a href="tipoproductos-listado.php"><button class="btn btn-primary">Listado</button></a>
              <a href="tipoproducto-formulario.php"> <button class="btn btn-secondary">Nuevo</button></a>
               <button class="btn btn-success" type="submit" name="btnGuardar">Guardar</button>
               <button class="btn btn-warning" type="submit" name="btnBorrar">Borrar</button>
            </div>

          
          </div>
          <div class="row">
             <div class="col-12 form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" name="txtNombre" id="txtNombre" class="form-control" value="<?php echo $tipoproducto->nombre; ?>" >
             
             
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
