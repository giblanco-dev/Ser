-- **** QUERY COMPLETO
SELECT cita.id_cita, cita.id_paciente, cita.medico, cita.fecha, cita.horario, cita.tipo, 
paciente.nombres, paciente.a_paterno, paciente.a_materno,
user.nombre, user.apellido,
tipos_cita.descrip_cita,
consulta.ta, consulta.temp, consulta.fre_c, consulta.fre_r, consulta.peso, consulta.talla
FROM cita
INNER JOIN paciente on cita.id_paciente = paciente.id_paciente
INNER JOIN user ON cita.medico = user.id
INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
LEFT JOIN consulta ON cita.id_cita = consulta.id_cita
WHERE cita.id_cita = 71

--> QUERY normalizado

SELECT cita.id_cita, cita.fecha, cita.horario, 
paciente.nombres, paciente.a_paterno, paciente.a_materno,
user.nombre, user.apellido,
tipos_cita.descrip_cita,
consulta.ta, consulta.temp, consulta.fre_c, consulta.fre_r, consulta.peso, consulta.talla
FROM cita
INNER JOIN paciente on cita.id_paciente = paciente.id_paciente
INNER JOIN user ON cita.medico = user.id
INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
LEFT JOIN consulta ON cita.id_cita = consulta.id_cita
WHERE CITA.id_cita = 71