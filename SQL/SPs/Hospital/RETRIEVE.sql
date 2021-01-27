CREATE PROCEDURE get_hospital_by_id @id INTEGER
AS 
    SELECT * FROM Hospital  
    WHERE ID = @id ;


CREATE PROCEDURE get_all_hospitals
AS
    SELECT * FROM Hospital;
