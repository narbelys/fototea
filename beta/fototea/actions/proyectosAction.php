<?php
use Fototea\Config\FConfig;
use Fototea\Models\CategoriesEvent;
use Fototea\Models\Country;
use Fototea\Models\Notification;
use Fototea\Models\Project;
use Fototea\Models\TmpProject;
use Fototea\Models\User;
use Fototea\Models\Category;
use Fototea\Util\DateHelper;
use Fototea\Util\FMailer;
use Fototea\Util\FAnalytics;

require '../vendor/autoload.php';

include_once '../scripts/libSM.php';
$session = validaSession();

$act = $_REQUEST['act'];

if($session != true && $act != 'agregarProyecto'){
    $app->redirect($app->getHelper('UrlHelper')->getUrl('home'));
    return;
}

$currentUser = getCurrentUser();

//agregar proyecto
if($act == "agregarProyecto"){

    /** @var \Fototea\Util\UrlHelper $urlHelper */
    $urlHelper = $app->getHelper('UrlHelper');

    //var_dump($app->getRequest()->file());

    /** @var Symfony\Component\HttpFoundation\File\UploadedFile $proSample */
    $proSample = $app->getRequest()->file('pro_sample');

    $number = 123;

    //$app->getInput()->addError('hola', 'ha ocurrido un error con el campo hola');
    //$app->getInput()->addError('hola2', 'ha ocurrido un error con el campo hola');

    //$userProfilePath = $urlHelper->getUserProfilePath($currentUser->id);

    //$userProfilePath .= 'projects/id_project/';

    //$proSample->move($userProfilePath, 'test.jpg');

    //Validate file size, file type

    //Due to client side compress, this validation probably won't execute
    if (($proSample->getSize() == 0) || (($proSample->getSize()/1024) > FConfig::getValue('maxUploadSize'))){
//        $app_.getI
        $error = true;
    }

    $validTypes = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
    if (!in_array($proSample->getMimeType(), $validTypes)) {
        echo "invalid mime";
        $error = true;
    }

    // INIT - Server side validations
    $error = false;

    $proStatus = $app->getRequest()->post('pro_status');
    if (empty($proStatus) || ($proStatus != Project::PROJECT_STATUS_DRAFT && $proStatus != Project::PROJECT_STATUS_ACTIVE)){
        $error = true;
    }

    $proType = $app->getRequest()->post('pro_type');
    $category = Category::loadCategoryById($proType);
    if (empty($proType) || $category == false){
        $error = true;
    }

    $proTitle = $app->getRequest()->post('pro_title');
    if (empty($proTitle) || strlen($proTitle) < 4 || strlen($proTitle) > 50){
        $error = true;
    }

    $proDescription = $app->getRequest()->post('pro_descripcion');
    if (empty($proDescription) || strlen($proDescription) < 150 || strlen($proDescription) > 500){
        $error = true;
    }

    $proQty = $app->getRequest()->post('pro_quant');
    if (!empty($proQty) && !is_numeric($proQty)){
        $error = true;
    }

    $proLength = $app->getRequest()->post('pro_length');

    $proCategory = $app->getRequest()->post('pro_category');
    if (empty($proCategory)){
        $error = true;
    } else {
        $category->events = CategoriesEvent::getListByCategory($category->id);
        $events = array();
        foreach($category->events as $catEvent){
            $events[] = $catEvent->id;
        }
        if(!in_array($proCategory, $events)){
            $error = true;
        }
    }

    $proDate = $app->getRequest()->post('project_date');
    if (empty($proDate) || DateHelper::validateDate($proDate) == false){
        $error = true;
    }

    $proDireccion = $app->getRequest()->post('pro_direccion');
    if (empty($proDireccion) || strlen($proDireccion) < 6){
        $error = true;
    }

    $proCity = $app->getRequest()->post('pro_city');
    if (empty($proCity) || strlen($proCity) < 4){
        $error = true;
    }

    $proEstado = $app->getRequest()->post('pro_estado');
    if (empty($proEstado) || strlen($proEstado) < 2){
        $error = true;
    }

    $proCp = $app->getRequest()->post('pro_cp');
    if (empty($proCp) || !is_numeric($proCp) || strlen($proCp) < 5){
        $error = true;
    }

    $proPais = $app->getRequest()->post('user_pais');
    if (empty($proPais)){
        $error = true;
    } else {
        $countries = Country::loadCountries();
        $countriesIds = array();
        foreach($countries as $c){
            $countriesIds[] = $c->iso;
        }
        if (!in_array($proPais, $countriesIds)){
            $error = true;
        }
    }

    $proEnvironment = $app->getRequest()->post('pro_environment');
    $proMoment = $app->getRequest()->post('pro_moment');
    $proDeadline = $app->getRequest()->post('pro_deadline');

    if ($error){
        $app->addError("La información suministrada para la creación del proyecto es inválida.");
        $app->getInput()->save(); //flash form data
        $app->redirect($app->getConfig()->getUrl('agregarProyecto'));
        return;
    }

    // END - Server side validations

    // Si esta logueado se continua normal
    if ($session){
        $project = ORM::for_table(Project::getTable())->create();
        $project->set('user_id', $currentUser->id);
        $project->set('pro_status', $proStatus);
    } else {
        // Si el usuario es guest entonces guardar proyecto en tabla temporal
        $project = ORM::for_table(TmpProject::getTable())->create();
        $project->set('pro_tmp_id', sha1(time() . $app->getHelper('StringHelper')->generateRandomString()));
        $project->set('pro_status', Project::PROJECT_STATUS_ACTIVE);
    }

    $project->set('pro_cod', date('ymdHis')); //TODO candidate to be deprecated
    $project->set('pro_tit', ucfirst($proTitle));
    $project->set('pro_descripcion', preg_replace("/\n/","<br/>", $proDescription));
    //$project->set('pro_budget', $_POST['pro_budget']); deprecated

    $projectDate = str_replace('/', '-', $proDate);
    $projectDate = date('Y-m-d H:i:s', strtotime($projectDate));
    $project->set('pro_date', $projectDate);

    $dateEndTime = DateHelper::addDaysToTime(time(), FConfig::getValue("maxDaysToAdjudicate"));
    $project->set('pro_date_end', date('Y-m-d H:i:s', $dateEndTime));
    $project->set('pro_cant', $proQty);
    $project->set('pro_length', $proLength);
    $project->set('pro_country', $proPais);
    $project->set('pro_state', $proEstado);
    $project->set('pro_city', $proCity);
    $project->set('pro_address', $proDireccion);
    $project->set('pro_cp', $proCp);
    $project->set('pro_type', $proType);
    $project->set('pro_category', $proCategory);
    $project->set('pro_environment', $proEnvironment);
    $project->set('pro_moment', $proMoment);
    $proDeadline = str_replace('/', '-', $proDeadline);
    if (!empty($proDeadline)){
        $projectDeadline = date('Y-m-d H:i:s', strtotime($proDeadline));
    }
    $project->set('pro_deadline', $projectDeadline);
    $project->set_expr('pro_cdate', 'NOW()');

    $project->save();

    // If we have project sample file, upload it
    if (($project->id > 0) && ($projectSample != null)){
        $userProfilePath = $urlHelper->getUserProfilePath($currentUser->id);
        $userProfilePath .= 'projects/' . $project->id . '/';
        $proSample->move($userProfilePath, 'test.jpg');
    }

    if ($session){
        // Event: Proyectos subidos
        $eventData = new stdClass();
        $eventData->user_id = $currentUser->id;
        $eventData->project_id = $project->id();
        $eventData->project_name = $project->get('pro_tit');
        $events = FAnalytics::getInstance();
        $events->trackEvent('Proyecto', 'Proyectos subidos', json_encode($eventData));

        $projectUrl = $app->getHelper('UrlHelper')->getProjectUrl($project->id);
        $app->addMessage('Tu proyecto se ha creado con éxito. <a href="{0}">Ir al proyecto</a>', $projectUrl);

        $app->redirect($app->getHelper('UrlHelper')->getUrl("perfil"));
    } else {
        // Guardar el tmp project en cookie y redirigir
        $app->getResponse()->setCookie('guest_project', array('value' => $project->pro_tmp_id, 'expires' => time() + $app->getConfig()->getValue('guest_project_duration')));

        $app->redirect($app->getHelper('UrlHelper')->getUrl("registro?user_type=". User::USER_TYPE_CLIENT));
    }

    return;
}

