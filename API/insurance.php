<?php
require 'connect.php' ;
require 'utills.php' ;

class InsuranceModifier{
    private $db = null;
    public function __construct() {
        $this->db = (new DataBaseConnector())->get_connection();
    }

    public function get_all_insurances(){

        $tsql = "EXEC get_all_insurances" ;
        $getResults = sqlsrv_query($this->db,$tsql,array()) ;
        if ($getResults == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        $output = array();
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $obj['id']= $row['ID'];
            $obj['name'] = $row['name'];
            $output[] = $obj;
        }
        sqlsrv_free_stmt($getResults);
        print_output(200 , true , $output);

    }

    public function get_insurance_by_id($id){

        $tsql = "EXEC get_insurance_by_id @id = ?" ;
        $getResults = sqlsrv_query($this->db,$tsql,array($id)) ;
        if ($getResults == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        $output = array();
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $obj['id']= $row['ID'];
            $obj['name'] = $row['name'];
            $output[] = $obj;
        }
        sqlsrv_free_stmt($getResults);
        print_output(200 , true , $output);

    }

    public function create_insurance($id , $name){
        $tsql = "EXEC create_insurance @id = ? , @name =?" ;
        $getResults = sqlsrv_query($this->db,$tsql,array($id , $name)) ;
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE or $rowsAffected == FALSE)
            die(FormatErrors(sqlsrv_errors()));



        // just for handle farsi char that was now supported in sps
        $tsql = "UPDATE insurance set name=(N'" .$name . "') where id =" .$id ;
        $getResults = sqlsrv_query($this->db,$tsql,array()) ;
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE or $rowsAffected == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        print_output(200 , true , $name ." added successfully");

        sqlsrv_free_stmt($getResults);

    }
}


switch ($_SERVER["REQUEST_METHOD"])
{
    case "POST" :
        $id  = $_POST[id] ;
        $name = $_POST[name ] ;

        header('Content-Type: application/json');
        if($name !="" && $id!="" )
            (new InsuranceModifier())->create_insurance($id , $name ) ;
        else
            print_output(400 , false , "no entery");

        break ;
    case "GET" :
        header('Content-Type: application/json');
        if(htmlspecialchars($_GET[id]) == "")
            (new InsuranceModifier())->get_all_insurances();
        else
        {
            if(htmlspecialchars($_GET[id]) != "")
                (new InsuranceModifier())->get_insurance_by_id($_GET[id]);

            else
                print_output(400 , false , "bad entery");
        }

        break ;
}

?>