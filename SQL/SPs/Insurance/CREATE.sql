CREATE PROCEDURE create_insurance @name NVARCHAR(64)
AS 
    INSERT INTO Organization (name) VALUES (@name) ;

-- drop PROCEDURE create_insurance