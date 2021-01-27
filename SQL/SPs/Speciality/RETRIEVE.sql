CREATE PROCEDURE get_speciality_by_id @id INTEGER
AS
    SELECT * FROM Speciality
    WHERE ID = @id ;


CREATE PROCEDURE get_all_specialities
AS
    SELECT * FROM Speciality ;
