function validation() {
    $(".validation").click(function () {
        $.ajax({
            type: "POST",
            dataType: "text",
            url: "index.php?Controller=Home&action=ajoutCommande",
            success: function (message) {
                //alert(message);
                console.log(message);
                document.location.href = "index.php?Controller=Home&action=confirmationMail";
            }
        });
    });
}


function ajouter() {
    $(".ajouter").click(function () {
        var id = $(this).attr('id');
        var qte = $(this).siblings(".qte").val();

        if (qte > 9) {
            alert("Vous ne pouvez commander que 9 pizzas maximum");
        } else if (qte < 1) {
            alert("Veuillez commander au moins une pizza");
        } else {
            $.ajax({
                type: "POST",
                data: "&id=" + id + "&qte=" + qte,
                dataType: "text",
                url: "index.php?Controller=Home&action=ajoutLigneCommande",
                success: function (message) {
                    console.log(message);
                    var messagedecode = jQuery.parseJSON(message);
                    var id_produit = messagedecode['id_produit'];
                    var type_produit = messagedecode['typeproduit'];
                    var code = messagedecode['nom'];
                    var prix = messagedecode['prix'];
                    console.log(id_produit, type_produit, code, prix, qte);

                    var monPanier = new Panier();
                    monPanier.ajouterArticle(code, qte, prix);
                    var tableau = document.getElementById("tableau");
                    var longueurTab = parseInt(document.getElementById("nbreLignes").innerHTML);
                    if (longueurTab > 0) {
                        for (var i = longueurTab; i > 0; i--) {
                            monPanier.ajouterArticle(tableau.rows[i].cells[0].innerHTML, tableau.rows[i].cells[1].innerHTML, tableau.rows[i].cells[2].innerHTML);
                            tableau.deleteRow(i);
                        }
                    }
                    var longueur = monPanier.liste.length;
                    for (var i = 0; i < longueur; i++) {
                        var ligne = monPanier.liste[i];
                        // console.log(i);
                        var ligneTableau = tableau.insertRow(-1);
                        ligneTableau.setAttribute("id", i);
                        var colonne1 = ligneTableau.insertCell(0);
                        colonne1.innerHTML += ligne.getCode();
                        var colonne2 = ligneTableau.insertCell(1);
                        colonne2.innerHTML += ligne.qteArticle;
                        var colonne3 = ligneTableau.insertCell(2);
                        colonne3.innerHTML += ligne.prixArticle;
                        var colonne4 = ligneTableau.insertCell(3);
                        colonne4.innerHTML += ligne.getPrixLigne();
                        var colonne5 = ligneTableau.insertCell(4);
                        colonne5.innerHTML += "<button class=\"btn btn-primary\" type=\"submit\" onclick=\"supprimer(this.parentNode.parentNode)\"><span class=\"glyphicon glyphicon-remove\"></span> Retirer</button>";
                        document.getElementById("prixTotal").innerHTML = monPanier.getPrixPanier();
                        document.getElementById("nbreLignes").innerHTML = longueur;

                    }

                }
            });
        }
    });

}

