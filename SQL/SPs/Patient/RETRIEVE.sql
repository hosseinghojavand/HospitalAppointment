CREATE PROCEDURE get_patient_by_id @national_code INTEGER
AS 
    SELECT * FROM Patient
    WHERE national_code = @national_code ;
