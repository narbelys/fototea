CREATE OR REPLACE ALGORITHM = UNDEFINED VIEW proyectos_view AS
SELECT
  p.*, c.nombre AS pro_country_name,
  COUNT(o.id) AS total_ofertas,
  oa.id       AS oferta_adjudicada_id,
  oa.user_id  AS oferta_user_id,
  oa.bid      AS oferta_bid
FROM proyectos p LEFT JOIN ofertas o
    ON o.pro_id = p.pro_id
  LEFT JOIN ofertas oa
    ON oa.pro_id = p.pro_id AND oa.awarded = 'S'
      JOIN paises c
        ON binary c.iso = binary p.pro_country
GROUP BY p.pro_id;


