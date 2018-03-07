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
        panierVide.textContent = "";
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
        // console.log(input);
        $("#modalheader").html("");
        $("#modalbody").html("");
        $("#modalfooter").html("");
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
                var longueurTab = messagedecode.Contenu.length;




                $("#modalheader").append("<div id='contenumodalheader'><h3>Nom du fournisseur :" + fournisseur +"</h3><br><h4>Numéro de la commande :" + commande +"</h4></div><div class='clearfloat'") ;
                $("#modalbody").append("<div id='contenumodalbody'>") ;

                for (var i = 0; i < longueurTab; i++) {
                    var ref = messagedecode.Contenu[i]["ref"];
                    var qte = messagedecode.Contenu[i]["qte"];


                    $("#modalbody").append("<div class='soulignement' id='contenumodalbody"+i+"'><div id='refproduit'>Reférence du produit :" + ref +"  - Quantité  :" + qte +"</div><div id='ajoutcheckbox' >     <input type='checkbox' id='" + i +" 'data-ref='" + ref + "' data-qte='" + qte + "'></div><br>") ;
                    $("#modalbody").append("");
                    $("#modalbody").append("<br/>");



                }
                $("#modalbody").append("</div>");
                $("#modalfooter").append("<div id='contenumodalfooter'><button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button><button id='cochertous' class=\"btn btn-danger\" type=\"submit\">Cocher tous</button><button id='enregistrercommande' class=\"btn btn-primary\" type=\"submit\">Valider les produits sélectionnés</button></div>");


                cochertous();
                enregistrercommande();
            }

        });

    })


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

        // Vérification du téléphone
        if (tel.value !== "") {
            var telValue = tel.value;
            var regExp2 = /(\+\d+(\s|-))?0\d(\s|-)?(\d{2}(\s|-)?){4}/;

            if (!regExp2.test(telValue)) {
                tel.style.borderColor = "red";
                tel.parentNode.className = "invalid";
                alert('Tel non valide');
                verification = false;
            } else {
                tel.style.borderColor = "#ccc";
                tel.parentNode.className = "";
            }
        }

        console.log(verification);
        //Envoi de la requête 
        if (verification == true) {
            document.getElementById("premiereconnex").submit();
        }

    });
}

function verifierPanier() {
    $("#verifPanier").click(function (e) {
        e.preventDefault();
        var nbLigne = document.getElementById("nbreLignes").textContent;
        //console.log(nbLigne);        
        if (nbLigne == 0) {
            panierVide.textContent = " Votre panier est vide!";
            panierVide.style.color = "red";
        } else {
            document.getElementById("verifOk").submit();
        }

    });
}


function retourHaut() {
    var duration = 500;
//  window.scroll(function() {
//    if ($(this).scrollTop() > 100) {
//      // Si un défillement de 100 pixels ou plus.
//      // Ajoute le bouton
//      $('.cRetour').fadeIn(duration);
//    } else {
//      // Sinon enlève le bouton
//      $('.cRetour').fadeOut(duration);
//    }
//  });

    $('.cRetour').click(function (event) {
        // Un clic provoque le retour en haut animé.
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, duration);
        return false;
    })
}

function cochertous() {
    $("#cochertous").click(function () {
        var checkbox = document.getElementById("modalbody").getElementsByTagName("input");
        console.log(checkbox);
        var longueurcheckbox = checkbox.length;
        for (var i = 0; i < longueurcheckbox; i++) {
            checkbox[i].setAttribute("checked", "checked");
        }

    });
}

function enregistrercommande() {
    $("#enregistrercommande").click(function () {
        var produitscoches = $("#modalbody input");
        //console.log(produitscoches);
        produitscoches.each(function () {
            var checked = $(this).prop("checked");
            console.log($(this));

            var ref = $(this).attr('data-ref');
            var qte = $(this).attr('data-qte');
            if (checked == true) {

                $.ajax({
                    type: "POST",
                    dataType: "text",
                    data: {
                        ref: ref,
                        qte: qte
                    },
                    url: "index.php?Controller=Admin&action=validLigneAliment",
                    success: function (message) {
                        console.log(message);},
                    error: function (message) {
                        console.log(message);
                    }

                });
            }
        });
        // confirm("refresh ?");

        sleep(1000);
        $(".modal").fadeOut(2000);
        $(".modal-backdrop").fadeOut(2000);
        $("body").removeClass();
        modalfooter.innerHTML += "<p color='red'>Commande ajoutée au stock !<p><br>";
        // sleep(3000);
        // window.location = "index.php?Controller=Admin&action=listeStockAliment";
        $(".form-inline").append("<div id='messagevalidstock'>Cliquez sur rafraichir pour mettre à jour votre stock</div>");

    })


}

function sleep(milliSeconds){
    var startTime = new Date().getTime();
    while (new Date().getTime() < startTime + milliSeconds);
}

$(document).ready(function () {
    ajouter();
    validation();
    ajoutaliment();
    premconnex();
    verifierPanier();
    retourHaut();
    sleep();

    // $('#myTable').DataTable();

});
