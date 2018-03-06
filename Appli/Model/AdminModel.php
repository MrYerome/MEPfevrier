<?php


class AdminModel
{
    const SERVER = "localhost";
    const USER = "root";
    const PASSWORD = "";
    const BASE = "mep_fevrier";

//    const SERVER = "sqlprive-pc2372-001.privatesql";
//    const USER = "cefiidev740";
//    const PASSWORD = "RBi8pi94";
//    const BASE = "cefiidev740";

    private $connection;

    public function __construct()
    {

        try {
            $this->connection = new
            PDO("mysql:host=" .
                self::SERVER . ";dbname=" .
                self::BASE, self::USER,
                self::PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } catch (Exception $e) {
            die('Erreur : ' . $e->GetMessage());
        }
    }
    
// requete controlant les identifiants administrateur
    public function getControleAdmin() {
        $loginAdmin = isset($_POST["loginAdmin"])?$_POST["loginAdmin"]:null;
        $passwordAdmin = isset($_POST["passwordAdmin"])?$_POST["passwordAdmin"]:null;
        $requete = $this->connection->prepare("SELECT id_admin, login, mdp FROM mepadmin WHERE login = :loginAdmin");
        $requete->bindParam(":loginAdmin",$loginAdmin);
        $requete->execute();
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
                
        if (($resultat['login'] == $loginAdmin) && ($resultat['mdp'] == $passwordAdmin)) {
            $_SESSION['acces'] ="admin";
            $_SESSION['message'] = "<div class=\"alert alert-success\"><strong>Bienvenue cher et tendre administrateur de ce superbe site... Du bon boulot!!!</strong></div>";
        } else {
            //$_SESSION['acces'] != "admin";
            $_SESSION['message'] = "<div class=\"alert alert-danger\"><strong>Oups... Erreur d'authentification!!! Rooooo, le boulet</strong></div>";
        }
        
    }

    public function getListeClient()
    {
        $requete = $this->connection->prepare("SELECT `id_client`, `nomfamille`, `prenom`, `adresse1`, `codepostal`, `ville`, `mail`, `pass`, `tel` FROM `mepclient`");
        $requete->bindParam(':loginform', $loginform);

        $result = $requete->execute();
        $liste = array();
        if ($result) {
            $liste = $requete->fetchAll(PDO::FETCH_ASSOC);
        }
        return $liste;

    }

    public function getDetail()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 0;
        }

        $requete = "SELECT mepclient.nomfamille, mepclient.prenom, mepclient.adresse1, mepclient.codepostal, mepclient.ville, mepclient.mail, mepclient.tel, mepcommandeclient.id_client, mepcommandeclient.id_commande FROM `mepclient` LEFT OUTER JOIN `mepcommandeclient` ON mepclient.id_client=mepcommandeclient.id_client WHERE mepclient.id_client=$id";

        $result = $this->connection->query($requete);
        if ($result) {
            $liste = ($result->fetchAll(PDO::FETCH_ASSOC));

        }
        return $liste;


    }

// requete liste de commande
    public function getListeCommande()
    {
        $requete = $this->connection->prepare("SELECT mepcommande.id_commande, mepcommande.date_commande, mepcommande.heure, mepclient.nomfamille, mepclient.prenom
                                       FROM mepcommande
                                       JOIN mepcommandeclient ON mepcommande.id_commande = mepcommandeclient.id_commande
                                       JOIN mepclient ON mepclient.id_client = mepcommandeclient.id_client
                                       WHERE traitement = 0
                                       ORDER BY `date_commande`, `heure`");
        $requete->execute();
        $liste = array();
        if ($requete) {
            $liste = $requete->fetchAll(PDO::FETCH_ASSOC);
        }
        return $liste;
    }
    
// requete qui passe le traitement d'une commande à 1, commande valider
    public function hideCommande() {
        $id = (isset($_GET["id"]))?$_GET["id"]:null;
        $requete = $this->connection->prepare("UPDATE mepcommande SET traitement = 1 WHERE id_commande = :id");
        $requete->bindParam(':id',$id);
        $resultat = $requete->execute();
    }
    
    public function getDetailCommande()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 0;
        }

        $requete = "SELECT mepcommande.id_commande, `date_commande`, `heure`, mepclient.id_client, mepclient.nomfamille, mepclient.prenom, meplignecommande.id_produit, mepproduit.nom, mepproduit.prix, meplignecommande.quantite FROM `mepcommande`  LEFT OUTER JOIN `mepcommandeclient` ON mepcommandeclient.id_commande=mepcommande.id_commande LEFT OUTER JOIN `mepclient` ON mepcommandeclient.id_client=mepclient.id_client LEFT OUTER JOIN `meplignecommande` ON meplignecommande.id_commande=mepcommande.id_commande LEFT OUTER JOIN `mepproduit` ON mepproduit.id_produit=meplignecommande.id_produit WHERE mepcommande.id_commande=$id";

        $result = $this->connection->query($requete);
        if ($result) {
            $liste = ($result->fetchAll(PDO::FETCH_ASSOC));

        }
        return $liste;
    }
    
