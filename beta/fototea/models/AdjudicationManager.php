<?php


namespace Fototea\Models;

/* Must be singleton ?? */
use Fototea\Util\UrlHelper;
use Fototea\Util\DateHelper;
use Fototea\Util\FMailer;
use Fototea\Util\FAnalytics;
use Fototea\Config\FConfig;

class AdjudicationManager {

    public static function adjudicateProject($projectId, $offerId) {

        $userFields = array(User::PROFILE_DIRECTION, User::PROFILE_MOVIL, User::PROFILE_CITY);

        //Load proyect and offer
        $project = Project::loadById($projectId);
        $projectOwner = User::getUserInfo($project->user_id, $userFields);

        if (Project::canBeAdjudicated($project)) {


            $offer = Offer::getOffer($offerId);
            $winner = User::getUserInfo($offer->user_id, $userFields);

            //Set project as adjudicated
            $data = array(
                'pro_status' => Project::PROJECT_STATUS_ADJUDICATED,
                'pro_date_end' => date('Y-m-d H:i:s', time())
            );

            Project::updateProject($project->pro_id, $data);

            //Set offer as winner
            $data = array(
                'awarded' => Offer::STATUS_AWARDED
            );

            Offer::updateOffer($offer->id, $data);

            //Send notificacions and emails
            self::notifyWinner($project, $projectOwner, $winner);

            // Send email to winner
            self::emailWinner($offer, $winner, $project, $projectOwner);

            // Send email to project owner
            self::emailProjectOwner($offer, $winner, $project, $projectOwner);

            // Notifiy other photographers about denied offers. Losers :D
            self::notifyLosers($project);

            //Track event in analytics
            // Event = Proyectos adjudicados
            $eventData = new \stdClass();
            $eventData->user_id = $projectOwner['id'];
            $eventData->photograph_id = $winner['id'];
            $eventData->project_name = $project->pro_tit;
            $events = FAnalytics::getInstance();
            $events->trackEvent('Proyecto', 'Proyectos adjudicados', json_encode($eventData));

        } else {
            //TODO Oh oh... strong notification here about this fail
            return false;
        }

        return true;

    }


    public static function notifyWinner($project, $projectOwner, $winner) {
        // Notify winner photographer about accepted offer.
        $notifyData = new \stdClass;
        $notifyData->project_id = $project->pro_id;
        $notifyMsg = 'Tu oferta para el proyecto '.$project->pro_tit.' ha sido aceptada por '. $projectOwner['full_name'];
        $notifyData = json_encode($notifyData);
        $result = Notification::create($winner['id'], $notifyMsg, Notification::TYPE_PROJECT_AWARDED, $notifyData);

        if ($result) {
            //TODO Log here notification failed
        }
    }


    public static function notifyLosers($project) {
        $deniedOffers = Offer::getOfferByProjectId($project->pro_id, Offer::STATUS_NOT_AWARDED);

        foreach ($deniedOffers as $denied){
            $notifyData = new \stdClass;
            $notifyData->project_id = $project->pro_id;
            $notifyMsg = 'Tu oferta para el proyecto '.$project->pro_tit.' no fue seleccionada';
            $notifyData = json_encode($notifyData);
            $result = Notification::create($denied->user_id, $notifyMsg, Notification::TYPE_DENIED_OFFER, $notifyData);

            if (!$result) {
                //log here
            }
        }
    }

    public static function emailWinner($offer, $winner, $project, $projectOwner) {
        // Enviar correo a fotografo
        $asunto = "Te han adjudicado un proyecto. ¡Felicidades!";

        $params = array(
            'site_url' => UrlHelper::getUrl(),
            'logo_url' => UrlHelper::getUrl('images/logo_footer.png'),
            'check_url' => UrlHelper::getUrl('images/check_green.gif'),
            'oferta_name' => $winner['name'],
            'oferta_lastname' => $winner['lastname'],
            'oferta_winner' => '$ '. number_format($offer->bid,2,",","."),
            'proyecto_titulo' => $project->pro_tit,
            'projecto_date' => DateHelper::getShortDate($project->pro_date),
            'proyecto_url'=> UrlHelper::getProjectUrl($project->pro_id),
            'client_name' => $projectOwner['full_name'],
            'client_email' => $projectOwner['email'],
            'client_phone' => $projectOwner['movil'],
            'client_location' => $projectOwner['ciudad'] .', '. $projectOwner['direccion'],
        );

        $mailer = new FMailer();
        $body = $mailer->replaceParameters($params, file_get_contents(UrlHelper::getBasePath() . '/views/emails/adjudicarProyectosFotografoEmail.html'));
        $mailer = new FMailer();
        $receivers = array(
            array('email' => $winner['email']),
        );
        $mailer->setReceivers($receivers);

        $mailer->setBCC(
            array(
                array('email' => FConfig::getValue('contacto_email')),
            )
        );

        $mailer->sendEmail($asunto, $body);
    }

    public static function emailProjectOwner($offer, $winner, $project, $projectOwner) {
        // Enviar correo a cliente
        $asunto = "Has adjudicado un proyecto. ¡Buen Trabajo!";

        $params = array(
            'site_url' => UrlHelper::getUrl(),
            'logo_url' => UrlHelper::getUrl('images/logo_footer.png'),
            'check_url' => UrlHelper::getUrl('images/check_green.gif'),
            'client_name' => $projectOwner['full_name'],
            'oferta_winner' => $offer->bid,
            'proyecto_titulo' => $project->pro_tit,
            'projecto_date' => DateHelper::getShortDate($project->pro_date),
            'proyecto_url'=> UrlHelper::getProjectUrl($project->pro_id),
            'photograph_name' => $winner['full_name'],
            'photograph_email' => $winner['email'],
            'photograph_phone' => $winner['movil'],
            'photograph_location' => $winner['ciudad'] .', '. $winner['direccion'],
        );

        $mailer = new FMailer();
        $body = $mailer->replaceParameters($params, file_get_contents(UrlHelper::getBasePath() . '/views/emails/adjudicarProyectosClienteEmail.html'));
        $receivers = array(
            array('email' => $projectOwner['email']),
        );
        $mailer->setReceivers($receivers);

        $mailer->setBCC(
            array(
                array('email' => FConfig::getValue('contacto_email')),
            )
        );

        $mailer->sendEmail($asunto, $body);
    }
}