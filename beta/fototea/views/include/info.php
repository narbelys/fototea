<?php

use Fototea\Models\User;

//INFO TAB

//Intereses
$intereses = array();

if ($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER) {
    $list_cat = listAll("categories","ORDER BY categories.order ASC");
    while($rs_cat = mysql_fetch_object($list_cat)){
        //Busco las subcategorias del usuario
        $list_subCat_val = listAll("categories_event e, user_det u", "WHERE id_cat = '$rs_cat->id' AND e.id = u.description AND u.id_data = '15' AND u.id_user = '" . $user_info['id'] . "'  ORDER BY e.description ASC", 'u.description');
        $user_subcats_ids = array();

        while ($rs_subCat = mysql_fetch_object($list_subCat_val)){
            $user_subcats_ids[] = $rs_subCat->description;
        }
        $user_subcats = array();
        //Si hay las muestro
        if (count($user_subcats_ids) > 0) {
            $list_subCat = listAll("categories_event", "WHERE id_cat = '$rs_cat->id' and id IN (" . implode(',', $user_subcats_ids) . ")  ORDER BY description ASC");
            while ($rs_subCat = mysql_fetch_object($list_subCat)) {
                $user_subcats[] = $rs_subCat;
            }
        };
        $rs_cat->user_subcats = $user_subcats;
        $intereses[] = $rs_cat;
    } //end while
}

?>

<h2 class="main-title">
    Datos del Usuario
</h2>

<dl class="user-fields">
    <dt>Nombre: </dt>
    <dd><?php echo $user_info['full_name'] ?></dd>

    <dt>Pais: </dt>
    <dd><?php echo $user_info['pais'] ?></dd>

    <dt>Ciudad: </dt>
    <dd><?php echo $user_info['ciudad'] ?></dd>

    <dt>Género: </dt>
    <dd><?php echo $user_info['sex'] ?></dd>

    <dt>Descripción: </dt>
    <dd><?php echo $user_info['descripcion'] ?></dd>

    <?php if (!empty($user_info['escuela-fotografia'])): ?>
    <dt>Escuela de fotografía: </dt>
    <dd><?php echo $user_info['escuela-fotografia'] ?></dd>
    <?php endif ?>

    <?php if (!empty($user_info['mas-educacion'])): ?>
    <dt>Más educación: </dt>
    <dd><?php echo $user_info['mas-educacion'] ?></dd>
    <?php endif ?>

    <?php if (!empty($user_info['experiencia-laboral'])): ?>
        <dt>Experiencia y proyectos anteriores:</dt>
        <?php foreach($user_info['experiencia-laboral'] as $exp): ?>
            <dd><?php echo $exp->empresa ?>, <?php echo $exp->localidad; ?></dd>
        <?php endforeach ?>
    <?php endif ?>

    <?php if (!empty($user_info['habilidades'])): ?>
        <dt>Habilidades:</dt>
        <?php foreach ($user_info['habilidades'] as $habilidad): ?>
            <dd><?php echo $habilidad ?></dd>
        <?php endforeach ?>
    <?php endif ?>

    <?php if (!empty($user_info['cam'])): ?>
        <dt>Camara:</dt>
        <?php foreach ($user_info['cam'] as $camara): ?>
            <dd><?php echo $camara ?></dd>
        <?php endforeach ?>
    <?php endif ?>

    <?php if (!empty($user_info['lentes'])): ?>
        <dt>Lentes:</dt>
        <?php foreach ($user_info['lentes'] as $lente): ?>
            <dd><?php echo $lente ?></dd>
        <?php endforeach ?>
    <?php endif ?>

    <?php if (!empty($user_info['equip'])): ?>
        <dt>Equipo general:</dt>
        <?php foreach($user_info['equip'] as $equipo): ?>
            <dd><?php echo $equipo ?></dd>
        <?php endforeach ?>
    <?php endif ?>
</dl>

<?php if (count($intereses) > 0): ?>

    <h2 class="main-title">
        Intereses
    </h2>

    <?php foreach ($intereses as $rs_cat) : ?>
        <p><?php echo $rs_cat->description; ?></p>
        <ul class="interest-list">
            <?php foreach ($rs_cat->user_subcats as $rs_subCat): ?>
                <li>- <?php echo $rs_subCat->description; ?></li>
            <?php endforeach ?>
        </ul>
    <?php endforeach ?>
<?php endif ?>