if ($act == 'testJson') {

    var_dump($app->getModel('Country'));

    //$app->getResponse()->jsonResponse(new stdClass());
}

//editar
if($act == "editarProyecto"){
    //TODO warning posible sql injection here

//    $title = $_REQUEST['pro_title'];
//    $description = preg_replace("/\n/","<br/>",$_REQUEST['pro_descripcion']);
//    $budget = $_REQUEST['pro_budget'];
//    $date = $_REQUEST['pro_year']."-".$_REQUEST['pro_month']."-".$_REQUEST['pro_day'];
//    $dateEnd = sumDayToDate(date("Y-m-d H:i:s"),"15 days");
//    $type = $_REQUEST['pro_type'];
//    $address = $_REQUEST['pro_direccion'];
//    $city = $_REQUEST['pro_city'];
//    $estate = $_REQUEST['pro_estado'];
//    $country = $_REQUEST['pro_pais'];
//    $cp = $_REQUEST['pro_cp'];
//    $length = $_REQUEST['pro_length'];
//    $category = $_REQUEST['pro_category'];
//    $quantity = $_REQUEST['pro_quant'];
//    $userC = $_COOKIE['id'];
//    $status = $_REQUEST['pro_status'];
//    $id_pro = $_REQUEST['pro'];


    // INIT - Server side validations
    $error = false;

    $proId = intval($app->getRequest()->post('pro_id'));

    if (empty($proId)) {
        $error = true;
    }

    $data = array();
    $data["pro_status"] = $app->getRequest()->post('pro_status');
    if (empty($data["pro_status"]) || ($data["pro_status"] != Project::PROJECT_STATUS_DRAFT && $data["pro_status"] != Project::PROJECT_STATUS_ACTIVE)){
        $error = true;
    }

    $data["pro_type"] = intval($app->getRequest()->post('pro_type'));
    $category = Category::loadCategoryById($data["pro_type"]);
    if (empty($data["pro_type"]) || $category == false){
        $error = true;
    }

    $data["pro_tit"] = $app->getRequest()->post('pro_title');
    if (empty($data["pro_tit"]) || strlen($data["pro_tit"]) < 4 || strlen($data["pro_tit"]) > 50){
        $error = true;
    }

    $data["pro_descripcion"] = nl2br($app->getRequest()->post('pro_descripcion'));
    if (empty($data["pro_descripcion"]) || strlen($data["pro_descripcion"]) < 150 || strlen($data["pro_descripcion"]) > 500){
        $error = true;
    }

    $data["pro_cant"] = intval($app->getRequest()->post('pro_quant'));
    if (!empty($data["pro_cant"]) && !is_numeric($data["pro_cant"])){
        $error = true;
    }

    //No required at update
    //$proLength = $app->getRequest()->post('pro_length');

    $data["pro_category"] = intval($app->getRequest()->post('pro_category'));
    if (empty($data["pro_category"])){
        $error = true;
    } else {
        $category->events = CategoriesEvent::getListByCategory($data["pro_type"]);
        $events = array();
        foreach($category->events as $catEvent){
            $events[] = $catEvent->id;
        }
        if(!in_array($data["pro_category"], $events)){
            $error = true;
        }
    }

    $data["pro_date"] = $app->getRequest()->post('project_date');

    if (empty($data["pro_date"]) || DateHelper::validateDate($data["pro_date"]) == false){
        $error = true;
    }

    $data["pro_date"] = str_replace('/', '-', $data["pro_date"]);
    $data["pro_date"] = date('Y-m-d H:i:s', strtotime($data["pro_date"]));

    /* Recalculate project max adjudication date */
    $data["pro_date_end"] = DateHelper::addDaysToTime(time(), $app->getConfig()->getValue('maxDaysToAdjudicate'));
    $data["pro_date_end"] =  date('Y-m-d H:i:s', $data["pro_date_end"]);

    $data["pro_address"] = $app->getRequest()->post('pro_direccion');
    if (empty($data["pro_address"]) || strlen($data["pro_address"]) < 6){
        $error = true;
    }


    $data["pro_city"] = $app->getRequest()->post('pro_city');
    if (empty($data["pro_city"]) || strlen($data["pro_city"]) < 4){
        $error = true;
    }

    $data["pro_state"] = $app->getRequest()->post('pro_estado');
    if (empty($data["pro_state"]) || strlen($data["pro_state"]) < 2){
        $error = true;
    }


    $data["pro_cp"] = $app->getRequest()->post('pro_cp');
    if (empty($data["pro_cp"]) || !is_numeric($data["pro_cp"]) || strlen($data["pro_cp"]) < 5){
        $error = true;
    }

    $data["pro_country"] = $app->getRequest()->post('user_pais');
    if (empty($data["pro_country"])){
        $error = true;
    } else {
        $countries = Country::loadCountries();
        $countriesIds = array();
        foreach($countries as $c){
            $countriesIds[] = $c->iso;
        }
        if (!in_array($data["pro_country"], $countriesIds)){
            $error = true;
        }
    }

    $data['pro_environment'] = $app->getRequest()->post('pro_environment');
    $data['pro_moment'] = $app->getRequest()->post('pro_moment');
    $proDeadline = str_replace('/', '-', $app->getRequest()->post('pro_deadline'));
    if (!empty($proDeadline)){
        $projectDeadline = date('Y-m-d H:i:s', strtotime($proDeadline));
    }
    $data['pro_deadline'] = $projectDeadline;

    if ($error) {
        $app->addError("La información suministrada para la creación del proyecto es inválida.");
        $app->getInput()->save(); //flash form data
        $app->redirect($app->getHelper('UrlHelper')->getUrl('agregarProyecto?id=' . $proId));
        return;
    }

    // END - Server side validations
    $result = Project::updateProject($proId, $data);

    if (!$result) {
        $app->addError("La información suministrada para la creación del proyecto es inválida.");
        $app->getInput()->save(); //flash form data
        $app->redirect($app->getHelper('UrlHelper')->getUrl('agregarProyecto?id=' . $proId));
        return;
    }

    //Success
    $projectUrl = $app->getHelper('UrlHelper')->getProjectUrl($proId);
    $app->addMessage('Tu proyecto se ha guardo con éxito. <a href="{0}">Ir al proyecto</a>', $projectUrl);
    $app->redirect($app->getHelper('UrlHelper')->getUrl("perfil"));
    return;
}

