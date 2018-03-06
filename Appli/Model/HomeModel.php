<?php

class HomeModel
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

    public function ajoutPremiereConnection()
    {
        if (isset ($_POST['lofginformpremiere'])) {
            $loginformpremiere = htmlentities($_POST['lofginformpremiere']);
        } else {
            $loginformpremiere = "";
        }
        if (isset ($_POST['passwordformpremiere'])) {
            $passwordformpremiere = htmlentities($_POST['passwordformpremiere']);
        } else {
            $passwordformpremiere = "";
        }
        if (isset ($_POST['nomfamille'])) {
            $nomfamille = htmlentities($_POST['nomfamille']);
        } else {
            $nomfamille = NULL;
        }
        if (isset ($_POST['prenom'])) {
            $prenom = htmlentities($_POST['prenom']);
        } else {
            $prenom = NULL;
        }
        if (isset ($_POST['adresse1'])) {
            $adresse1 = htmlentities($_POST['adresse1']);
        } else {
            $adresse1 = NULL;
        }
        if (isset ($_POST['codepostal'])) {
            $codepostal = htmlentities($_POST['codepostal']);
        } else {
            $codepostal = NULL;
        }
        if (isset ($_POST['ville'])) {
            $ville = htmlentities($_POST['ville']);
        } else {
            $ville = NULL;
        }
        if (isset ($_POST['tel'])) {
            $tel = htmlentities($_POST['tel']);
        } else {
            $tel = NULL;
        }

        //verification avec la BDD*
        $requete = $this->connection->prepare("INSERT INTO `mepclient`(`nomfamille`, `prenom`, `adresse1`, `codepostal`, `ville`, `mail`, `pass`, `tel`) VALUES (:nomfamille, :prenom, :adresse1, :codepostal, :ville, :loginformpremiere, :passwordformpremiere, :tel)");
        $requete->bindParam(':loginformpremiere', $loginformpremiere);
        $requete->bindParam(':passwordformpremiere', $passwordformpremiere);
        $requete->bindParam(':nomfamille', $nomfamille);
        $requete->bindParam(':adresse1', $adresse1);
        $requete->bindParam(':prenom', $prenom);
        $requete->bindParam(':codepostal', $codepostal);
        $requete->bindParam(':ville', $ville);
        $requete->bindParam(':tel', $tel);

        $result = $requete->execute();

        if ($result) {
            $_SESSION['login'] = $loginformpremiere;
            $_SESSION['password'] = $passwordformpremiere;
            $_SESSION['nomfamille'] = $nomfamille;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['OK'] = 1;
            $_SESSION['message'] = "Vous êtes désormais connectés";
        }
        return $_SESSION;

    }


    public function verifConnection()
    {
        if (isset ($_POST['loginform'])) {
            $loginform = htmlentities($_POST['loginform']);
        } else {
            $loginform = "";
        }


        if (isset ($_POST['passwordform'])) {
            $passwordform = htmlentities($_POST['passwordform']);
        } else {
            $passwordform = "";
        }

        //verification avec la BDD*
        $requete = $this->connection->prepare("SELECT `nomfamille`, `prenom`, `pass`, `mail`  FROM `mepclient` WHERE `mail`=:loginform");
        $requete->bindParam(':loginform', $loginform);

        $result = $requete->execute();
        $liste = array();
        if ($result) {
            $liste = $requete->fetch(PDO::FETCH_ASSOC);
        }
        $prenom = $liste['prenom'];
        $nomfamille = $liste['nomfamille'];
        $loginsql = $liste['mail'];
        $passwordsql = $liste['pass'];


        if ($loginform == $loginsql && $passwordform == $passwordsql) {
            //session_destroy();
            //session_start();
            $_SESSION['login'] = $loginsql;
            $_SESSION['password'] = $passwordsql;
            $_SESSION['nomfamille'] = $nomfamille;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['OK'] = 1;
            $_SESSION['message'] = "Vous êtes désormais connectés";
            return $_SESSION;
        } else {
            $_SESSION['login'] = $loginsql;
            $_SESSION['password'] = $passwordsql;
            $_SESSION['OK'] = 0;
            $_SESSION['message'] = "Vous n'êtes pas connectés";
            return $_SESSION;
        }

    }

    public function ajoutLigneCommande()
    {
        if (isset($_POST['id'])) {
            $nomduproduit = $_POST['id'];
        } else {
            $nomduproduit = "";
        }
        if (isset($_POST['qte'])) {
            $qteduproduit = $_POST['qte'];
        } else {
            $qteduproduit = 0;
        }
        $requete = $this->connection->prepare("SELECT `id_produit`, `typeproduit`, `nom`, `prix` FROM `mepproduit` WHERE `nom`=:nomduproduit");
        $requete->bindParam(':nomduproduit', $nomduproduit);

        $result = $requete->execute();
        $liste = array();

        if ($result) {
            $liste = $requete->fetch(PDO::FETCH_ASSOC);
        }

        $lignecommande = array($liste['id_produit'], $liste['nom'], $qteduproduit, $liste['prix']);
        //var_dump($lignecommande);
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array($lignecommande);

        } else {
            array_push($_SESSION['panier'], $lignecommande);
        }

