<?php


class AdminView
{
    private $page;

    public function __construct()
    {
        $this->page = file_get_contents("View/html/headadmin.html");
        $this->page .= file_get_contents("View/html/headeradmin.html");
    }
    
// formulaire d'identification du back office administrateur    
    public function displayIdentificationAdmin() {
        $this->page .= file_get_contents("View/html/identificationAdmin.html");
        if (isset($_SESSION['message'])){
            $this->page = str_replace("{message}", $_SESSION['message'] ,$this->page);
            unset($_SESSION['message']);
        }else{
            $this->page =str_replace('{message}', '', $this->page);
        }
        $this->display();
    }


    public
    function DisplayAccueil()
    {
        $this->page .=file_get_contents("View/html/accueilAdmin.html");
        if (isset($_SESSION['message'])){
            $this->page = str_replace("{message}", $_SESSION['message'] ,$this->page);
        unset($_SESSION['message']);
        }else{
            $this->page =str_replace('{message}', '', $this->page);
        }
        $this->Display();
    }

    public
    function DisplayListeClient($liste)
    {
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-12'>";
        $this->page .= "<h3>Liste des clients</h3>";
        $this->page .= "<table id='myTable' class='table datatable' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>id</th><th>Nom</th><th>Prénom</th><th>Adresse</th><th>Code Postal</th><th>Ville</th><th>Mail</th><th>Téléphone</th><th width='20px'>Voir</th></tr></thead><tbody>";
        //var_dump($list);
        foreach ($liste as $element) {
            $this->page .= "<tr id='" . $element['id_client'] . "'>";
            $this->page .= "<td>" . $element['id_client'] . "</td>";
            $this->page .= "<td>" . $element['nomfamille'] . "</td>";
            $this->page .= "<td>" . $element['prenom'] . "</td>";
            $this->page .= "<td>" . $element['adresse1'] . "</td>";
            $this->page .= "<td>" . $element['codepostal'] . "</td>";
            $this->page .= "<td>" . $element['ville'] . "</td>";
            $this->page .= "<td>" . $element['mail'] . "</td>";
            $this->page .= "<td>" . $element['tel'] . "</td>";
            $this->page .= "<td class='text-center'><a class='glyphicon glyphicon-eye-open' href='index.php?Controller=Admin&action=voirClient&id=" . $element["id_client"] . "'></a></td>";
            $this->page .= "</tr>";
        }

        $this->page .= "</tbody></table>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->page .= " <a href='index.php?Controller=Admin&action=accueil'><button type='button' class='btn btn-light'>Retour à l'accueil</button></a>";

        $this->Display();
    }

    public
    function DisplayDetail($liste)
    {
        $this->page .= "Nom : " . $liste[0]['nomfamille'] . "<br>";
        $this->page .= "Prénom : " . $liste[0]['prenom'] . "<br>";
        $this->page .= "Adresse : " . $liste[0]['adresse1'] . "<br>";
        $this->page .= "Code postal : " . $liste[0]['codepostal'] . "<br>";
        $this->page .= "Ville : " . $liste[0]['ville'] . "<br>";
        $this->page .= "Mail : " . $liste[0]['mail'] . "<br>";
        $this->page .= "Tel : " . $liste[0]['tel'] . "<hr>";
        foreach ($liste as $element) {

            $this->page .= "<a href='index.php?Controller=Admin&action=detailCommande&id=".$element['id_commande'] ."'>Commande : " . $element['id_commande'] . "</a><br>";

        }
        $this->page .="<br>";
        $this->page .= " <a href='index.php?Controller=admin&action=listeClient'><button type='button' class='btn btn-light'>Retour à la liste des clients</button></a>";
        $this->Display();
    }

// Affichage de la liste des commandes
    public function displayListeCommande($listeCommande) {
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-10'>";
        $this->page .= "<h3>Liste des commandes</h3>";
        $this->page .= "<table id='myTable' class='table datatable' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>Date</th><th>Heure</th><th>N° de Commande</th><th>Nom du Client</th><th>Prénom</th><th width='20px'>Voir</th><th width='50px'>Validation</th></tr></thead><tbody>";
        //var_dump($list);
        foreach ($listeCommande as $element) {
            $this->page .= "<tr id='" . $element['id_commande'] . "'>";
            $this->page .= "<td>" . $element['date_commande'] . "</td>";
            $this->page .= "<td>" . $element['heure'] . "</td>";
            $this->page .= "<td>" . $element['id_commande'] . "</td>";
            $this->page .= "<td>" . $element['nomfamille'] . "</td>";
            $this->page .= "<td>" . $element['prenom'] . "</td>";
            $this->page .= "<td class='text-center'><a class='glyphicon glyphicon-eye-open' href='index.php?Controller=Admin&action=detailCommande&id=" . $element["id_commande"] . "'></a></td>";
            $this->page .= "<td><a href='index.php?Controller=Admin&action=hideCommande&id=". $element['id_commande'] ."' type='button' class='btn btn-warning btn-sm'>Valider</a></td>";
            $this->page .= "</tr>";
        }

        $this->page .= "</tbody></table>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->page .= " <a href='index.php?Controller=admin&action=accueil'><button type='button' class='btn btn-light'>Retour à l'accueil</button></a>";

        $this->Display();
    }

