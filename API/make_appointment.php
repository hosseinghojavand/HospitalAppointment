<?php

require 'connect.php' ;
require 'utills.php' ;

class AppointmentModifier
{

    private $db = null;
    public function __construct() {
        $this->db = (new DataBaseConnector())->get_connection();
    }

    public function make_appointment($speciality_id ,$week_day , $start_hour , $start_min , $end_hour , $end_min  , $patient_id , $hospital_id , $doctor_id)
    {
        $tsql = "EXEC create_time @speciality_id =?, @week_day =?, @start_hour =?, @start_min =?, @end_hour =? , @end_min =?" ;
        $getResults = sqlsrv_query($this->db,$tsql,array($speciality_id ,$week_day , $start_hour , $start_min , $end_hour , $end_min )) ;
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE or $rowsAffected == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        $id= "";
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $id = $row['ID'];
            echo $id;
        }

        $tsql = "EXEC create_appointment @time_id =? , @speciality_id =?, @patient_id =? ,@hospital_id =? , @doctor_id =?" ;
        $getResults = sqlsrv_query($this->db,$tsql,array($id , $speciality_id ,$patient_id , $hospital_id ,$doctor_id )) ;
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE or $rowsAffected == FALSE)
            die(FormatErrors(sqlsrv_errors()));

        print_output(200 , true , "appointment added successfully");

        sqlsrv_free_stmt($getResults);
    }
}



switch ($_SERVER["REQUEST_METHOD"])
{
    case "POST" :
        $speciality_id = $_POST[speciality_id] ;
        $week_day = $_POST[week_day] ;
        $start_hour = $_POST[start_hour] ;
        $start_min = $_POST[start_min] ;
        $end_hour = $_POST[end_hour] ;
        $end_min = $_POST[end_min] ;
        $patient_id = $_POST[patient_id] ;
        $hospital_id = $_POST[hospital_id] ;
        $doctor_id = $_POST[doctor_id] ;


        header('Content-Type: application/json');
        if($speciality_id !=""&& $week_day !="" && $start_hour !=""&& $start_min !=""  &&
            $end_hour !=""&& $end_min !="" && $patient_id !="" && $hospital_id !="" && $doctor_id !="")
            (new AppointmentModifier())->make_appointment($speciality_id ,$week_day , $start_hour , $start_min , $end_hour , $end_min  , $patient_id, $hospital_id , $doctor_id) ;
        else
            print_output(400 , false , "no entry");

        break ;
}



?>