//oferta
if($act == "oferta"){
    $bid = str_replace(",", ".", $_REQUEST['bid']);
    $propuesta = preg_replace("/\n/","<br/>",$_REQUEST['propuesta']);
    $userC = $_COOKIE['id'];
    $pro_id = $_REQUEST['pro'];
    $ad = "N";
    $ins = insertTable("ofertas", "'','$pro_id','$userC','$bid','$propuesta','$ad',NOW()");

    $proj = listAll("proyectos,user","WHERE pro_id = '$pro_id' AND id = user_id");
    $rs_proj = mysql_fetch_object($proj);

    if($ins > 0){
//            $not_user = inser-tTable("notificaciones", "'','$rs_proj->user_id','Has recibido una oferta en el proyecto ".$rs_proj->pro_tit." ','proyecto?id=".$rs_proj->pro_id."',NOW(),'N'");
        $clientUser = getUserInfo($userC);

        $notificationData = new stdClass;
        $notificationData->offer_id = $ins;
        $notificationData->project_id = $pro_id;
        $not_user = Notification::create($rs_proj->user_id, 'Has recibido una nueva oferta de '.$clientUser['full_name'].' en el proyecto '.$rs_proj->pro_tit, Notification::TYPE_OFFER, json_encode($notificationData));

        $to = $rs_proj->user;

        $asunto= "Has recibido una oferta en un proyecto";

        $params = array(
            'site_url' => FConfig::getUrl(),
            'logo_url' => FConfig::getUrl('images/logo_footer.png'),
            'username' => $rs_proj->name.' '.$rs_proj->lastname,
            'project_title' => $rs_proj->pro_tit,
            'project_url' => FConfig::getUrl('proyecto').'?id='.$pro_id,
        );

        $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/hasRecibidoOfertaDeProyectoEmail.html'));

        $mailer = new FMailer();
        $receivers = array(
            array('email' => $to),
        );
        $mailer->setReceivers($receivers);
        $mailer->sendEmail($asunto, $body);

        // Event: Bids recibidos por proyecto
        $eventData = new stdClass();
        $eventData->project_id = $rs_proj->pro_id;
        $eventData->project_name = $rs_proj->pro_tit;
        $events = FAnalytics::getInstance();
        $events->trackEvent('Proyecto', 'Bids recibidos por proyecto', json_encode($eventData));
    }

    $arreglo[] = array('resp' => "Se ha enviado la información");
    echo json_encode($arreglo);

}