    public
    function DisplayDetailCommande($liste)
    {
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-10'>";
        $this->page .= "Numéro de la commande : " . $liste[0]['id_commande'] . "<br>";
        $this->page .= "Date de la commande : " . $liste[0]['date_commande'] . "<br>";
        $this->page .= "Heure de la commande : " . $liste[0]['heure'] . "<br>";
        $this->page .= "Nom du client : " . $liste[0]['nomfamille'] . "<br>";
        $this->page .= "Prénom du client : " . $liste[0]['prenom'] . "<br>";
        $this->page .= "<br>";
        $this->page .= "<table border=1px width=400px style='text-align:center;'>";       
        $this->page .= "<tr><th>Référence</th><th>Produit</th><th>Quantité</th></tr>";
        foreach ($liste as $element) {
            $this->page .= "<tr>";
            $this->page .= "<td>".$element['id_produit']."</td>";
            $this->page .= "<td>".$element['nom']."</td>";
            $this->page .= "<td>".$element['quantite']."</td>";
            $this->page .= "</tr>";
        }
        $this->page .= "</table>";
        $this->page .="<br>";
        $this->page .= " <a href='index.php?Controller=admin&action=voirClient&id=".$liste[0]['id_client']."'><button type='button' class='btn btn-light'>Retour à la fiche Client</button></a>";
        $this->page .= " <a href='index.php?Controller=admin&action=listeCommande'><button type='button' class='btn btn-light'>Retour à la liste des commandes</button></a>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->Display();
    }
    
// Affichage de l'historique des commandes validés
    public function displayHistoriqueCommande($listeCommande) {
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-10'>";
        $this->page .= "<h3>Historique des commandes validés</h3>";
        $this->page .= "<table id='myTable' class='table datatable' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>Date</th><th>Heure</th><th>N° de Commande</th><th>Nom du Client</th><th>Prénom</th><th width='20px'>Voir</th></tr></thead><tbody>";
        //var_dump($list);
        foreach ($listeCommande as $element) {
            $this->page .= "<tr id='" . $element['id_commande'] . "'>";
            $this->page .= "<td>" . $element['date_commande'] . "</td>";
            $this->page .= "<td>" . $element['heure'] . "</td>";
            $this->page .= "<td>" . $element['id_commande'] . "</td>";
            $this->page .= "<td>" . $element['nomfamille'] . "</td>";
            $this->page .= "<td>" . $element['prenom'] . "</td>";
            $this->page .= "<td class='text-center'><a class='glyphicon glyphicon-eye-open' href='index.php?Controller=Admin&action=detailHistoriqueCommande&id=" . $element["id_commande"] . "'></a></td>";
            $this->page .= "</tr>";
        }

        $this->page .= "</tbody></table>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->page .= " <a href='index.php?Controller=admin&action=accueil'><button type='button' class='btn btn-light'>Retour à l'accueil</button></a>";

        $this->Display();
    }

// Affichage de l'historique d'une commande validé
    public
    function DisplayDetailHistoriqueCommande($liste)
    {
        $this->page .= "Numéro de la commande : " . $liste[0]['id_commande'] . "<br>";
        $this->page .= "Date de la commande : " . $liste[0]['date_commande'] . "<br>";
        $this->page .= "Heure de la commande : " . $liste[0]['heure'] . "<br>";
        $this->page .= "Nom du client : " . $liste[0]['nomfamille'] . "<br>";
        $this->page .= "Prénom du client : " . $liste[0]['prenom'] . "<br>";
        $this->page .= "<br>";
        $this->page .= "<table border=1px width=400px style='text-align:center'>";       
        $this->page .= "<tr><th>Référence</th><th>Produit</th><th>Quantité</th></tr>";
        foreach ($liste as $element) {
            $this->page .= "<tr>";
            $this->page .= "<td>".$element['id_produit']."</td>";
            $this->page .= "<td>".$element['nom']."</td>";
            $this->page .= "<td>".$element['quantite']."</td>";
            $this->page .= "</tr>";
        }
        $this->page .= "</table>";
        $this->page .="<br>";
        $this->page .= " <a href='index.php?Controller=admin&action=historiqueCommande'><button type='button' class='btn btn-light'>Retour à l'historique des commandes validés</button></a>";        
        $this->Display();
    }

// retourne un tableau du stock Alimentaire
    public function displayStockAliment($listeStockAliment){
        $this->page .= file_get_contents('View/html/ajoutstockaliment.html');
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-10'>";
        $this->page .= "<h3>Stock Produit Alimentaire</h3>";
        $this->page .= "<table id='myTable' class='table datatable' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>Référence Article Fournisseur</th><th>Produit</th><th>Quantité</th><th>Voir</th></tr></thead><tbody>";
        //var_dump($list);
        foreach ($listeStockAliment as $element) {
            $this->page .= "<tr id='" . $element['id_aliment'] . "'>";
            $this->page .= "<td>" . $element['ref'] . "</td>";
            $this->page .= "<td>" . $element['nom_aliment'] . "</td>";
            $this->page .= "<td>" . $element['stock_aliment'] . "</td>";
            $this->page .= "<td class='text-center'><a class='glyphicon glyphicon-eye-open' href='index.php?Controller=Admin&action=detailAliment&id=" . $element["id_aliment"] . "'></a></td>";
            $this->page .= "</tr>";
        }
        $this->page .= "</tbody></table>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->page .= " <a href='index.php?Controller=admin&action=accueil'><button type='button' class='btn btn-light'>Retour à l'accueil</button></a>";
        $this->page .= " <a href='index.php?Controller=Admin&action=listeStockAliment'><button type='button' class='btn btn-light'>Mettre à jour les stocks</button></a>";

        $this->Display();
    }
    
// retourne le détail d'un produit alimentaire
    public function displayDetailAliment($detailAliment) {
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-10'>";
        $this->page .= "<h3>";
        foreach ($detailAliment as $element) {
            $this->page .= $element['nom_aliment'];
        }
        $this->page .= "</h3>";
        $this->page .= "<table id='myTable' class='table datatable' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>Référence Article Fournisseur</th><th>Produit</th><th>Quantité</th></tr></thead><tbody>";
        foreach ($detailAliment as $element) {
            $this->page .= "<tr id='" . $element['id_aliment'] . "'>";
            $this->page .= "<td>" . $element['type_aliment'] . "</td>";
            $this->page .= "<td>" . $element['nom_aliment'] . "</td>";
            $this->page .= "<td>" . $element['stock_aliment'] . "</td>";
            $this->page .= "</tr>";
        }
        $this->page .= "</tbody></table>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->page .= " <a href='index.php?Controller=admin&action=listeStockAliment'><button type='button' class='btn btn-light'>Retour Liste Stock Produit Alimentaire</button></a>";

        $this->Display(); 
    }
    
// retourne un tableau du stock de consommable
    public function displayStockConsommable($listeStockConsommable){
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-10'>";
        $this->page .= "<h3>Stock Produit Consommable</h3>";
        $this->page .= "<table id='myTable' class='table datatable' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>Référence Consommable Fournisseur</th><th>Produit</th><th>Quantité</th><th>Voir</th></tr></thead><tbody>";
        //var_dump($list);
        foreach ($listeStockConsommable as $element) {
            $this->page .= "<tr id='" . $element['id_emballage'] . "'>";
            $this->page .= "<td>" . $element['type_emballage'] . "</td>";
            $this->page .= "<td>" . $element['nom_emballage'] . "</td>";
            $this->page .= "<td>" . $element['stock_emballage'] . "</td>";
            $this->page .= "<td class='text-center'><a class='glyphicon glyphicon-eye-open' href='index.php?Controller=Admin&action=detailConsommable&id=" . $element["id_emballage"] . "'></a></td>";
            $this->page .= "</tr>";
        }
        $this->page .= "</tbody></table>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->page .= " <a href='index.php?Controller=admin&action=accueil'><button type='button' class='btn btn-light'>Retour à l'accueil</button></a><br>";
        $this->page .= " <a href='index.php?Controller=Admin&action=listeStockConsommable'><button type='button' class='btn btn-light'>Mettre à jour les stocks</button></a>";

        $this->Display();
    }

// retourne le détail d'un produit alimentaire
    public function displayDetailConsommable($detailConsommable) {
        $this->page .= "<div class='row'>";
        $this->page .= "<div class='col-xs-10'>";
        $this->page .= "<h3>";
        foreach ($detailConsommable as $element) {
            $this->page .= $element['nom_emballage'];
        }
        $this->page .= "</h3>";
        $this->page .= "<table id='myTable' class='table datatable' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>Référence Consommable Fournisseur</th><th>Produit</th><th>Quantité</th></tr></thead><tbody>";
        foreach ($detailConsommable as $element) {
            $this->page .= "<tr id='" . $element['id_emballage'] . "'>";
            $this->page .= "<td>" . $element['type_emballage'] . "</td>";
            $this->page .= "<td>" . $element['nom_emballage'] . "</td>";
            $this->page .= "<td>" . $element['stock_emballage'] . "</td>";
            $this->page .= "</tr>";
        }
        $this->page .= "</tbody></table>";
        $this->page .= "</div>";
        $this->page .= "</div>";
        $this->page .= " <a href='index.php?Controller=admin&action=listeStockConsommable'><button type='button' class='btn btn-light'>Retour Liste Stock Produit Alimentaire</button></a>";

        $this->Display(); 
    }    
    public function displayCommandeAliment($liste){
        echo json_encode($liste);
    }

    public function displayValidLigneAliment($liste){
        echo $liste;
    }



    private
    function Display()
    {
        $this->page .= file_get_contents("View/html/footeradmin.html");
        echo $this->page;
    }
}