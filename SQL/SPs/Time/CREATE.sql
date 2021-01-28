CREATE PROCEDURE create_time @speciality_id INTEGER, @week_day INTEGER, @start_hour INTEGER, @start_min INTEGER, @end_hour INTEGER , @end_min INTEGER
AS
    INSERT INTO Time (speciality_id,week_day,start_hour,start_min , end_hour,end_min )
    OUTPUT inserted.ID 
    VALUES (@speciality_id,@week_day,@start_hour,@start_min , @end_hour,@end_min) ;