if($act == "editarOferta"){

    $request = $app->getRequest();

    //Inline edit This if is for legacy code
    if ($request->post('name')) {

        $id_of = $request->post('pk');

        if ($request->post('name') === "offer_bid") {
            $oferta = floatval($request->post('value'));
        }

        if ($request->post('name') === "offer_description") {
            //TODO revisar esto $propuesta = preg_replace("/\n/","<br/>",$app->getRequest()->post('pro_propuesta'));
            $propuesta = nl2br($request->post('value'));
            //$propuesta = $request->post('value');

        }

    } else {
        //TODO remove legacy code
        $id_of = $request->post('o_id');
        //TODO revisar esto $propuesta = preg_replace("/\n/","<br/>",$app->getRequest()->post('pro_propuesta'));
        $propuesta = nl2br($request->post('pro_propuesta'));
        $oferta = floatval($request->post('pro_oferta'));
    }

    $data = array();

    if (!empty($oferta)){
        $data['bid'] = $oferta;
    }

    if (!empty($propuesta) && ($propuesta != '')) {
        $data['mensaje'] = $propuesta;
    }

    //$id_pro = $request->post('pro'); //proyecto id?? esta en la tabla oferta..


    //var_dump($data);
    //die();

    $id_user = getCurrentUser()->id;

    /** @var \Fototea\Models\Offer $offerModel */
    $offerModel = $app->getModel('Offer');
    $offer = $offerModel->save($id_of, $data);

    $id_pro = $offer->pro_id;

    //$upd_of = updateTable("ofertas", "mensaje = '$propuesta', bid = '$oferta'", "pro_id = '$id_pro' AND id = '$id_of' AND user_id = '$id_user'");

    //if($upd_of){
        $proj = listAll("proyectos,user","WHERE pro_id = '$id_pro' AND id = user_id");
        $rs_proj = mysql_fetch_object($proj);
        $to = $rs_proj->user;
        $user = getUserInfo($_COOKIE['id']);

        $notificationData = new stdClass;
        $notificationData->offer_id = $id_of;
        $notificationData->project_id = $id_pro;
        $not_user = insertTable("notificaciones", "'','$rs_proj->user_id','El usuario ".$user['name']." ".$user['lastname']." ha modificado su oferta en uno de tus proyectos','proyecto?id=".$id_pro."',NOW(),'N', '" . Notification::TYPE_OFFER .  "', '" . json_encode($notificationData) . "'");

        $asunto= "Han modificado una oferta en un proyecto";

        $params = array(
            'site_url' => FConfig::getUrl(),
            'logo_url' => FConfig::getUrl('images/logo_footer.png'),
            'username' => $rs_proj->name.' '.$rs_proj->lastname,
            'oferta_username' => $user['name'].' '.$user['lastname'],
            'project_title' => $rs_proj->pro_tit,
            'project_url' => FConfig::getUrl('proyecto').'?id='.$rs_proj->pro_id,
        );

        $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/modificadaOfertaEnProyectoEmail.html'));

        $mailer = new FMailer();
        $receivers = array(
            array('email' => $to),
        );
        $mailer->setReceivers($receivers);
        $mailer->sendEmail($asunto, $body);
    //}

    $app->getResponse()->jsonResponse($data);
    //$app->redirect($app->getConfig()->getUrl('perfil?act=misproyectos'));
    return;
}

