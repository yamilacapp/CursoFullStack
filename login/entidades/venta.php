<?php


class Venta {
    private $idventa;
    private $fk_idcliente;
    private $fk_idproducto;
    private $fecha;
    private $cantidad;
    private $preciounitario;
    private $total;

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
        $this->idventa = isset($request["id"])? $request["id"] : "";
        $this->fk_idcliente = isset($request["cliente"])? $request["cliente"] : "";
        $this->fk_idproducto = isset($request["producto"])? $request["producto"]: "";
       
        $this->fecha= isset($request["fecha"])&&isset($request["time"])? $request["fecha"]." ".$request["time"]: "";
        $this->cantidad = isset($request["cantidad"])? $request["cantidad"] : "";
        $this->preciounitario = isset($request["txtPrecioUni"])? $request["txtPrecioUni"] :"";
        $this->total = isset($request["total"])? $request["total"] : "";
    }

    public function insertar(){
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        //Arma la query
        $sql = "INSERT INTO ventas (
                    fk_idcliente, 
                    fk_idproducto, 
                    fecha,
                    cantidad, 
                    preciounitario, 
                    total
                ) VALUES (
                     " . $this->fk_idcliente.", 
                     " . $this->fk_idproducto." , 
                     '" . $this->fecha ."' , 
                     " . $this->cantidad." , 
                     " . $this->preciounitario ." ,
                     " . $this->total ."
                );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idventa = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function actualizar(){
        
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE ventas SET
                fk_idcliente = ".$this->fk_idcliente.",
                fk_idproducto = ".$this->fk_idproducto.",
                fecha = '".$this->fecha."',
                cantidad= ".$this->cantidad.",
                preciounitario =  ".$this->preciounitario.",
                total= " .$this->total ."
                WHERE idventa = " . $this->idventa;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idventa, 
                        fk_idcliente, 
                        fk_idproducto, 
                        fecha, 
                        cantidad, 
                        preciounitario,
                        total
                FROM ventas 
                WHERE idventa = " . $this->idventa;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo
        if($fila = $resultado->fetch_assoc()){
            $this->idventa = $fila["idventa"];
            $this->fk_idcliente = $fila["fk_idcliente"];
            $this->fk_idproducto = $fila["fk_idproducto"];
            $this->cantidad = $fila["cantidad"];
            $this->fecha = $fila["fecha"];
            $this->preciounitario = $fila["preciounitario"];
            $this->total= $fila["total"];
        }  
        $mysqli->close();

    }

  public function obtenerTodos(){
        $aVentas = null;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql="SELECT
    A.idventa,
    A.fk_idcliente,
    A.fk_idproducto,
    A.fecha,
    A.cantidad,
    A.preciounitario,
    A.total
FROM
    ventas A
ORDER BY
    idventa DESC";
 $resultado = $mysqli->query($sql);
        if($resultado){
            while ($fila = $resultado->fetch_assoc()) {
                $obj = new Venta();
                $obj->idventa = $fila["idventa"];
                $obj->fk_idcliente = $fila["fk_idcliente"];
                $obj->fk_idproducto = $fila["fk_idproducto"];
                $obj->fecha = $fila["fecha"];
                $obj->cantidad= $fila["cantidad"];
                $obj->preciounitario= $fila["preciounitario"];
                $obj->total=$fila["total"];
                $aVentas[] = $obj;

            }
            return $aVentas;
        }
    }

    public function obtenerFacturacionMensual($mes){
        $total_mensual;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql="SELECT SUM(total) AS total_mensual FROM ventas WHERE MONTH(fecha)=$mes";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        if($fila = $resultado->fetch_assoc()){
            $total_mensual = $fila["total_mensual"];

        return $total_mensual;
        $mysqli->close();
     }
    }
     public function obtenerFacturacionAnual($anio){
        $total_anual;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql="SELECT SUM(total) total_anual FROM ventas WHERE YEAR(fecha)=$anio";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        if($fila = $resultado->fetch_assoc()){
            $total_anual = $fila["total_anual"];

        return $total_anual;
        $mysqli->close();
      }
     }

}


?>