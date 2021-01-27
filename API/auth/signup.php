<?php

require '../connect.php' ;
require '../utills.php' ;

class SignUpModifier
{
    private $db = null;
    public function __construct() {
        $this->db = (new DataBaseConnector())->get_connection();
    }

    public function sign_up($national_code ,$password , $first_name, $last_name, $age ,$gender,$insurance_id)
    {

        $tsql = "EXEC get_patient_by_id @national_code =?" ;
        $getResults = sqlsrv_query($this->db,$tsql,array($national_code)) ;
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE)
            die(FormatErrors(sqlsrv_errors()));


        if ($rowsAffected == -1)
        {
            print_output(400 , false , $first_name." ". $last_name ." is signed_up");
        }
        else {

            $tsql = "EXEC create_patient @national_code =? ,@first_name =?,@last_name =?, @age =?, @gender =? , @insurance_id =?";
            $getResults = sqlsrv_query($this->db, $tsql, array($national_code, $first_name, $last_name, $age, $gender, $insurance_id));
            $rowsAffected = sqlsrv_rows_affected($getResults);
            if ($getResults == FALSE or $rowsAffected == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            sqlsrv_free_stmt($getResults);

            // just for handle farsi char that was now supported in sps
            $tsql = "UPDATE Patient set first_name=(N'" . $first_name . "') , last_name=(N'" . $last_name . "') where national_code =" . $national_code;
            $getResults = sqlsrv_query($this->db, $tsql, array());
            $rowsAffected = sqlsrv_rows_affected($getResults);
            if ($getResults == FALSE or $rowsAffected == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            sqlsrv_free_stmt($getResults);

            $tsql = "insert into Authentication (patient_id , password) values ('" . $national_code . "','" . $password . "')";
            $getResults = sqlsrv_query($this->db, $tsql, array());
            $rowsAffected = sqlsrv_rows_affected($getResults);
            if ($getResults == FALSE or $rowsAffected == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            print_output(200, true, $first_name . " " . $last_name . " added successfully");

            sqlsrv_free_stmt($getResults);
        }
    }
}


switch ($_SERVER["REQUEST_METHOD"])
{
    case "POST" :
        $national_code  = $_POST[national_code] ;
        $password = $_POST[password] ;
        $first_name = $_POST[first_name] ;
        $last_name = $_POST[last_name] ;
        $age  = $_POST[age] ;
        $gender  = $_POST[gender] ;
        $insurance_id  = $_POST[insurance_id] ;

        header('Content-Type: application/json');
        if($national_code !=""&& $password !="" && $first_name!="" && $last_name!="" && $age !="" && $gender !="" && $insurance_id !="" )
            (new SignUpModifier())->sign_up($national_code  , $password, $first_name, $last_name, $age ,$gender,$insurance_id) ;
        else
            print_output(400 , false , "no entry");

        break ;
}


?>