if($act == "cancelar"){
    $pro_id = $_GET['id'];
    $user_id = $_COOKIE['id'];

    updateTable("proyectos", "pro_status = 'C'", "pro_id='$pro_id' AND user_id= '$user_id'");
    $app->redirect($app->getConfig()->getUrl('perfil?act=misproyectos'));
    return;
}


if($act == "adjudicar"){

    //Agregar producto a la session

    /** @var \Fototea\Models\Product $productModel */
    $productModel = $app->getModel('Product');

    $productId = $productModel::PRODUCT_ADJUDICAR_ID;
    $productData = new stdClass();
    $productData->project_id = intval($app->getRequest()->get('pro'));
    $productData->offer_id = intval($app->getRequest()->get('prop'));

    /** @var \Fototea\Models\Offer $offerModel */
    $offerModel = $app->getModel('Offer');
    $offer = $offerModel->getOffer($productData->offer_id);

    //Precio del product adjudicar
    $productPrice = (float) $offer->bid;

    //Add to cart (clear before)
    $app->getCart()->clear();
    $app->getCart()->addItem($productId, $productPrice, json_encode($productData));

    $app->getResponse()->jsonResponse(array('redirect_url' => $app->getHelper('UrlHelper')->getUrl('metodopago')));


    /* Adjudicacion old */
    $id_pro = $_GET['pro'];
    $id_of = $_GET['prop'];
    $user_pro = $_COOKIE['id'];
    $pro = listAll("proyectos","WHERE pro_id = '$id_pro'");
    $rs_pro = mysql_fetch_object($pro);
    //$id_trans = date("ymdHis");

    updateTable("proyectos", "pro_status = 'AD',pro_date_end = NOW()", "pro_id='$id_pro' AND user_id= '$user_pro'");
    updateTable("ofertas", "awarded = 'S'", "pro_id = '$id_pro' AND id = '$id_of'");
    //insertTable("pro_transactions", "'','$id_pro','$id_of','P',NOW(),'',' ','0',' '");

    $oferta = listAll("ofertas,user","WHERE ofertas.id = '$id_of' AND user.id = user_id");
    $rs_oferta = mysql_fetch_object($oferta);

    $proj = listAll("proyectos", "WHERE pro_id = '$id_pro'");
    $rs_proj = mysql_fetch_object($proj);

    $photographUser = getUserInfo($rs_oferta->user_id);
    $clientUser = getUserInfo($user_pro);

    // Notify photographer about accepted offer.
    $notificationData = new stdClass;
    $notificationData->project_id = $rs_proj->pro_id;
    $not_user = Notification::create($rs_oferta->user_id, 'Tu oferta para el proyecto '.$rs_pro->pro_tit.' ha sido aceptada por '.$clientUser['full_name'], Notification::TYPE_PROJECT_AWARDED, json_encode($notificationData));

    // Notifiy other photographers about denied offers.
    $deniedOffers = listAll("ofertas","WHERE pro_id = ".$rs_pro->pro_id." AND user_id != ". $rs_oferta->user_id);

    while($denied = mysql_fetch_object($deniedOffers)){
        $notificationData = new stdClass;
        $notificationData->project_id = $rs_proj->pro_id;
        $not_user = Notification::create($denied->user_id, 'Tu oferta para el proyecto '.$rs_pro->pro_tit.' no fue seleccionada', Notification::TYPE_DENIED_OFFER, json_encode($notificationData));
    }

    // Enviar correo a fotografo
    $asunto = "Te han adjudicado un proyecto. ¡Felicidades!";

    $params = array(
                    'site_url' => FConfig::getUrl(),
                    'logo_url' => FConfig::getUrl('images/logo_footer.png'),
                    'check_url' => FConfig::getUrl('images/check_green.gif'),
                    'oferta_name' => $rs_oferta->name,
                    'oferta_lastname' => $rs_oferta->lastname,
                    'oferta_winner' => '$ '. number_format($rs_oferta->bid,2,",","."),
                    'proyecto_titulo' => $rs_proj->pro_tit,
                    'projecto_date' => DateHelper::getShortDate($rs_proj->pro_date),
                    'proyecto_url'=> FConfig::getUrl('proyecto').'?id='.$id_pr,
                    'client_name' => $clientUser['name']. ' '. $clientUser['lastname'],
                    'client_email' => $clientUser['email'],
                    'client_phone' => $clientUser['movil'],
                    'client_location' => $clientUser['ciudad'] .', '. $clientUser['direccion'],
                );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/adjudicarProyectosFotografoEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $rs_oferta->user),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    // Enviar correo a cliente
    $asunto = "Has adjudicado un proyecto. ¡Buen Trabajo!";

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'check_url' => FConfig::getUrl('images/check_green.gif'),
        'client_name' => $clientUser['name']. ' '. $clientUser['lastname'],
        'oferta_winner' => $rs_oferta->bid,
        'proyecto_titulo' => $rs_proj->pro_tit,
        'projecto_date' => DateHelper::getShortDate($rs_proj->pro_date),
        'proyecto_url'=> FConfig::getUrl('proyecto').'?id='.$id_pr,
        'photograph_name' => $photographUser['name']. ' '. $photographUser['lastname'],
        'photograph_email' => $photographUser['email'],
        'photograph_phone' => $photographUser['movil'],
        'photograph_location' => $photographUser['ciudad'] .', '. $photographUser['direccion'],
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/adjudicarProyectosClienteEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $clientUser['email']),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    // Event = Proyectos adjudicados
    $eventData = new stdClass();
    $eventData->user_id = $user_pro;
    $eventData->photograph_id = $photographUser['id'];
    $eventData->project_name = $rs_proj->pro_tit;
    $events = FAnalytics::getInstance();
    $events->trackEvent('Proyecto', 'Proyectos adjudicados', json_encode($eventData));

    $arreglo[] = array('resp' => "Se ha enviado la información");
    echo json_encode($arreglo);

}

