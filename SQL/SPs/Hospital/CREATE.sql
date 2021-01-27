CREATE PROCEDURE create_hospital @name NVARCHAR(MAX), @city NVARCHAR(MAX),@address NVARCHAR(MAX),@phone NVARCHAR(MAX)
AS
    INSERT INTO Hospital (name,city,address,phone)
    output inserted.ID
    VALUES (@name,@city,@address,@phone)





