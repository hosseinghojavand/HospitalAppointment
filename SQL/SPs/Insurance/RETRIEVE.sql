CREATE PROCEDURE get_insurance_by_id @id INTEGER
AS
    SELECT * FROM Insurance
    WHERE ID = @id ;

CREATE PROCEDURE get_all_insurances
AS
    SELECT * FROM Insurance ;