function supprimer(message) {
    var idpanier = message.getAttribute("id");
    // console.log(idpanier);
    code = message.cells[0].innerHTML;
    // console.log(code);
    var monPanier = new Panier();
    var tableau = document.getElementById("tableau");
    var longueurTab = document.getElementById("nbreLignes").innerHTML;
    if (longueurTab > 0) {
        for (var i = longueurTab; i > 0; i--) {
            monPanier.ajouterArticle(tableau.rows[i].cells[0].innerHTML, tableau.rows[i].cells[1].innerHTML, tableau.rows[i].cells[2].innerHTML);
            tableau.deleteRow(i);
        }
    }
    monPanier.supprimerArticle(code);
    var longueur = monPanier.liste.length;
    for (var i = 0; i < longueur; i++) {
        var ligne = monPanier.liste[i];
        var ligneTableau = tableau.insertRow(-1);
        ligneTableau.setAttribute("id", i);
        var colonne1 = ligneTableau.insertCell(0);
        colonne1.innerHTML += ligne.getCode();
        var colonne2 = ligneTableau.insertCell(1);
        colonne2.innerHTML += ligne.qteArticle;
        var colonne3 = ligneTableau.insertCell(2);
        colonne3.innerHTML += ligne.prixArticle;
        var colonne4 = ligneTableau.insertCell(3);
        colonne4.innerHTML += ligne.getPrixLigne();
        var colonne5 = ligneTableau.insertCell(4);
        colonne5.innerHTML += "<button class=\"btn btn-primary\" type=\"submit\" onclick=\"supprimer(this.parentNode.parentNode)\"><span class=\"glyphicon glyphicon-remove\"></span> Retirer</button>";
    }
    document.getElementById("prixTotal").innerHTML = monPanier.getPrixPanier();
    document.getElementById("nbreLignes").innerHTML = longueur;

    $.ajax({

        type: "POST",
        dataType: "text",
        data: "id=" + idpanier,
        url: "index.php?Controller=Home&action=supprLigneCommande",
        success: function (message) {
            //alert(message);
            console.log(message);
        }
    });

}

function LignePanier(code, qte, prix) {
    this.codeArticle = code;
    this.qteArticle = qte;
    this.prixArticle = prix;
    this.ajouterQte = function (qte) {
        this.qteArticle += qte;
    }
    this.getPrixLigne = function () {
        var resultat = this.prixArticle * this.qteArticle;
        return resultat;
    }
    this.getCode = function () {
        return this.codeArticle;
    }
}

function Panier() {
    this.liste = [];
    this.ajouterArticle = function (code, qte, prix) {
        var index = this.getArticle(code);
        if (index == -1) this.liste.push(new LignePanier(code, qte, prix));
        else this.liste[index].ajouterQte(qte);
    }
    this.getPrixPanier = function () {
        var total = 0;
        for (var i = 0; i < this.liste.length; i++)
            total += this.liste[i].getPrixLigne();
        return total;
    }
    this.getArticle = function (code) {
        for (var i = 0; i < this.liste.length; i++)
            if (code == this.liste[i].getCode()) return i;
        return -1;
    }
    this.supprimerArticle = function (code) {
        var index = this.getArticle(code);
        if (index > -1) this.liste.splice(index, 1);
    }
}


function Commande() {
    this.liste = [];
    this.ajouterArticle = function (code, qte, prix) {
        var index = this.getArticle(code);
        if (index == -1) this.liste.push(new LignePanier(code, qte, prix));
        else this.liste[index].ajouterQte(qte);
    }
    this.getPrixPanier = function () {
        var total = 0;
        for (var i = 0; i < this.liste.length; i++)
            total += this.liste[i].getPrixLigne();
        return total;
    }
    this.getArticle = function (code) {
        for (var i = 0; i < this.liste.length; i++)
            if (code == this.liste[i].getCode()) return i;
        return -1;
    }
    this.supprimerArticle = function (code) {
        var index = this.getArticle(code);
        if (index > -1) this.liste.splice(index, 1);
    }
}


