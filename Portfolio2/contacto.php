<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once ("PHPMailer/PHPMailer/src/SMTP.php");
include_once ("PHPMailer/PHPMailer/src/PHPMailer.php");

$pg="contacto"; 

$msg = "";

function guardarCorreo($correo)
{
    $archivo = fopen("mails.txt", "a+");
    fwrite($archivo, $correo . ";\n\r");
    fclose($archivo);
}

if ($_POST) { /* es postback */

    $nombre = $_POST["txtNombre"];
    $correo = $_POST["txtEmail"];
    $mensaje = $_POST["txtComentario"];

    if ($nombre != "" && $correo != "") {
        guardarCorreo($correo);

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.nelsontarche.com.ar"; // SMTP a utilizar. Por ej. mail.dominio.com.ar
        $mail->Username = "yamila_capp@hotmail.com"; // Correo completo a utilizar
        $mail->Password = "aqui va la clave de tu correo";
        $mail->Port = 25;
        $mail->From = "yamila_capp@hotmail.com"; // Desde donde enviamos (Para mostrar)
        $mail->FromName = "Yamila Cappari";
        $mail->IsHTML(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        //Destinatario
        $mail->addAddress($correo);
        //$mail->addBCC("nelson.tarche@gmail.com");
        $mail->Subject = "Contacto página web";
        $mail->Body = "Recibimos tu consulta, <br>te responderemos a la brevedad.";
        //  if(!$mail->Send()){
        //     $msg = "Error al enviar el correo, intente nuevamente mas tarde.";
        //   }
        $mail->ClearAllRecipients(); //Borra los destinatarios

        //Nosotros
        $mail->addAddress("yamila_capp@hotmail.com");
        $mail->Subject = "Recibiste un mensaje desde tu página web";
        $mail->Body = "Te escribió $nombre cuyo correo es $correo  y el siguiente mensaje:<br><br>$mensaje";

        if ($mail->Send()) {
        //if(1==1){
            //header('Location: contacto.php');
            $msg="Enviado correctamente";
        } else {
            $msg = "Error al enviar el correo, intente nuevamente mas tarde.";
        }
    } else {
        $msg = "Complete todos los campos";
    }

}

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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<section class="" id="contacto">
   <div class="container">
      
       <div class="row">
           <div class="col-12">
               <div class="row">
                   <?php include_once "menu.php"; ?>
               </div>
                <?php if (isset($msg) && $msg != ""): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
            <?php echo $msg; ?>
            </div>
        </div>
    </div>
    <?php endif;?>
               <div class="row my-5">
                   <div class="col-12 my-3">
                       <h1>Contacto</h1>
                   </div>
                   <div class="col-6">
                       
                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto laborum ipsum temporibus sit? Ipsa ratione, laborum harum possimus cumque at sapiente blanditiis eum sint? Accusantium officia esse pariatur veritatis ab!</p>
                   </div>
                   <div class="col-6">
                       <form action="" method="POST">
                           <div class="form-group">
                            <input type="text" id="txtNombre" name="txtNombre" placeholder="Nombre" class="form-control shadow">
                           </div>
                           <div class="form-group">
                            <input type="email" id="txtEmail" name="txtEmail" placeholder="Email" class="form-control shadow">
                           </div>
                           <div class="form-group">
                            <textarea type="text" id="txtComentario" name="txtComentario" placeholder="Comentarios" class="form-control shadow" height="300px"></textarea>
                           </div>
                       <div class="form-group">
                           <div class="g-recaptcha float-left" data-sitekey="6LeI5M0ZAAAAAEldgagmliTgqwY8yZI0_7raEgRD"></div>

                            <button class="btn bg-white rounded my-3 p-2 px-5 shadow float-right">ENVIAR</button>
                           </div>
                       


                       </form>
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