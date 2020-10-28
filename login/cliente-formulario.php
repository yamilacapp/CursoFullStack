<?php 


include_once "config.php";
include_once "entidades/cliente.php";
include_once "entidades/provincia.entidad.php";
include_once "entidades/localidad.entidad.php";
include_once "entidades/domicilio.entidad.php";

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);
$msg=array();


if($_POST){
  if(isset($_POST["btnGuardar"])){
    if(isset($_GET["id"])&&$_GET["id"]>0){
        $cliente->actualizar();
         $msg=array("mensaje"=>"Actualizado correctamente", "color"=>"primary");
    }else{
      $cliente->insertar();
      $msg=array("mensaje"=>"Ingresado correctamente", "color"=>"secondary");
    }
  }else if(isset($_POST["btnBorrar"])){
    if($cliente->existeVenta($cliente->idcliente)==-1){ 
       $cliente->eliminar();
       header("location: clientes-listado.php");
    }else{ 
       $msg=array("mensaje"=>"No se puede eliminar", "color"=>"danger");
       
  }
}


}

if(isset($_GET["do"]) && $_GET["do"] == "buscarLocalidad" && $_GET["id"] && $_GET["id"] > 0){
    $idProvincia = $_GET["id"];
    $localidad = new Localidad();
    $aLocalidad = $localidad->obtenerPorProvincia($idProvincia);
    echo json_encode($aLocalidad);
    exit;
} else if(isset($_GET["id"]) && $_GET["id"] > 0){
    $cliente->obtenerPorId();
}


if(isset($_GET["id"])&&$_GET["id"]>0){
   $cliente->obtenerPorId();
  

}

if (isset($_POST["txtTipo"])) {
    $domicilio = new Domicilio();
    $domicilio->eliminarPorCliente($cliente->idcliente);
    for ($i = 0; $i < count($_POST["txtTipo"]); $i++) {
      $domicilio->fk_idcliente = $cliente->idcliente;
      $domicilio->fk_tipo = $_POST["txtTipo"][$i];
      $domicilio->fk_idlocalidad =  $_POST["txtLocalidad"][$i];
      $domicilio->domicilio = $_POST["txtDomicilio"][$i];
      $domicilio->insertar();
    }
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

$provincia= new Provincia();
$array_provincia=$provincia->obtenerTodos();


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
 <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
  <script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>



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
            <h1 class="h3 mb-0 text-gray-800">Clientes</h1>
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
          <div class="col-10">
          <form action="" method="POST">
          <div class="row">
            <div class="col-12 button">
               <button class="btn btn-primary"><a href="clientes-listado.php"> Listado</a></button>
               <button class="btn btn-secondary"><a href="cliente-formulario.php"> Nuevo</a></button>
               <button class="btn btn-success" type="submit" name="btnGuardar">Guardar</button>
               <button class="btn btn-warning" type="submit" name="btnBorrar">Borrar</button>
            </div>
          </div>
          <div class="row my-3">
           
            <div class="col-6 form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $cliente->nombre; ?>">
             </div >
             <div class="col-6 form-group">
                <label for="txtCuit">CUIT</label>
                
                    <input type="text" name="txtCuit" id="txtCuit" class="form-control" value="<?php echo $cliente->cuit; ?>">
               

             </div >
             <div class="col-6 form-group">
                <label for="txtFechaNac">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="txtFechaNac" name="txtFechaNac" value="<?php echo $cliente->fecha_nac; ?>" >
             
             </div >
             <div class="col-6 form-group">
                <label for="txtTelefono">Telefono:</label>
                <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" value="<?php echo $cliente->telefono; ?>">
             
             </div >
             <div class="col-12 form-group">
             <label for="txtCorreo">Correo:</label>
             <input type="text" name="txtCorreo" id="txtCorreo" class="form-control" value="<?php echo $cliente->correo; ?>">
             </div>
          
          
          
          
          
          </div>
          <div class="row">
        <div class="col-12">  
        <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Domicilios
                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalDomicilio">Agregar</button>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="grilla" class="display" style="width:98%">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Provincia</th>
                                <th>Localidad</th>
                                <th>Dirección</th>
                            </tr>
                        </thead>
                    </table> 
                 </div>
            </div>          
        </div>
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
  
<div class="modal fade" id="modalDomicilio" tabindex="-1" role="dialog" aria-labelledby="modalDomicilioLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDomicilioLabel">Domicilio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col-12 form-group">
                <label for="lstTipo">Tipo:</label>
                <select name="lstTipo" id="lstTipo" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="1">Personal</option>
                    <option value="2">Laboral</option>
                    <option value="3">Comercial</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstProvincia">Provincia:</label>
                <select name="lstProvincia" id="lstProvincia" onchange="fBuscarLocalidad();" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                    <?php foreach($array_provincia as $provincia): ?>
                                            <option value="<?php echo $provincia->idprovincia ?>"><?php echo $provincia->nombre ?></option>
                    <?php endforeach; ?>                      
                                    </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstLocalidad">Localidad:</label>
                <select name="lstLocalidad" id="lstLocalidad" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                   
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtDireccion">Dirección:</label>
                <input type="text" name="" id="txtDireccion" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="fAgregarDomicilio()">Agregar</button>
      </div>
    </div>
  </div>
</div>
</form>
<script>
$(document).ready( function () {
    $('#grilla').DataTable();
} );

function fBuscarLocalidad(){
            idProvincia = $("#lstProvincia option:selected").val();

            $.ajax({
                type: "GET",
                url: "cliente-formulario.php?do=buscarLocalidad",
                data: { id:idProvincia },
                async: true,
                dataType: "json",
                success: function (respuesta) {
              		let opciones = "<option value='0' disabled selected>Seleccionar</option>";
                  const resultado = respuesta.reduce(function(acumulador, valor){
                  		const {nombre,idlocalidad} = valor;
                  		return acumulador + `<option value="${idlocalidad}">${nombre}</option>`;
                  }, opciones);
                  $("#lstLocalidad").empty().append(resultado);

                }
            });
        }

function fAgregarDomicilio(){
            var grilla = $('#grilla').DataTable();
            grilla.row.add([
                $("#lstTipo option:selected").text() + "<input type='hidden' name='txtTipo[]' value='"+ $("#lstTipo option:selected").val() +"'>",
                $("#lstProvincia option:selected").text() + "<input type='hidden' name='txtProvincia[]' value='"+ $("#lstProvincia option:selected").val() +"'>",
                $("#lstLocalidad option:selected").text() + "<input type='hidden' name='txtLocalidad[]' value='"+ $("#lstLocalidad option:selected").val() +"'>",
                $("#txtDireccion").val() + "<input type='hidden' name='txtDomicilio[]' value='"+$("#txtDireccion").val()+"'>"
            ]).draw();
            $('#modalDomicilio').modal('toggle');
            limpiarFormulario();
        }

 function limpiarFormulario(){
            $("#lstTipo").val("");
            $("#lstProvincia").val("");
            $("#lstLocalidad").val("");
            $("#txtDireccion").val("");
        }
</script>




  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

 
</body>

</html>
