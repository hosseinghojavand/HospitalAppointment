CREATE PROCEDURE get_doctor_by_id @id INTEGER
AS 
    SELECT * FROM Doctor
    WHERE ID = @id ;
GO ;

CREATE PROCEDURE get_doctor_by_speciality_id @speciality_id INTEGER
AS  
    SELECT * FROM Doctor
    WHERE speciality_id=@speciality_id;
GO ;

CREATE PROCEDURE get_all_doctors
AS
    SELECT * FROM Doctor;
GO ;



