<?php

require '../connect.php' ;
require '../utills.php' ;

class SignInModifier
{
    private $db = null;
    public function __construct() {
        $this->db = (new DataBaseConnector())->get_connection();
    }

    public function sign_in($national_code ,$password )
    {

        $tsql = "select patient_id from Authentication where patient_id ='". $national_code ."' and password ='" . $password ."'";
        $getResults = sqlsrv_query($this->db, $tsql, array());
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE)
            die(FormatErrors(sqlsrv_errors()));


        $result = "";
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $result =  $row['patient_id'];
        }

        if ($result == "")
        {
            print_output(400 , false , "national_code or password is not true");
        }
        else {


            $tsql = "EXEC get_patient_by_id @national_code =?" ;
            $getResults = sqlsrv_query($this->db,$tsql,array($national_code)) ;
            if ($getResults == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            $output = array();
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                $obj['national_code']= $row['national_code'];
                $obj['first_name'] = $row['first_name'];
                $obj['last_name'] = $row['last_name'];
                $obj['age'] = $row['age'];
                $obj['gender'] = $row['gender'];
                $obj['insurance_id'] = $row['insurance_id'];
                $output[] = $obj;
            }
            sqlsrv_free_stmt($getResults);
            print_output(200 , true , $output);
        }
    }
}


switch ($_SERVER["REQUEST_METHOD"])
{
    case "POST" :
        $national_code  = $_POST[national_code] ;
        $password = $_POST[password] ;


        header('Content-Type: application/json');
        if($national_code !=""&& $password !="" )
            (new SignInModifier())->sign_in($national_code  , $password) ;
        else
            print_output(400 , false , "no entry");

        break ;
}


?>