SELECT
pacientes.id, nombre, '' a_paterno,'' a_materno, fecha_registro, sexo, domicilio, '' num_domicilio, '' colonia, cp, '' municipio, estado, '' tel_recados, 
tel_casa, tel_cel, tel_ofi, ext, email, fecha_nacimiento, ocupacion,'' Nombre_titular  ,fecha_apertura, 1
FROM `pacientes`
INNER join contacto_pacientes on pacientes.id = contacto_pacientes.idpaciente


UPDATE `paciente_migra`
JOIN responsables_pacientes on 	paciente_migra.id_paciente responsables_pacientes.idpaciente
SET nombre_titular = responsables_pacientes.nombre_responsable



