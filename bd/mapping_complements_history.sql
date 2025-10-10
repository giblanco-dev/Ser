-- CAMBIAR EL TIMESTAMP DE LA TABLA rec_complementos del campo fecha registro
INSERT INTO rec_complementos(id_complemento, id_cita, id_regsuero, user_registra, fecha_registro)
SELECT comp1 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro  FROM rec_sueros_old WHERE comp1 <> 0
UNION ALL
SELECT comp2 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp2 <> 0
UNION ALL
SELECT comp3 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp3 <> 0
UNION ALL
SELECT comp4 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp4 <> 0
UNION ALL
SELECT comp5 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp5 <> 0
UNION ALL
SELECT comp6 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp6 <> 0
UNION ALL
SELECT comp7 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp7 <> 0
UNION ALL
SELECT comp8 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp8 <> 0
UNION ALL
SELECT comp9 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp9 <> 0
UNION ALL
SELECT comp10 AS id_complemento, id_cita, id_registro AS id_regsuero, user_registra, fecha_registro FROM rec_sueros_old WHERE comp10 <> 0
ORDER BY id_cita, id_regsuero