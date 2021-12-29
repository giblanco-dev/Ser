SELECT SUM(caja.abono) Monto, cita.tipo, tipos_cita.descrip_cita FROM   caja
INNER JOIN cita on caja.id_cita = cita.id_cita
INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
where id_cobro IN (41,42,43)
AND cita.tipo = 0

--Dental
SELECT SUM(caja.abono) Monto, cita.tipo, tipos_cita.descrip_cita FROM   caja
INNER JOIN cita on caja.id_cita = cita.id_cita
INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
where id_cobro IN (41,42,43)
AND cita.tipo = 90

--Factor de Crecimiento
SELECT SUM(caja.abono) Monto, cita.tipo, tipos_cita.descrip_cita FROM   caja
INNER JOIN cita on caja.id_cita = cita.id_cita
INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
where id_cobro IN (41,42,43)
AND cita.tipo = 91

--Pellet
SELECT SUM(caja.abono) Monto, cita.tipo, tipos_cita.descrip_cita FROM   caja
INNER JOIN cita on caja.id_cita = cita.id_cita
INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
where id_cobro IN (41,42,43)
AND cita.tipo = 92

--Nutrientes y Medicamentos Orales
SELECT SUM(caja.total_orales) MontoOrales FROM caja WHERE id_cobro in (41,42,43)