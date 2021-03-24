<?php
require_once '../config/Database.php';
class B2bModel {
  
    private $db; 
    function __construct()
    {
        $this->db = new Database();
    } 

    public function get_products_by_date($date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT data_productos.SKU AS sku, data_productos.NOMBRE AS nombre FROM data_b2b 
        INNER JOIN data_productos ON data_productos.SKU = data_b2b.SKU 
        WHERE data_b2b.fecha = ? 
        GROUP BY data_productos.SKU ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 

        $this->db->db_close($conn);
        return $result;
    }

    public function get_sales_by_date($date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT SUM(data_b2b.VENTAS_B2B) AS ventas FROM data_b2b 
        INNER JOIN data_productos ON data_productos.SKU = data_b2b.SKU 
        WHERE data_b2b.fecha = ? 
        GROUP BY data_productos.SKU ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 

        $this->db->db_close($conn);
        return $result;
    }

    public function get_sales_by_products_date($sku, $date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT SUM(data_b2b.VENTAS_B2B) AS ventas FROM data_b2b 
        INNER JOIN data_productos ON data_productos.SKU = data_b2b.SKU 
        WHERE data_productos.SKU = ? 
        AND 
        data_b2b.fecha = ? ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("is",$sku, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 
        
        $this->db->db_close($conn);
        return $result;
    }

    //-------- load data section ------------------------
    //products & units
    public function get_units_by_date($date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT SUM(data_b2b.UNIDADES) AS units FROM data_b2b 
        INNER JOIN data_productos ON data_productos.SKU = data_b2b.SKU 
        WHERE data_b2b.fecha = ? 
        GROUP BY data_productos.SKU ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 

        $this->db->db_close($conn);
        return $result;
    }

    public function get_units_by_products_date($sku, $date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT SUM(data_b2b.UNIDADES) AS units FROM data_b2b 
        INNER JOIN data_productos ON data_productos.SKU = data_b2b.SKU 
        WHERE data_productos.SKU = ? 
        AND 
        data_b2b.fecha = ? ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("is",$sku, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 
        
        $this->db->db_close($conn);
        return $result;
    }
    //locals & sales
    public function get_locals_by_date($date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT data_locales.ID_LOCAL AS id_local, data_locales.COD_LOCAL AS cod_local, data_locales.LOCAL AS LOCAL 
        FROM data_b2b  
        INNER JOIN data_locales ON data_locales.ID_LOCAL = data_b2b.ID_LOCAL  
        WHERE data_b2b.fecha = ? 
        GROUP BY data_locales.ID_LOCAL ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 

        $this->db->db_close($conn);
        return $result;
    }

    public function get_sales_by_locals_date($id_local, $date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT SUM(data_b2b.VENTAS_B2B) AS ventas FROM data_b2b 
        INNER JOIN data_locales ON data_locales.ID_LOCAL = data_b2b.ID_LOCAL  
        WHERE data_locales.ID_LOCAL = ? 
        AND 
        data_b2b.fecha = ? ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("is",$id_local, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 
        
        $this->db->db_close($conn);
        return $result;
    }
    //locals & units

    public function get_units_by_locals_date($id_local, $date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT SUM(data_b2b.UNIDADES) AS units FROM data_b2b 
        INNER JOIN data_locales ON data_locales.ID_LOCAL = data_b2b.ID_LOCAL  
        WHERE data_locales.ID_LOCAL = ? 
        AND 
        data_b2b.fecha = ? ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("is",$id_local, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 
        
        $this->db->db_close($conn);
        return $result;
    }
    //ejercicio2
    public function get_cadena_sales_by_date($date)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT data_locales.CADENA as cadena, SUM(data_b2b.VENTAS_B2B) AS ventas FROM data_b2b 
        INNER JOIN data_locales ON data_locales.ID_LOCAL = data_b2b.ID_LOCAL  
        WHERE data_b2b.fecha = ? 
        GROUP BY data_locales.CADENA 
        ORDER BY data_locales.CADENA ';

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 

        $this->db->db_close($conn);
        return $result;
    }

    

}

?>