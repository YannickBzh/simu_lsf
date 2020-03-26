<template>
    <div class="col-md-3">
        <div>
            <img src="https://simulateur.2020.le-site-francais.fr/assets/left_arrow.png" alt="fleche gauche">
            <span><a href="https://le-site-francais.fr">Retour vers le site</a></span>
        </div>
        <h2>{{titre}}<span class="color-blue">.</span></h2>
        <p>{{description}}</p>
        <div>
            <img src="https://simulateur.2020.le-site-francais.fr/assets/aide.png" alt="point interrogation">
            <span>Besoin d'aide ?</span>
        </div>
        <div>
            <img src="https://simulateur.2020.le-site-francais.fr/assets/clock.png" alt="horloge">
            <span>Temps estimé: {{tempsRestant}}min</span>
        </div>
        <b-button pill class="btn btn-contact">Contactez-nous</b-button>
    </div>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            titre: "Informations",
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ",
            tempsRestant: "20",
        }
    }
}
</script>

<style>
    .sidebar {
        text-align: justify;
    }
</style>