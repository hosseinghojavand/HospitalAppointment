CREATE PROCEDURE create_speciality @name NVARCHAR(64)
AS
    INSERT INTO Speciality (name)
    output inserted.ID
    VALUES (@name)



