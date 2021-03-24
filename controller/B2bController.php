<?php
  require_once('../model/B2bModel.php');
  class B2bController{
    private $b2b; 
    private $dates;
    function __construct(){
      $this->b2b = new B2bModel();
      $this->dates = array('2019-01-07','2019-01-08','2019-01-09','2019-01-10','2019-01-11','2019-01-12','2019-01-13');
    }

    public function load_data(){
        $group_by = $_POST['group_by'];
        $display_by = $_POST['display_by'];

        if($group_by == 1 && $display_by == 1){
            //products & sales
            $this->get_sales_by_products();
        }
        else if($group_by == 1 && $display_by == 2){
            //products & units
            $this->get_units_by_products();
        }
        else if($group_by == 2 && $display_by == 1){
            //locals & sales
            $this->get_sales_by_locals();
        }
        else if($group_by == 2 && $display_by == 2){
            //locals & units
            $this->get_units_by_locals();
        }
        else
        {
            //cadena x date x sales
            $this->get_cadena_sales_by_date();
        }
    }

    public function get_sales_by_products(){
        $products = array();
        $totals = array();
        
        foreach($this->dates as $date){
            $temp = 0;
            $res_totals = $this->b2b->get_sales_by_date($date);
            $res_products = $this->b2b->get_products_by_date($date);

            while ($col = mysqli_fetch_array($res_products)){   
                if(!in_array(array($col['sku'] => $col['nombre']), $products)){
                    array_push($products, array($col['sku'] => $col['nombre']));
                }
            }

            while ($col = mysqli_fetch_array($res_totals)){   
                $temp += intval(trim($col['ventas']));
            }

            array_push($totals, $temp);
        }
        
        //tbody
        $tbody = '';
        for($i=0; $i < count($products); $i++){
            $tbody .= '<tr>';
            foreach($products[$i] as $key => $value){
                $tbody .= '<td class="td-product">';
                $tbody .= $key.' '.$value;
                $tbody .= '</td>';
                for($j = 0; $j < count($this->dates); $j++){
                    $temp_sales_by_product = 0;
                    $sales_by_prod_date = $this->b2b->get_sales_by_products_date($key, $this->dates[$j]);
                    while ($col = mysqli_fetch_array($sales_by_prod_date)){   
                        $temp_sales_by_product += intval(trim($col['ventas']));
                    }

                    $tbody .= '<td align="center">';
                    $tbody .= '$ '.$temp_sales_by_product;
                    $tbody .= '</td>';
                }
            } 
            $tbody .= '</tr>';
        }

        //tfoot
        $tfoot = '<tr>';
        $tfoot .= '<td><b>TOTAL: </b></td>';
        foreach($totals as $t){
            $tfoot .= '<td align="center"><b>';
            $tfoot .= '$ '.$t;
            $tfoot .= '</b></td>';
        }
        $tfoot .= '</tr>';

        //response
        $response = array(
            'tbody' => $tbody,
            'tfoot' => $tfoot
        );

        echo json_encode($response);
    }
    //----------------------------------------------------
    public function get_units_by_products(){
        $products = array();
        $units = array();
        
        foreach($this->dates as $date){
            $temp = 0;
            $res_totals = $this->b2b->get_units_by_date($date);
            $res_products = $this->b2b->get_products_by_date($date);

            while ($col = mysqli_fetch_array($res_products)){   
                if(!in_array(array($col['sku'] => $col['nombre']), $products)){
                    array_push($products, array($col['sku'] => $col['nombre']));
                }
            }

            while ($col = mysqli_fetch_array($res_totals)){   
                $temp += intval(trim($col['units']));
            }

            array_push($units, $temp);
        }
        
        //tbody
        $tbody = '';
        for($i=0; $i < count($products); $i++){
            $tbody .= '<tr>';
            foreach($products[$i] as $key => $value){
                $tbody .= '<td class="td-product">';
                $tbody .= $key.' '.$value;
                $tbody .= '</td>';
                for($j = 0; $j < count($this->dates); $j++){
                    $temp_units_by_product = 0;
                    $units_by_prod_date = $this->b2b->get_units_by_products_date($key, $this->dates[$j]);
                    while ($col = mysqli_fetch_array($units_by_prod_date)){   
                        $temp_units_by_product += intval(trim($col['units']));
                    }

                    $tbody .= '<td align="center">';
                    $tbody .= $temp_units_by_product;
                    $tbody .= '</td>';
                }
            } 
            $tbody .= '</tr>';
        }

        //tfoot
        $tfoot = '<tr>';
        $tfoot .= '<td><b>TOTAL: </b></td>';
        foreach($units as $t){
            $tfoot .= '<td align="center"><b>';
            $tfoot .= $t;
            $tfoot .= '</b></td>';
        }
        $tfoot .= '</tr>';

        //response
        $response = array(
            'tbody' => $tbody,
            'tfoot' => $tfoot
        );

        echo json_encode($response);
    }
    //---------------------------
    public function get_sales_by_locals(){
        $locals = array();
        $totals = array();
        
        foreach($this->dates as $date){
            $temp = 0;
            $res_totals = $this->b2b->get_sales_by_date($date);
            $res_locals = $this->b2b->get_locals_by_date($date);

            while ($col = mysqli_fetch_array($res_locals)){   
                if(!in_array(array($col['id_local'] => $col['cod_local'].' | '.$col['LOCAL']), $locals)){
                    array_push($locals, array($col['id_local'] => $col['cod_local'].' | '.$col['LOCAL']));
                }
            }

            while ($col = mysqli_fetch_array($res_totals)){   
                $temp += intval(trim($col['ventas']));
            }

            array_push($totals, $temp);
        }
        
        //tbody
        $tbody = '';
        for($i=0; $i < count($locals); $i++){
            $tbody .= '<tr>';
            foreach($locals[$i] as $key => $value){
                $tbody .= '<td class="td-product">';
                $tbody .= $value;
                $tbody .= '</td>';
                for($j = 0; $j < count($this->dates); $j++){
                    $temp_sales_by_local = 0;
                    $sales_by_local_date = $this->b2b->get_sales_by_locals_date($key, $this->dates[$j]);
                    while ($col = mysqli_fetch_array($sales_by_local_date)){   
                        $temp_sales_by_local += intval(trim($col['ventas']));
                    }

                    $tbody .= '<td align="center">';
                    $tbody .= '$ '.$temp_sales_by_local;
                    $tbody .= '</td>';
                }
            } 
            $tbody .= '</tr>';
        }

        //tfoot
        $tfoot = '<tr>';
        $tfoot .= '<td><b>TOTAL: </b></td>';
        foreach($totals as $t){
            $tfoot .= '<td align="center"><b>';
            $tfoot .= '$ '.$t;
            $tfoot .= '</b></td>';
        }
        $tfoot .= '</tr>';

        //response
        $response = array(
            'tbody' => $tbody,
            'tfoot' => $tfoot
        );

        echo json_encode($response);
    }
    //------------------------------
    public function get_units_by_locals(){
        $locals = array();
        $units = array();
        
        foreach($this->dates as $date){
            $temp = 0;
            $res_units = $this->b2b->get_units_by_date($date);
            $res_locals = $this->b2b->get_locals_by_date($date);

            while ($col = mysqli_fetch_array($res_locals)){   
                if(!in_array(array($col['id_local'] => $col['cod_local'].' | '.$col['LOCAL']), $locals)){
                    array_push($locals, array($col['id_local'] => $col['cod_local'].' | '.$col['LOCAL']));
                }
            }

            while ($col = mysqli_fetch_array($res_units)){   
                $temp += intval(trim($col['units']));
            }

            array_push($units, $temp);
        }
        
        //tbody
        $tbody = '';
        for($i=0; $i < count($locals); $i++){
            $tbody .= '<tr>';
            foreach($locals[$i] as $key => $value){
                $tbody .= '<td class="td-product">';
                $tbody .= $value;
                $tbody .= '</td>';
                for($j = 0; $j < count($this->dates); $j++){
                    $temp_units_by_local = 0;
                    $units_by_local_date = $this->b2b->get_units_by_locals_date($key, $this->dates[$j]);
                    while ($col = mysqli_fetch_array($units_by_local_date)){   
                        $temp_units_by_local += intval(trim($col['units']));
                    }

                    $tbody .= '<td align="center">';
                    $tbody .= $temp_units_by_local;
                    $tbody .= '</td>';
                }
            } 
            $tbody .= '</tr>';
        }

        //tfoot
        $tfoot = '<tr>';
        $tfoot .= '<td><b>TOTAL: </b></td>';
        foreach($units as $t){
            $tfoot .= '<td align="center"><b>';
            $tfoot .= $t;
            $tfoot .= '</b></td>';
        }
        $tfoot .= '</tr>';

        //response
        $response = array(
            'tbody' => $tbody,
            'tfoot' => $tfoot
        );

        echo json_encode($response);
    }

    //ejercicio 2
    public function get_cadena_sales_by_date()
    {
        $cadenas = array();
        $sales = array();

        foreach($this->dates as $date)
        {
            $res = $this->b2b->get_cadena_sales_by_date($date);

            while ($col = mysqli_fetch_array($res)){   

                $sale = intval(trim($col['ventas']));
                $day = $date;
                $cadena = trim($col['cadena']);

                array_push($cadenas, $cadena);
                array_push($sales, $sale);

            }
        }

        $response = array(
            'cadenas' => $cadenas,
            'sales' => $sales
        );

        echo json_encode($response);
    }
}
?>