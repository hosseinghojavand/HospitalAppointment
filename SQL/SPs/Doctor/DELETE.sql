CREATE PROCEDURE delete_doctor_by_id @id INTEGER 
AS 
    DELETE FROM Doctor 
    WHERE ID = @id ;

