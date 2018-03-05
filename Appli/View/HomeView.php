<?php

class HomeView
{
    private $page;

    public function __construct()
    {
        $this->page = file_get_contents("View/html/head.html");
        $this->page .= file_get_contents("View/html/header.html");
    }

    public function DisplayHome()
    {
        $this->page .= file_get_contents("View/html/home.html");
        $this->Display();

    }

    public function DisplayIdentification()
    {
        $this->page .= file_get_contents("View/html/identification.html");
        $this->Display();

    }

    public function DisplayConnection($list)
    {//var_dump($list);
        if ($list['OK'] == 1) {
            $this->page .= file_get_contents("View/html/banieredeconnexion.html");
            $this->page .= file_get_contents("View/html/authentification.html");
            $this->Display();
        } else {
            $this->DisplayIdentification_erreur();
        }

    }


    public
    function DisplayIdentification_erreur()
    {
        $this->page .= file_get_contents("View/html/home.html");
        $this->page .= "<p class='erreur'>Erreur d'identification. Veuillez recommencer.</p>";
        $this->Display();
    }

    public
    function DisplayajoutLigneCommande($liste)
    {
        echo json_encode($liste);

    }

    public
    function DisplayValidationCommande()
    {
        $this->page .= file_get_contents("View/html/identification.html");
        $this->Display();
    }

    public function DisplayConfirmation($list)
    {
//        var_dump($list);
        if ($list['OK'] == 1) {
            $this->page .= "<div class=\"main container\">";
            $this->page .= "<h1>Bonjour " . $list['prenom']. " ".$list['nomfamille']."<h1/>";
            $this->page .= "<h2>Voici le récaptitulatif de votre commande :<h2/>";
            $this->page .= "<table id='myTable' class='table' border='1px solid black'>
<thead class='tnoir'><tr class='tnoir'><th>Identifiant du produit</th><th>Nom du produit</th><th>Quantité</th><th>Prix par unité</th><th>Total de la ligne</th></tr></thead><tbody>";
            $total=0;
            foreach ($list['panier']as $element){

                $this->page .= "<tr id='" . $element[0] . "'>";
                $this->page .= "<td>" . $element[0]. "</td>";
                $this->page .= "<td>" . $element[1]. "</td>";
                $this->page .= "<td>" . $element[2]. "</td>";
                $this->page .= "<td>" . $element[3]. "</td>";
                $prixligne= $element[2]*$element[3];
                $this->page .= "<td>" .$prixligne. "</td>";
                $this->page .= "</tr>";
                $total+=$prixligne;
            }
            $this->page .= "<td>Le prix total de votre comande est de ".$total." Euros.";
            $this->page .= "</tbody></table>";
            $this->page .= "<div class=\"main container\">";
            $this->page .= "<button class='validation btn btn-primary'>Confirmer votre commande<button/>";
            $this->page .= "<div/>";
            $this->Display();
        } else {
            $this->DisplayIdentification_erreur();
        }

    }

    public
    function DisplayAjoutCommande($liste)
    {
        echo json_encode($liste);

    }
    public function DisplaySupprLigneCommande($liste)
    {
        var_dump($liste);
        echo json_encode($liste);

    }

    public function DisplayConfirmationMail()
    {
        $this->page .= file_get_contents("View/html/fincommande.html");
        $this->Display();

    }

    private
    function Display()
    {
        $this->page .= file_get_contents("View/html/footer.html");
        echo $this->page;
    }
}