if($act == "finalizar"){

    /* Cambiar el estus del proyecto a FC y FF */
    $current_user = getCurrentUser();
    $us_id = $_GET['us'];
    $us_info = getUserInfo($us_id);
    $type_us = $_GET['us_type'];
    $comment = preg_replace("/\n/","<br/>",$_GET['comment']);
    $finish = $_GET['finish'];
    $pro_id = $_GET['pro'];

    // guardar status fin del usuario
    insertTable("proyecto_fin", "'','$pro_id','$current_user->id','S',NOW()");
    $vp=0;
    $vp2=0;

//		$val_pro = listAll("proyecto_fin", "WHERE pf_pro_id = '$pro_id' AND pf_status = 'S' AND (pf_user_id = '$us_id' OR pf_user_id = '$_COOKIE[id]')");
//		while($rs_valP = mysql_fetch_object($val_pro)){
//		if($rs_valP->pf_user_id == $us_id){
//			$vp++;
//		}else if($rs_valP->pf_user_id == $_COOKIE['id']){
//			$vp2++;
//		}
//		}

    // si el proyecto ya ha sido finalizado por los 2 usuarios entonces se continua con {
//		if($vp >=1 && $vp2 >=1){
        //actualizar estado del proyecto

        if ($current_user->user_type == User::USER_TYPE_CLIENT) {
            $status = Project::PROJECT_STATUS_CLOSED_CLIENT;
        } else {
            $status = Project::PROJECT_STATUS_CLOSED_PHOTOGRAPHER;
        }

//          $status = Project::PROJECT_STATUS_CLOSED_CLIENT;

        updateTable("proyectos", "pro_status = '" . $status . "',pro_date_end = NOW()", "pro_id='$pro_id'");

        if ($status == Project::PROJECT_STATUS_CLOSED_CLIENT) {

            updateTable("proyectos", "pro_status = '" . $status . "',pro_date_end = NOW()", "pro_id='$pro_id'");

            //actualizar la transaccion del proyecto pasar a pago liberado y poner la fecha del pago
            updateTable("pro_transactions", "t_status = 'L', t_pdate = NOW()", "t_pro_id = '$pro_id'");
        } else {
            updateTable("proyectos", "pro_status = '" . $status . "'", "pro_id='$pro_id'");
        }
//		}
        //guardar los datos del review
        //verifica el tipo de review
        if($type_us == "1"){
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','CO','$comment',NOW()");
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','F','$finish',NOW()");
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','C','$_REQUEST[cal]',NOW()");
        }elseif($type_us =="2"){
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','CO','$comment',NOW()");
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','F','$finish',NOW()");

            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','CA','$_REQUEST[calidad]',NOW()");
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','T','$_REQUEST[trato]',NOW()");
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','P','$_REQUEST[puntual]',NOW()");
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','R','$_REQUEST[resp]',NOW()");
            insertTable("reviews", "'','$pro_id','$us_id','$_COOKIE[id]','PR','$_REQUEST[prof]',NOW()");
        }

        $pro = listAll("proyectos","WHERE pro_id = '$pro_id'");
        $rs_pro = mysql_fetch_object($pro);

    //enviar notificacion a la contraparte

        $not_user = insertTable("notificaciones", "'','$us_info[id]','Has sido calificado por el proyecto ".$rs_pro->pro_tit."','perfil?us=".$us_info['act_code']."&act=reviews',NOW(),'N'");



    $to = $us_info['email'];

    $asunto= "Has recibido una calificacion de un usuario";

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'username' => $us_info['name'].' '.$us_info['lastname'],
        'project_title' => $rs_pro->pro_tit,
        'projects_url' => FConfig::getUrl('perfil?act=misproyectos'),
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/recibidoCalificacionDeUsuarioEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    $arreglo[] = array('resp' => "Se ha enviado la información");
    echo json_encode($arreglo);

}

