
CREATE PROCEDURE create_doctor @id INTEGER, @first_name NVARCHAR(MAX),@last_name NVARCHAR(MAX), @speciality_id INTEGER, @extra_info NVARCHAR(MAX), @score INTEGER ,@gender INTEGER , @hospital_id INTEGER , @age INTEGER
AS
    INSERT INTO Doctor (ID,first_name,last_name,speciality_id,extra_info , score ,gender ,hospital_id ,age)
    VALUES (@id,@first_name,@last_name,@speciality_id ,@extra_info , @score ,@gender,@hospital_id ,@age) ;


-- drop PROCEDURE create_doctor