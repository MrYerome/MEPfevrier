<?php
include 'View/HomeView.php';
include 'Model/HomeModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class HomeController
{
    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new HomeView();
        $this->model = new HomeModel();
    }

    public function envoiMailAction()
    {
        $liste=$_SESSION;
        $mail = new PHPMailer;

        try {
//var_dump($liste['login']);
//var_dump($liste['nomfamille']);
//var_dump($liste['panier']);
//$recap=json_encode($liste['panier']);
//var_dump($recap);

            $mail->From = "vinet.jerome@gmail.com";
            $mail->addAddress($liste['login'], $liste['nomfamille']);
            $mail->Subject = "Envoi de votre commande";
            $mail->Body = $recap;

        }
        catch (Exception $e) {
            echo $e;
            echo 'Message non envoyé';
            echo 'Erreur: ' . $mail->ErrorInfo;
        }

        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        else {
            echo "Votre message a bien été envoyé!";
        }
    }


    public function HomeAction()
    {
        $this->view->DisplayHome();
    }

    public function identificationAction()
    {
        $this->view->DisplayIdentification();
    }

    public function ajoutLigneCommandeAction()
    {
        $liste = $this->model->ajoutLigneCommande();
        $this->view->DisplayajoutLigneCommande($liste);
    }

    public function validCommandeAction()
    {
        $this->view->DisplayValidationCommande();
    }

    public function connectionAction()
    {
        $_SESSION = $this->model->verifConnection();
        $this->view->DisplayConfirmation($_SESSION);
    }

    public function premiereconnectionAction()
    {
        $_SESSION = $this->model->ajoutPremiereConnection();
        $this->view->DisplayConfirmation($_SESSION);
    }

    public function ajoutCommandeAction()
    {
        $liste = $this->model->ajoutCommande();
        $this->envoiMailAction($liste);
        $this->view->DisplayAjoutCommande($liste);
    }

    public function deconnexAction()
    {
        $this->model->deconnex();
        $this->view->DisplayHome();
    }

    public function supprLigneCommandeAction()
    {
        $liste = $this->model->supprLigneCommande();
        $this->view->DisplaySupprLigneCommande($liste);
    }

    public function confirmationMailAction()
    {
        $this->view->DisplayConfirmationMail();
    }

}

?>