//update bid
if($act == "upt_bid"){

    $oferta = listAll("ofertas", "WHERE id = $_REQUEST[o_id]");
    $rs_oferta = mysql_fetch_object($oferta);
    $old_bid = $rs_oferta->bid;
    $new_bid = $_REQUEST['bid'];
    if($rs_oferta->bid != $new_bid){

        $bid =	updateTable("ofertas", "bid='$_REQUEST[bid]'", "id=$_REQUEST[o_id]");

        if($bid){
            $proj = listAll("proyectos,user,ofertas","WHERE proyectos.pro_id = ofertas.pro_id AND user.id = proyectos.user_id");
            $rs_proj = mysql_fetch_object($proj);
            $to = $rs_proj->user;
            $user = getUserInfo($_COOKIE['id']);
            $pro_not = listAll("proyectos"," WHERE pro_id = '$rs_oferta->pro_id'");
            $rs_pro_not = mysql_fetch_object($pro_not);

            $notificationData = new stdClass;
            $notificationData->offer_id = $rs_oferta->id;
            $notificationData->project_id = $rs_oferta->pro_id;
            if ($new_bid < $old_bid){
                $not_user = Notification::create($rs_pro_not->user_id, $user['full_name'].' ha reducido el precio de su oferta en el proyecto '.$rs_pro_not->pro_tit.' - ¡Revisalo!', Notification::TYPE_MODIFIED_OFFER, json_encode($notificationData));
            } else {
                $not_user = Notification::create($rs_pro_not->user_id, $user['full_name'].' ha modificado el precio de su oferta en el proyecto '.$rs_pro_not->pro_tit, Notification::TYPE_MODIFIED_OFFER, json_encode($notificationData));
            }

            $asunto= "Han modificado una oferta en un proyecto";

            $params = array(
                'site_url' => FConfig::getUrl(),
                'logo_url' => FConfig::getUrl('images/logo_footer.png'),
                'username' => $rs_proj->name.' '.$rs_proj->lastname,
                'oferta_username' => $user['name'].' '.$user['lastname'],
                'project_title' => $rs_proj->pro_tit,
                'project_url' => $rs_proj->pro_tit,
            );

            $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/modificadaOfertaEnProyectoEmail.html'));

            $mailer = new FMailer();
            $receivers = array(
                array('email' => $to),
            );
            $mailer->setReceivers($receivers);
            $mailer->sendEmail($asunto, $body);

        }
    }
    $arreglo[] = array('resp' => "Se ha enviado la información");
    echo json_encode($arreglo);
}