function ajoutaliment() {
    $("#ajoutaliment").click(function () {
        var input = $("#inputajout").val();
        console.log(input);
        $.ajax({
            type: "POST",
            dataType: "text",
            data: {
                adresse: input
            },
            url: "index.php?Controller=Admin&action=getCommandeAliment",
            success: function (message) {
                //alert(message);
                console.log(message);
                var messagedecode = jQuery.parseJSON(message);
                console.log(messagedecode);
                var fournisseur = messagedecode["fournisseur"];
                var commande = messagedecode["Commande"];
                var tableau2 = document.getElementById("ajouttableau");
                tableau2.innerHTML += "Nom du fournisseur : " + fournisseur + "<br>";
                tableau2.innerHTML += "Numéro de la commande : " + commande + "<br>";
                // tableau2.innerHTML+= "<table>";
                tableau2.innerHTML += "<th><td>Référence</td><td>Quantité</td></th><br>";
                for (var i = 0; i < 3; i++) {
                    var ref = messagedecode[i][0];
                    var qte = messagedecode[i][1];

                    tableau2.innerHTML += "<tr>";
                    tableau2.innerHTML += "<td>Reférence de la commande : " + ref + "  -  </td>";
                    tableau2.innerHTML += "<td>Quantité de la commande : " + qte + "</td>";
                    tableau2.innerHTML += "<span> . . . . .</span><td><button data-qte='" + qte + "' data-ref='" + ref + "' id='" + i + "' class=\"enregistrement btn btn-primary\" type=\"submit\"><span class=\"glyphicon glyphicon-add\"></span> Ajouter</button></td>";
                    tableau2.innerHTML += "</tr><br>"
                }
                tableau2.innerHTML += "</table>";
                ajouterstock();
            }

        });

    })


}

function ajouterstock() {
    $(".enregistrement").click(function () {
        var id = $(this).attr('id');
        var ref = $(this).attr('data-ref');
        var qte = $(this).attr('data-qte');
        console.log(id, ref, qte);
        var bouton = $(this);
        var tableau2 = document.getElementById("ajouttableau");

        $.ajax({
            type: "POST",
            dataType: "text",
            data: {
                id: id,
                ref: ref,
                qte: qte
            },
            url: "index.php?Controller=Admin&action=validLigneAliment",
            success: function (message) {
                console.log(message);
                bouton.hide();
                tableau2.innerHTML += "<p color='red'>Commande ajoutée au stock !<p><br>";
                console.log($(this));
                ajouterstock();

            }

        });

    });
}

function premconnex() {
    $("#premconnex").click(function (e) {
        //        e.preventDefault();
        var form = $(this).closest("form");
        form = form[0].getElementsByTagName("input");
        console.log(form);
        var mail = form[0];
        var password = form[1];
        var nom = form[2];
        var prenom = form[3];
        var adresse = form[4];
        var codepostal = form[5];
        var ville = form[6];
        var tel = form[7];

        var verification = true;

        //        var missnom = document.getElementById("missnom");
        //        var missmail = document.getElementById("missmail");


        // Vérification du mail
        if (mail.value !== "") {
            var mailValue = mail.value;
            var regExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
            if (!regExp.test(mailValue)) {
                mail.style.borderColor = "red";
                mail.parentNode.className = "invalid";
                alert('E-mail non valide');
                verification = false;
            } else {
                mail.style.borderColor = "#ccc";
                mail.parentNode.className = "";
            }
        } else {
            missmail.textContent = "  Veuillez renseigner votre mail";
            missmail.style.color = "red";
            verification = false;
        }
        //    Vérification du nom
        if (nom.value == "") {
            nom.style.borderColor = "red";
            nom.setAttribute("placeholder", "VOTRE NOM !!!");
            missnom.textContent = "  Veuillez renserigner votre nom";
            missnom.style.color = "red";
            verification = false;
            console.log(verification);
        } else {
            nom.style.borderColor = "#ccc";
            nom.parentNode.className = "";
            //passe le nom en majuscule
            var minus = nom.value;
            var maj = minus.toUpperCase();
            nom.value = maj;
        }

        //    Vérification du mot de passe
        if (password.value == "") {
            password.style.borderColor = "red";
            password.setAttribute("placeholder", "Mot de passe please !");
            misspass.textContent = "  Veuillez indiquer un mot de passe";
            misspass.style.color = "red";
            verification = false;
            console.log(verification);
        } else {
            password.style.borderColor = "#ccc";
            password.parentNode.className = "";

        }
        console.log(verification);
        //Envoi de la requête 
        if (verification == true) {
            document.getElementById("premiereconnex").submit();
        }

    });
}


$(document).ready(function () {
    ajouter();
    validation();
    ajoutaliment();
    ajouterstock();
    premconnex();
    // $('#myTable').DataTable();

});
