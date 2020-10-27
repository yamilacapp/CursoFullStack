<?php
if(file_exists("datos.txt")){
$jsonClientes=file_get_contents("datos.txt");
$aClientes=json_decode($jsonClientes,true);

}else{
    
    $aClientes=array();
}

$id = isset($_GET["id"])? $_GET["id"] : "";
print_r($id);
print_r($aClientes);
var_dump($aClientes);


if(isset($_GET["do"]) && $_GET["do"]=="eliminar"){
  unset($aClientes[$id]);
$jsonClientes=json_encode($aClientes);
  file_put_contents("datos.txt",$jsonClientes);
  $id="";
}



 if($_POST){
    
    $dni=trim($_POST["txtDni"]);
    $nombre=trim($_POST["txtNombre"]);
    $telefono=trim($_POST["txtTelefono"]);
    $correo=trim($_POST["txtCorreo"]);
    $imagen="";


    if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
        $nombreRandom = date("Ymdhmsi");
        $archivoTmp = $_FILES["archivo"]["tmp_name"];
        $nombreArchivo = $_FILES["archivo"]["name"];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreImagen = "$nombreRandom.$extension";
        move_uploaded_file($archivoTmp, "files/$nombreImagen");
    }


    if($id>=0){
     $aClientes[$id] = array("dni" =>$dni ,
                          "nombre"=>$nombre,
                        "telefono"=>$telefono,
                          "correo"=>$correo,
                        "imagen"=>$nombreImagen );

    }else{
    $aClientes[] = array("dni" =>$dni ,
                          "nombre"=>$nombre,
                        "telefono"=>$telefono,
                          "correo"=>$correo,
                        "imagen"=>$nombreImagen);
    }
  
  $jsonClientes=json_encode($aClientes);
  file_put_contents("datos.txt",$jsonClientes);
 }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Clientes</title>
   <link rel="stylesheet" href="css/fontawesome/fontawesome-free-5.13.1-web/css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome/fontawesome-free-5.13.1-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h1 class="text-center my-3">Registro Clientes</h1>
      
    </div>
    <div class="col-md-6">
     <form action="" method="POST" enctype="multipart/form_data">
       <div class="row">
         <div class="col-12">
          <label>DNI:</label>
          <input type="text" name="txtDni" class="form-control" value="<?php echo isset($aClientes[$id])? $aClientes[$id]["dni"] : ""; ?> "
>
         </div>
       </div>
        <div class="row">
         <div class="col-12">
          <label>Nombre:</label>
          <input type="text" name="txtNombre" class="form-control" value="<?php echo isset($aClientes[$id])? $aClientes[$id]["nombre"] : ""; ?>
">
         </div>
       </div>
       <div class="row">
         <div class="col-12 form-group">
          <label>Telefono:</label>
          <input type="number" name="txtTelefono" class="form-control" value="<?php echo isset($aClientes[$id])? $aClientes[$id]["telefono"] : ""; ?>
">
         </div>
       </div>
       <div class="row">
         <div class="col-12 form-group">
          <label>Correo:</label>
          <input type="email" name="txtCorreo" class="form-control" value="<?php echo isset($aClientes[$id])? $aClientes[$id]["correo"] : ""; ?>
">
         </div>
       </div>
        <div class="row">
         <div class="col-12 form-group">
          <label>Archivo Adjunto:</label>
          <input type="file" name="archivo" class="form-control-file">
         </div>
       </div>
       <div class="row">
         <div class="col-12 form-group">
         
           <button type="submit" name="btnGuardar" class="btn btn-primary my-3">Guardar</button>
          </div>
        </div>
       </form>
    </div>
    <div class="col-md-6">
      <table class="table table-hover">
       <tr>
         <th>Imagen:</th>
         <th>DNI:</th>
         <th>Nombre:</th>
         <th>Correo:</th>
         <th>Acciones:</th>
    
       </tr>
       <?php foreach ($aClientes as $id => $cliente): ?>
         <tr>
            <td><img src="files/<?php echo $cliente["imagen"]; ?>" alt="" class="img-thumbnail"></td>

             <td><?php echo $cliente["dni"]?></td>
          <td><?php echo $cliente["nombre"]?></td>
           <td><?php echo $cliente["correo"]?></td>
            <td style="width: 110px;">
                                <a href="index.php?id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>
                                <a href="index.php?id=<?php echo $id; ?>&do=eliminar"><i class="fas fa-trash-alt"></i></a>
                            </td>

         </tr>


       <?php endforeach; ?>
    
    </table>
    <a href="index.php"><i class="fas fa-plus"></i>
</a>
    
    </div>
  </div>
</div>
    
</body>
</html>  