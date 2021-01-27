<?php
require 'connect.php' ;
require 'utills.php' ;

class HospitalModifier{
    private $db = null;
    public function __construct() {
        $this->db = (new DataBaseConnector())->get_connection();
    }

    public function get_all_hospitals(){

        $tsql = "EXEC get_all_hospitals" ;
        $getResults = sqlsrv_query($this->db,$tsql,array()) ;
        if ($getResults == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        $output = array();
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $obj['id']= $row['ID'];
            $obj['name'] = $row['name'];
            $obj['city'] = $row['city'];
            $obj['address'] = $row['address'];
            $obj['phone'] = $row['phone'];
            $output[] = $obj;
        }
        sqlsrv_free_stmt($getResults);
        print_output(200 , true , $output);

    }

    public function get_hospital_by_id($id){

        $tsql = "EXEC get_hospital_by_id @id = ?" ;
        $getResults = sqlsrv_query($this->db,$tsql,array($id)) ;
        if ($getResults == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        $output = array();
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $obj['id']= $row['ID'];
            $obj['name'] = $row['name'];
            $obj['city'] = $row['city'];
            $obj['address'] = $row['address'];
            $obj['phone'] = $row['phone'];
            $output[] = $obj;
        }
        sqlsrv_free_stmt($getResults);
        print_output(200 , true , $output);

    }

    public function create_hospital($name , $city, $address, $phone){
        $tsql = "EXEC create_hospital @name =?,@city =?, @address =?, @phone =?" ;
        $getResults = sqlsrv_query($this->db,$tsql,array($name , $city, $address, $phone)) ;
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE or $rowsAffected == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        $id= "";
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $id = $row['ID'];
        }


        // just for handle farsi char that was now supported in sps
        $tsql = "UPDATE hospital set name=(N'" .$name . "') , city=(N'" .$city."') , address=(N'" .$address. "') where id =" .$id ;
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
        $name  = $_POST[name] ;
        $city = $_POST[city ] ;
        $address = $_POST[address] ;
        $phone  = $_POST[phone] ;

        header('Content-Type: application/json');
        if($name !="" && $city!="" && $address!="" && $phone !="" )
            (new HospitalModifier())->create_hospital($name , $city, $address, $phone) ;
        else
            print_output(400 , false , "no entery");

        break ;
    case "GET" :
        header('Content-Type: application/json');
        if(htmlspecialchars($_GET[id]) == "")
            (new HospitalModifier())->get_all_hospitals();
        else
        {
            if(htmlspecialchars($_GET[id]) != "")
                (new HospitalModifier())->get_hospital_by_id($_GET[id]);

            else
                print_output(400 , false , "bad entery");
        }

        break ;
}

?>