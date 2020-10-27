<?php


class Usuario {
    private $idusuario;
    private $usuario;
    private $clave;
    private $nombre;
    private $apellido;
    private $correo;

    public function __construct(){

    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }

    public function cargarFormulario($request){
        $this->idusuario = isset($request["id"])? $request["id"] : "";
        $this->usuario = isset($request["txtUsuario"])? $request["txtUsuario"] : "";
        $this->clave = isset($request["txtClave"])? $request["txtClave"]: "";
        $this->nombre = isset($request["txtNombre"])? $request["txtNombre"]: "";
        $this->correo = isset($request["txtCorreo"])? $request["txtCorreo"] : "";
        $this->apellido = isset($request["txtApellido"])? $request["txtApellido"] :"";
    }

    public function insertar(){
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        
        //Arma la query
        $sql = "INSERT INTO usuarios (
                    usuario, 
                    clave, 
                    nombre, 
                    apellido, 
                    correo
                ) VALUES (
                    '" . $this->usuario ."', 
                    '" . $this->clave ."', 
                    '" . $this->nombre ."', 
                    '" . $this->apellido."', 
                    '" . $this->correo."'
                );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idusuario = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function actualizar(){
        
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE usuarios SET
                usuario = '".$this->usuario."',
                clave = '".$this->clave."',
                nombre = '".$this->nombre."',
                apellido = '".$this->apellido."',
                correo =  '".$this->correo."'
                WHERE idusuario = " . $this->idusuario;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM usuarios WHERE idusuario = " . $this->idusuario;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idusuario, 
                        usuario, 
                        clave, 
                        nombre, 
                        apelllido, 
                        correo 
                FROM usuarios
                WHERE idusuario = " . $this->idusuario;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo
        if($fila = $resultado->fetch_assoc()){
            $this->idusuario = $fila["idusuario"];
            $this->usuario = $fila["usuario"];
            $this->clave = $fila["clave"];
            $this->nombre = $fila["nombre"];
            $this->correo = $fila["correo"];
            $this->apellido = $fila["apellido"];
        }  
        $mysqli->close();

    }

  public function obtenerTodos(){
        $aUsuario = null;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $resultado = $mysqli->query("SELECT
    A.idusuario,
    A.clave,
    A.usuario,
    A.nombre,
    A.apellido,
    A.correo
    
FROM
    clientes A
ORDER BY
    idcliente DESC");

        if($resultado){
            while ($fila = $resultado->fetch_assoc()) {
                $obj = new Usuario();
                $obj->idusuario = $fila["idusuario"];
                $obj->usuario = $fila["usuario"];
                $obj->clave = $fila["clave"];
                $obj->nombre= $fila["nombre"];
                $obj->correo = $fila["correo"];
                $obj->apellido = $fila["apellido"];
                $aUsuario[] = $obj;

            }
            return $aUsuario;
        }
    }

    public function encriptarClave($clave){

        $claveEncriptada=password_hash($clave, PASSWORD_DEFAULT);
        return $claveEncriptada;
    }

    public function verificarClave($claveIngresada, $claveEnBBDD){
        return password_verify($claveIngresada, $claveEnBBDD);
    }

public function obtenerPorUsuario($usuario){
   
   $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
    $sql="SELECT idusuario, usuario, clave, nombre, apellido, correo FROM usuarios WHERE usuario='$usuario'";
  
if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

    if($fila = $resultado->fetch_assoc()){
         
          $this->idusiario=$fila["idusuario"];
          $this->usuario=$fila["usuario"];
         $this->clave=$fila["clave"];
          $this->nombre=$fila["nombre"];
          $this->apellido=$fila["apellido"];
          $this->correo=$fila["correo"];
       

    }
    $mysqli->close();
}

}


?>