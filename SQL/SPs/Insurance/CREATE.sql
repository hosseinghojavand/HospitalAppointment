CREATE PROCEDURE create_insurance @id INTEGER , @name NVARCHAR(64)
AS 
    INSERT INTO Insurance  (ID , name) VALUES (@id , @name) ;

-- drop PROCEDURE create_insurance