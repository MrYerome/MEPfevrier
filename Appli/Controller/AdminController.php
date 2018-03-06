<?php
include 'View/AdminView.php';
include 'Model/AdminModel.php';
class AdminController
{
    private $view;
    private $model;
    public function __construct() {
        $this->view = new AdminView();
        $this->model = new AdminModel();
    }
    
    public function identificationAdminAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $this->view->DisplayAccueil();
        } else {
            $this->view->displayIdentificationAdmin();
        }
    }
    
    public function controleAdminAction() {
        $this->model->getControleAdmin();
        $this->accueilAction();
    }
    
    public function deconnexionAdminAction() {
        session_destroy();
        header("location:index.php?Controller=Home&action=home");
    }

    public function accueilAction()
    {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $this->view->DisplayAccueil();
        }else{
            $this->identificationAdminAction();
        }
    }
    

    public function listeClientAction()
    {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
                $liste = $this->model->getListeClient();
                $this->view->DisplayListeClient($liste);        
        }else{
            $this->identificationAdminAction();
        }
    }

    public function voirClientAction()
    {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $list = $this->model->getDetail();
            $this->view->DisplayDetail($list);
        }else{
            $this->identificationAdminAction();
        }
    }

    public function listeCommandeAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $listeCommande = $this->model->getListeCommande();
            $this->view->displayListeCommande($listeCommande);
        }else{
            $this->identificationAdminAction();
        }
    }
    
    public function hideCommandeAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $this->model->hideCommande();
            header("location:index.php?Controller=Admin&action=listeCommande");
        }else{
            $this->identificationAdminAction();
        }
    }

    public function detailCommandeAction()
    {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $list = $this->model->getDetailCommande();
            $this->view->DisplayDetailCommande($list);
        }else{
            $this->identificationAdminAction();
        }
    }
    
    public function historiqueCommandeAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $listeCommande = $this->model->getHistoriqueCommande();
            $this->view->displayHistoriqueCommande($listeCommande);  
        }else{
            $this->identificationAdminAction();
        }
    }
    
    public function detailHistoriqueCommandeAction()
    {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $list = $this->model->getDetailHistoriqueCommande();
            $this->view->DisplayDetailHistoriqueCommande($list); 
        }else{
            $this->identificationAdminAction();
        }
    }

    public function listeStockAlimentAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $liste = $this->model->getStockAliment();
            $this->view->displayStockAliment($liste);
        }else{
            $this->identificationAdminAction();
        }
    }
    
    public function detailAlimentAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $detailAliment = $this->model->getDetailAliment();
            $this->view->displayDetailAliment($detailAliment);
        }else{
            $this->identificationAdminAction();
        }
    }
    
    public function listeStockConsommableAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $liste = $this->model->getStockConsommable();
            $this->view->displayStockConsommable($liste);
        }else{
            $this->identificationAdminAction();
        }
    }
    
    public function detailConsommableAction() {
        if (isset($_SESSION['acces']) && $_SESSION['acces'] == "acces"){
            $detailAliment = $this->model->getDetailConsommable();
            $this->view->displayDetailConsommable($detailAliment);
        }else{
            $this->identificationAdminAction();
        }
    }

    public function getCommandeAlimentAction() {
        $commandeAliment = $this->model->getCommandeAliment();
        $this->view->displayCommandeAliment($commandeAliment);
    }
    public function validLigneAlimentAction() {
        $validLigneAliment = $this->model->validLigneAliment();
        $this->view->displayValidLigneAliment($validLigneAliment);
    }

}