--IMPORTANTE: Borrar caché de imágenes en servidor

TRUNCATE albumes;
TRUNCATE albumes_det;
DELETE FROM credits WHERE user_id != 1 AND id > 0;
TRUNCATE mensajes;
TRUNCATE mensajes_det;
TRUNCATE mensajes_status;
TRUNCATE notificaciones;
TRUNCATE ofertas;
TRUNCATE oferta_comments;
TRUNCATE proyectos;
TRUNCATE proyecto_fin;
TRUNCATE pro_transactions;
TRUNCATE referrals;
TRUNCATE reviews;
DELETE FROM user WHERE id != 1;
DELETE FROM user_det WHERE id_user != 1 AND id > 0;