// requete historique des commandes validés
    public function getHistoriqueCommande()
    {
        $requete = $this->connection->prepare("SELECT mepcommande.id_commande, mepcommande.date_commande, mepcommande.heure, mepclient.nomfamille, mepclient.prenom
                                       FROM mepcommande
                                       JOIN mepcommandeclient ON mepcommande.id_commande = mepcommandeclient.id_commande
                                       JOIN mepclient ON mepclient.id_client = mepcommandeclient.id_client
                                       WHERE traitement = 1
                                       ORDER BY `date_commande`, `heure`");
        $requete->execute();
        $liste = array();
        if ($requete) {
            $liste = $requete->fetchAll(PDO::FETCH_ASSOC);
        }
        return $liste;
    }

// requete historique d'une commande validé
    public function getDetailHistoriqueCommande()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 0;
        }

        $requete = "SELECT mepcommande.id_commande, `date_commande`, `heure`, mepclient.id_client, mepclient.nomfamille, mepclient.prenom, meplignecommande.id_produit, mepproduit.nom, mepproduit.prix, meplignecommande.quantite FROM `mepcommande`  LEFT OUTER JOIN `mepcommandeclient` ON mepcommandeclient.id_commande=mepcommande.id_commande LEFT OUTER JOIN `mepclient` ON mepcommandeclient.id_client=mepclient.id_client LEFT OUTER JOIN `meplignecommande` ON meplignecommande.id_commande=mepcommande.id_commande LEFT OUTER JOIN `mepproduit` ON mepproduit.id_produit=meplignecommande.id_produit WHERE mepcommande.id_commande=$id";

        $result = $this->connection->query($requete);
        if ($result) {
            $liste = ($result->fetchAll(PDO::FETCH_ASSOC));

        }
        return $liste;
    }

// requete renvoyant le stock alimentaire
    public function getStockAliment()
    {
        $requete = $this->connection->prepare("SELECT * FROM mepstockaliment");
        $requete->execute();
        $liste = array();
        if ($requete) {
            $liste = $requete->fetchAll(PDO::FETCH_ASSOC);
        }
        return $liste;
    }
    
// requête renvoyant le détail d'un produit alimentaire
    public function getDetailAliment() {
        $id = isset($_GET['id'])?$_GET['id']:null;
        $requete = $this->connection->prepare("SELECT id_aliment, type_aliment, nom_aliment, stock_aliment FROM mepstockaliment WHERE id_aliment= :id");
        $requete->bindParam(':id',$id);
        $requete->execute();
        $detailAliment = array();
        if ($requete) {
            $detailAliment = $requete->fetchAll(PDO::FETCH_ASSOC);
        }
        return $detailAliment;
    }
    
// requete renvoyant le stock de consommable
    public function getStockConsommable()
    {
        $requete = $this->connection->prepare("SELECT * FROM mepstockemballage");
        $requete->execute();
        $liste = array();
        if ($requete) {
            $liste = $requete->fetchAll(PDO::FETCH_ASSOC);
        }
        return $liste;
    }

// requête renvoyant le détail d'un consommable
    public function validLigneAliment() {
//        var_dump($_POST);
        $ref="";
        if (isset($_POST['ref']) && !empty($_POST['ref'])) {
            $ref = htmlentities($_POST['ref']);
        }
        $qte="";
        if (isset($_POST['qte']) && !empty($_POST['qte'])) {
            $qte = htmlentities($_POST['qte']);
        }

        $requete = $this->connection->prepare("UPDATE `mepstockaliment` SET `stock_aliment`=mepstockaliment.stock_aliment+:qte WHERE  mepstockaliment.ref=:ref");
        $requete->bindParam(':ref',$ref);
        $requete->bindParam(':qte',$qte);
        $retour=$requete->execute();

        return $retour;

    }

    public function getCommandeAliment() {

//        var_dump($_POST);
        $url = $_POST['adresse'];
//        var_dump($url);

        $json = file_get_contents($url);

        $parsed_json = json_decode($json);
//        var_dump($parsed_json);
        $fournisseur = $parsed_json->fournisseur;
        $numerocommande = $parsed_json->id_commande;
        $listeAliment = array("fournisseur"=>$fournisseur,"Commande"=>$numerocommande);


// array_push($listeAliment,$fournisseur,$numerocommande);

        $contenu=$parsed_json->contenu_commande;

        foreach($contenu as $item){
            $liste=array();
            array_push($liste,$item->ref,$item->qte);


            array_push($listeAliment,$liste);
        }

        //var_dump($listeAliment);

        return $listeAliment;
    }


    
}