//        $_SESSION['qte']= $qteduproduit;
//        $_SESSION['prix']= $liste['prix'];
//        array_push($_SESSION,"nouvelleligne");

        return $liste;

    }

    public function ajoutCommande()
    {
        //var_dump($_SESSION);
        //récupération des infos clients
        $nomfamille = "";
        if (isset($_SESSION['nomfamille'])) {
            $nomfamille = htmlentities($_SESSION['nomfamille']);
        }
        $prenom = "";
        if (isset($_SESSION['prenom'])) {
            $prenom = htmlentities($_SESSION['prenom']);
        }
        $mail = "";
        if (isset($_SESSION['login'])) {
            $mail = htmlentities($_SESSION['login']);
        }

        //va chercher dans la DB mepclient l'id du client
        $requete = $this->connection->prepare("SELECT `id_client` FROM `mepclient` WHERE `mail`=:mail");
        $requete->bindParam(':mail', $mail);
        $result = $requete->execute();
        $client = array();
        if ($result) {
            $client = $requete->fetch(PDO::FETCH_ASSOC);
        }
        $numeroclient = $client['id_client'];


        //ajout d'une nouvelle commande à la DB avec un nouveau numéro de commande + l'id du client récupéré
        $date = date("Y-m-d");
        $heure = date("H:i:s");
        $requete = $this->connection->prepare("INSERT INTO `mepcommande`(`date_commande`, `heure`, `traitement`) VALUES (:date,:heure,0)");
        $requete->bindParam(':date', $date);
        $requete->bindParam(':heure', $heure);
        $result = $requete->execute();

        //récupération de l'id de la dernière commande
        $requete = $this->connection->prepare("SELECT `id_commande` FROM `mepcommande` ORDER BY id_commande DESC LIMIT 0,1");
        $result = $requete->execute();
        $commande = array();
        if ($result) {
            $commande = $requete->fetch(PDO::FETCH_ASSOC);
        }
        $numerocommande = $commande['id_commande'];
//        var_dump($numerocommande);


        //ajout d'une entrée mepcommandeclient
        $requete = $this->connection->prepare("INSERT INTO `mepcommandeclient`(`id_client`, `id_commande`) VALUES (:id_client,:id_commande)");
        $requete->bindParam(':id_client', $numeroclient);
        $requete->bindParam(':id_commande', $numerocommande);
        $result = $requete->execute();


        //ajout des lignes de commande
        $totalligneajoutee = 0;
        foreach ($_SESSION['panier'] as $lignedecommande) {
            $idproduit = $lignedecommande[0];
            $nompproduit = $lignedecommande[1];
            $qteproduit = $lignedecommande[2];
            $prixproduit = $lignedecommande[3];
//            var_dump($idproduit);
//            var_dump($nompproduit);
//            var_dump($qteproduit);
//            var_dump($prixproduit);
            $requete = $this->connection->prepare("INSERT INTO `meplignecommande`(`quantite`, `id_produit`, `id_commande`) VALUES (:qte,:id_produit,:id_commande)");
            $requete->bindParam(':qte', $qteproduit);
            $requete->bindParam(':id_produit', $idproduit);
            $requete->bindParam(':id_commande', $numerocommande);
            $result = $requete->execute();
            $totalligneajoutee += 1;
        }
        $tableauretour = array();
        array_push($tableauretour, $totalligneajoutee);
        return $tableauretour;

    }


    public function deconnex()
    {
        session_unset();
//    unset($_SESSION['panier']);
    }

    public function supprLigneCommande()
    {

        if (isset($_POST['id'])){
            $id=$_POST['id'];
        }
        unset($_SESSION['panier'][$id]);

        return $_SESSION;
    }

}
