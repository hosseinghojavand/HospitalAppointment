CREATE PROCEDURE create_patient @national_code INTEGER ,@first_name NVARCHAR(32),@last_name NVARCHAR(32), @age INTEGER, @gender INTEGER , @insurance_id INTEGER
AS 
    INSERT INTO Patient (national_code,first_name,last_name,age,gender ,insurance_id)
    VALUES (@national_code,@first_name,@last_name,@age,@gender ,@insurance_id);

-- DROP PROCEDURE create_patient ;
