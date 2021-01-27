<?php
    require 'connect.php' ;
    require 'utills.php' ;

    class DoctorModifier{
        private $db = null;
        public function __construct() {
            $this->db = (new DataBaseConnector())->get_connection();
        }

        public function get_all_doctors(){

            $tsql = "EXEC get_all_doctors" ;
            $getResults = sqlsrv_query($this->db,$tsql,array()) ;
            if ($getResults == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            $output = array();
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                $obj['id']= $row['ID'];
                $obj['first_name'] = $row['first_name'];
                $obj['last_name'] = $row['last_name'];
                $obj['speciality_id'] = $row['speciality_id'];
                $obj['extra_info'] = $row['extra_info'];
                $obj['score'] = $row['speciality_id'];
                $obj['gender'] = $row['gender'];
                $obj['hospital_id'] = $row['hospital_id'];
                $obj['age'] = $row['age'];
                $output[] = $obj;
            }
            sqlsrv_free_stmt($getResults);
            print_output(200 , true , $output);

        }

        public function get_doctor_by_id($id){

            $tsql = "EXEC get_doctor_by_id @id = ?" ;
            $getResults = sqlsrv_query($this->db,$tsql,array($id)) ;
            if ($getResults == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            $output = array();
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                $obj['id']= $row['ID'];
                $obj['first_name'] = $row['first_name'];
                $obj['last_name'] = $row['last_name'];
                $obj['speciality_id'] = $row['speciality_id'];
                $obj['extra_info'] = $row['extra_info'];
                $obj['score'] = $row['speciality_id'];
                $obj['gender'] = $row['gender'];
                $obj['hospital_id'] = $row['hospital_id'];
                $obj['age'] = $row['age'];
                $output[] = $obj;
            }
            sqlsrv_free_stmt($getResults);
            print_output(200 , true , $output);

        }
        public function get_doctor_by_speciality_id($speciality_id){

            $tsql = "EXEC get_doctor_by_speciality_id @speciality_id  = ?" ;
            $getResults = sqlsrv_query($this->db,$tsql,array($speciality_id)) ;
            if ($getResults == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            $output = array();
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                $obj['id']= $row['ID'];
                $obj['first_name'] = $row['first_name'];
                $obj['last_name'] = $row['last_name'];
                $obj['speciality_id'] = $row['speciality_id'];
                $obj['extra_info'] = $row['extra_info'];
                $obj['score'] = $row['speciality_id'];
                $obj['gender'] = $row['gender'];
                $obj['hospital_id'] = $row['hospital_id'];
                $obj['age'] = $row['age'];
                $output[] = $obj;
            }
            sqlsrv_free_stmt($getResults);
            print_output(200 , true , $output);

        }
        public function create_doctor($id , $first_name, $last_name, $speciality_id , $extra_info , $gender ,$hospital_id ,$age ){
            $tsql = "EXEC create_doctor @id =?, @first_name =?,@last_name =?, @speciality_id =?, @extra_info =?, @score =? ,@gender =? , @hospital_id =? , @age =?" ;
            $getResults = sqlsrv_query($this->db,$tsql,array($id , $first_name , $last_name, $speciality_id , $extra_info , 0 , $gender ,$hospital_id ,$age)) ;
            $rowsAffected = sqlsrv_rows_affected($getResults);
            if ($getResults == FALSE or $rowsAffected == FALSE)
                die(FormatErrors(sqlsrv_errors()));


            // just for handle farsi char that was now supported in sps
            $tsql = "UPDATE doctor set first_name=(N'" .$first_name . "') , last_name=(N'" .$last_name."') , extra_info=(N'" .$extra_info. "') where id =" .$id ;
            $getResults = sqlsrv_query($this->db,$tsql,array()) ;
            $rowsAffected = sqlsrv_rows_affected($getResults);
            if ($getResults == FALSE or $rowsAffected == FALSE)
                die(FormatErrors(sqlsrv_errors()));

            print_output(200 , true , $first_name . " " . $last_name." added successfully");

            sqlsrv_free_stmt($getResults);

        }
    }


    switch ($_SERVER["REQUEST_METHOD"]) 
    {
        case "POST" :
            $id  = $_POST[id] ;
            $first_name = $_POST[first_name ] ;
            $last_name = $_POST[last_name] ;
            $speciality_id  = $_POST[speciality_id] ;
            $extra_info  = $_POST[extra_info] ;
            $gender  = $_POST[gender ] ;
            $hospital_id  = $_POST[hospital_id] ;
            $age = $_POST[age] ;

            header('Content-Type: application/json');
            if($id !="" && $first_name!="" && $last_name!="" && $speciality_id !="" && $extra_info!="" && $gender!="" &
                $hospital_id !="" && $age!="")
                (new DoctorModifier())->create_doctor($id , $first_name, $last_name, $speciality_id , $extra_info , $gender ,$hospital_id ,$age ) ;
            else
                print_output(400 , false , "no entery");
            break ;
        case "GET" :
            header('Content-Type: application/json');
            if(htmlspecialchars($_GET[id]) == "" && htmlspecialchars($_GET[speciality_id]) =="")
                (new DoctorModifier())->get_all_doctors();
            else
            {
                if(htmlspecialchars($_GET[id]) != "" && htmlspecialchars($_GET[speciality_id])=="")
                    (new DoctorModifier())->get_doctor_by_id($_GET[id]);
                else if(htmlspecialchars($_GET[id]) == "" && htmlspecialchars($_GET[speciality_id]) != "" )
                    (new DoctorModifier())->get_doctor_by_speciality_id($_GET[speciality_id]);
                else
                    print_output(400 , false , "bad entery");
            }

            break ;
    }

?>