SELECT
pacientes.id, nombre, '' a_paterno,'' a_materno, fecha_registro, sexo, domicilio, '' num_domicilio, '' colonia, cp, '' municipio, estado, '' tel_recados, 
tel_casa, tel_cel, tel_ofi, ext, email, fecha_nacimiento, ocupacion,'' Nombre_titular  ,fecha_apertura, 1
FROM `pacientes`
INNER join contacto_pacientes on pacientes.id = contacto_pacientes.idpaciente


UPDATE `paciente_migra`
JOIN responsables_pacientes on 	paciente_migra.id_paciente responsables_pacientes.idpaciente
SET nombre_titular = responsables_pacientes.nombre_responsable



-- Migra historiales 


SELECT HP.idpaciente, HP.fecha_registro, hp.p1, hp.p2, hp.p3, hp.p4, hp.p5, hp.a1, hp.a2, hp.a3, hp.a4, hp.a5, hp.a6, hp.a7, hp.a8, 
hp.ta, HP.temp, HP.frecc, hp.frecr, hp.peso, hp.talla, hp.e1, hp.e2, hp.e3, hp.e4, hp.e5, hp.e6, hp.e7, 
hp.resultados, hp.diagnosticos, hp.tx1, hp.tx2, hp.tx3, 
'MIGRACION' medico, 1 usario_captura 
FROM historial_pacientes HP INNER JOIN pacientes P ON HP.idpaciente = P.id;


DELETE FROM `historial_pacientes` where idpaciente = 1832 order by id desc limit 1;
select * from historial_pacientes where idpaciente = 1832 order by id DESC;