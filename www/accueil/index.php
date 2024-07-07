<?php require_once (__DIR__ . '/../includes/header.php'); ?>

<link rel="stylesheet" href="style.css">
<main>
    <!-- intro -->
    <div class="intro">
        <h1 class="parc">parc animalier arcadia</h1>
        <div class="sousTitre">
            <h3 class="eco">éco-responsable</h3>
        </div>
        <p class="lorem">Depuis 1960, le Zoo Écologique de la Forêt de Brocéliande s'inscrit dans le respect de la
            nature de la légendaire forêt de Brocéliande en Bretagne. Venez explorer nos habitats naturels et
            découvrir notre engagement en faveur de la conservation environnementale.</p>
        <img src="assets/lion-accueil.png" alt="" class="lion">
    </div>
    <!-- ------------- fin intro----------- -->
    <!-- /* -----------icons-------------*/-->
    <div class="icons">
        <img src="assets/icons-accueil.png" alt="">
    </div>
    <!-- /* ----------- fin icons-------------*/-->
    <!-------------services--------------->

    <div class="services">
        <div class="lesServices">
            <h3 class="titreServices">Les services</h3>
            <p class="description">Découvrez notre restaurant, notre petit train et bénéficiez d'un guide gratuit
                pour enrichir votre expérience au Zoo Écologique de la Forêt de Brocéliande.</p>
            <img class="fleche" src="assets/fleches-accueil.png" alt="fleche pour acceder aux services">
            <div class="autruche"></div>
        </div>
        <div class="zebre">
        </div>
    </div>



    <!------------- fin services--------------->
    <!------------- block habitats--------------->
    <div class="block">
        <div class="energie">
            <h3 class="titreEnergie">Le premier zoo au monde <br> 100% autonome en energie</h3>
        </div>
        <div class="animaux">
            <h3 class="titreAnimaux">LES ANIMAUX</h3>
            <p class="paragrapheAnimaux">Rencontrez nos résidents exceptionnels, <br>élevés dans un environnement
                respectueux de leur bien-être et de la nature.</p>
            <img src="assets/paresseux-accueil.png" alt="" class="paresseux">
            <img class="flecheAnimaux" src="assets/fleches-accueil.png" alt="">
        </div>
        <div class="carrousel"></div>
        <a class="habitats" href="/habitats">
            <h3 class="titreHabitats">LES HABITATS</h3>
            <p class="paragrapheHabitats">Explorez notre variété d'animaux <br>dans des habitats reconstitués :
                <br>la jungle luxuriante, les marais préservés<br> et la savane durablement aménagée.
            </p>
            <img src="assets/toucan-accueil.png" alt="" class="toucan">
            <img class="flecheHabitats" src="assets/fleches-accueil.png" alt="">
        </a>
    </div>
    <!------------- fin block habitats--------------->
    <!------------- avis--------------->
    <div class="commentaire">
        <div class="avis">
            <h3 class="titreAvis">Votre avis compte !</h3>
        </div>
        <div class="commentaireCarrousel">
            <img class="photoUtilisateur" src="assets/avis.png" alt="">
            <p class="commentairePseudo">Pierre H</p>
            <p class="commentaireUtilisateur"> "super visite !!"</p>
        </div>
        <div class="formulaireAvis">
            <form action="formulaire.php" method="post">
                <div class="champ">
                    <label for="pseudo">Votre pseudo</label>
                    <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo">
                </div>
                <div class="champ">
                    <label for="commentaire">Votre commentaire</label>
                    <div class="commentaire-container">
                        <textarea id="commentaire" name="commentaire" rows="5" cols="30"
                            placeholder="Laissez votre commentaire"></textarea>
                        <button type="submit">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!------------- fin avis--------------->
</main>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>