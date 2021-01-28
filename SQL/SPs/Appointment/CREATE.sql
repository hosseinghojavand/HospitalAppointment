CREATE PROCEDURE create_appointment @time_id INTEGER , @speciality_id INTEGER, @patient_id INTEGER ,@hospital_id INTEGER , @doctor_id INTEGER
AS
    INSERT INTO Attendance (time_id,speciality_id,patient_id , hospital_id , doctor_id) VALUES
    (@time_id,@speciality_id,@patient_id ,@hospital_id ,@doctor_id ) ;