//comentario en  bid
if($act == "comentarioOferta"){
    //TODO Warning posible sql inyection

    $offerId = intval($_REQUEST['o_id']);
    $currentUser = getCurrentUser();

    insertTable("oferta_comments", "'',$offerId, $currentUser->id,'".$_REQUEST['comment']."',NOW()");
    $commentId = mysql_insert_id();

    //usuario que oferto
    $user_of = listAll("ofertas", "WHERE id = $_REQUEST[o_id]");
    $rs_user_of = mysql_fetch_object($user_of);
    $us_of = getUserInfo($rs_user_of->user_id);

    //usuario que posteo el proyecto

    $user_pro = listAll("proyectos", "WHERE pro_id = $rs_user_of->pro_id");
    $rs_user_pro = mysql_fetch_object($user_pro);
    $us_pro = getUserInfo($rs_user_pro->user_id); //cliente


    //TODO use Notification model to abstract this logic
    //Begin notification
    //Json data to know what to do with this notification
    $notificationData = new stdClass;
    $notificationData->offer_id = $offerId;
    $notificationData->comment_id = $commentId;
    $notificationData->project_id = $rs_user_of->pro_id;


    //TODO sin comentarios!! email, notificaciones todo mezclado, los if $_cookie, rehacer todo piedad!!!
    if($_COOKIE['id'] == $rs_user_of->user_id){
        //SI es el cliente
        $completeName = $us_of['full_name'];
        $to = $us_pro['email'];
        $asunto = "Has recibido un comentario en una oferta";
        $mailCont = '</strong> ha comentado en su oferta, en el proyecto "<span style="color:#cc6600; font-weight:bold;">'.$rs_user_pro->pro_tit.'</span>". Para ver el comentario haz click <a href="'.FConfig::getUrl('proyecto').'?id='.$rs_user_pro->pro_id.'" target="_blank">aquí</a>.';
        $not_user = Notification::create($us_pro['id'], 'Has recibido un mensaje de '.$completeName, Notification::TYPE_COMMENT, json_encode($notificationData));
    }else if($_COOKIE['id'] == $rs_user_pro->user_id){
        $completeName = $us_pro['full_name'];
        $to = $us_of['email'];
        $asunto = "Has recibido un comentario en una de tus ofertas";
        $mailCont = '</strong> ha comentado en tu oferta, en el proyecto "<span style="color:#cc6600; font-weight:bold;">'.$rs_user_pro->pro_tit.'</span>". Para ver el comentario haz click <a href="'.FConfig::getUrl('proyecto').'?id='.$rs_user_pro->pro_id.'" target="_blank">aquí</a>.';
        $not_user = Notification::create($us_of['id'], 'Has recibido un mensaje de '.$completeName, Notification::TYPE_COMMENT, json_encode($notificationData));
    }

    //End notification

    $sender_us = getUserInfo($_COOKIE['id']);

    $params = array(
        'site_url' => FConfig::getUrl('site_url'),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'user_name' => $completeName,
        'comment_name' => $sender_us['name'].' '.$sender_us['lastname'],
        'content' => $mailCont,
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/comentarioOfertaEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    $arreglo[] = array('resp' => "Se ha enviado la información");
    echo json_encode($arreglo);

}

if($act == "validarPago"){
    $pro_id = $_REQUEST['pro_id'];
    $oferta_id = $_REQUEST['oferta_id'];

    $oferta = listAll("pro_transactions", "WHERE t_oferta_id = '$oferta_id' AND t_pro_id = '$pro_id' AND t_status = 'L'");
    $row = mysql_num_rows($oferta);

    if($row > 0){
        $arreglo[] = array('resp' => "true");
    } else {
        $arreglo[] = array('resp' => "false");
    }

    echo json_encode($arreglo);
}

?>