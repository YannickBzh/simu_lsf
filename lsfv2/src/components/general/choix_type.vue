<template>
<div id="choixType" v-if="fonctionnalitesValid">
    <h2>J'achète ou je loue ?</h2>
    <div class="row">
        <div class="col-md-6">
            <b-card 
                id="location" 
                title="Location" 
                class="mb-2 mt-4 card-choix-lsf-selected" 
                v-on:click="typeSelected('location')"
                style="min-height: 400px">
                <b-card-text>
                <span>{{montantMensuel}}</span>€/Mois
                </b-card-text>
                <b-form-select v-model="nbMois" :options="choixNbMois">
                    <template v-slot:first>
                        <b-form-select-option :value="null" disabled>-- Sélectionnez le nombre de mois --</b-form-select-option>
                    </template>
                </b-form-select>
            </b-card>
        </div>
        <div class="col-md-6">
            <b-card 
                id="achat" 
                title="Achat" 
                class="mb-2 mt-4 card-choix-lsf" 
                v-on:click="typeSelected('achat')"
                style="min-height: 400px">
                <b-card-text>
                <span>{{montantAchat}}</span>€/Mois
                </b-card-text>
                <b-form-checkbox
                    v-model="hebergement"
                    name="hebergement">
                    Hébergement
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="maintenance"
                    name="maintenance">
                    Maintenance
                </b-form-checkbox>
            </b-card>
        </div>
        <div class="col-md-12">
            <b-alert :show="allDatasNotGiven" variant="danger">{{messageErreur}}</b-alert>
        </div>
        <b-button pill type="btn" class="btn btn-contact" v-on:click="envoiVersRecap">Envoyer ma demande</b-button>
    </div>
</div>
  
</template>

<script>
export default {
    name: "ChoixType",
    props: {
        msg: {
            type: String
        },
        affichage: {
            type: Boolean
        },
        formule: {
           type: Number 
        },
        listeFonct: {
            type: Array
        },
        prixtotal: {
            type: Number
        }
    },
    data() {
        return {
            nbMois: null,
            locationOuAchat: "location", // rempli via f° "typeSelected"
            typeChoix: 1,  //rempli via watch locationOuAchat
            hebergement: true,
            maintenance: true,
            choixNbMois: [
                {"value": 48, "text": "48 mois"},
                {"value": 36, "text": "36 mois"},
                {"value": 24, "text": "24 mois"}
            ],
            prospectId: "",
            fonctionnalitesValid: false,
            allDatasNotGiven: false,
            messageErreur: "",
            choixFormule: 2, // rempli via le watch de formule
            configId: null,
            listFonctionnalites: null, // rempli par le watch listeFonct
            montantMensuel: 69, //rempli soit par watch prixtotal, soit nbMois
            montantAchat: 0,
        }
    },
    watch: {
        msg: function() {
            this.prospectId = this.msg;
        },
        affichage: function() {
            this.fonctionnalitesValid = true
        },
        formule: function() {
            this.choixFormule = this.formule;
        },
        locationOuAchat: function() {
            this.$emit("choixType", this.locationOuAchat.charAt(0).toUpperCase() + this.locationOuAchat.substring(1).toLowerCase());
            this.locationOuAchat === "location" ? this.typeChoix = 1 : this.typeChoix = 2; 
        },
        listeFonct: function() {
            this.listFonctionnalites = this.listeFonct;
        },
        prixtotal: function() {
            if(this.locationOuAchat === "location") {
                this.montantMensuel = this.prixtotal;  
                this.montantAchat = 0;
            } else {
                this.montantAchat = this.prixtotal;  
                this.montantMensuel = 0;
            }
               
        },
        nbMois: function() {
            this.$emit("nbMois", this.nbMois);
        }
    },
    updated() {
        this.getToTheNextAnchor();
    },
    methods: {
        typeSelected: function(type) {
            // On remet les div en blanc
            document.getElementById("location").className = "mb-2 mt-4 card-choix-lsf";
            document.getElementById("achat").className = "mb-2 mt-4 card-choix-lsf";
            this.locationOuAchat = type;
            document.getElementById(type).className = "mb-2 mt-4 card-choix-lsf-selected";
        },
        getToTheNextAnchor: function() {
            this.$scrollTo('#choixType', 1000, { easing: 'ease' });
        },
        envoiVersRecap: function() {
            if(this.locationOuAchat === null){
                this.allDatasNotGiven = true;
                this.messageErreur = "Vous devez sélectionner 'Location' ou 'Achat'";
            } 
            else {
                if(this.nbMois === null && this.locationOuAchat != "achat") {
                    this.allDatasNotGiven = true;
                    this.messageErreur = "Vous devez sélectionner le nombre de mois de votre location";
                    return;
                }
                else {
                    let prix_total= 0;
                    this.locationOuAchat == "location" ? prix_total = parseInt(this.montantMensuel)*parseInt(this.nbMois) : prix_total = parseInt(this.montantAchat);
                    this.axios
                        .post('https://simulateur.2020.le-site-francais.fr/api/setConfiguration.php', {
                            formuleId: parseInt(this.choixFormule),
                            type: this.typeChoix,
                            nb_mensualites: parseInt(this.nbMois),
                            hebergement: this.hebergement,
                            maintenance: this.maintenance,
                            prixTotal: prix_total
                        })
                        .then(response => {
                            this.configId = response.data;
                            this.requestSetProspect();
                        })
                        .catch(error => (console.log(error)));
                }       
            } 
        },
        requestSetProspect: function() {
            let router = this.$router;
            if(this.prospectId.length < 1 || isNaN(this.prospectId)) {
                this.allDatasNotGiven = true;
                this.messageErreur = "Un problème est survenu veuillez raffraichir la page et recommencer la simulation";
                return;
            }
            this.axios
                .post('https://simulateur.2020.le-site-francais.fr/api/setProspect.php', {
                    prospectId: parseInt(this.prospectId),
                    configId: this.configId,
                    config_validee: 1
                })
                .then(response => {
                    this.prospectId = response.data;
                    if(this.listFonctionnalites != null) {
                        this.listFonctionnalites.forEach(element => this.requestSetLcf(element, this.prospectId, this.configId, this.choixFormule, this.nbMois));
                    }
                    else {
                        router.push({name: "Recap", params:{ prospectId: this.prospectId, configId: this.configId, formule: this.choixFormule, nbDeMensualites: this.nbMois}}); // Envoi vers la page recap
                    }
                })
                .catch(error => (console.log(error)));
        },
        requestSetLcf: function(element, prospectId, configId, choixFormule, nbMois) {
            let router = this.$router;
            this.axios
                .post('https://simulateur.2020.le-site-francais.fr/api/setLinkConfigFonct.php', {
                    configId: this.configId,
                    fonctId: parseInt(element)
                })
                .then(function() {
                    router.push({name: "Recap", params:{ prospectId: prospectId, configId: configId, formule: choixFormule, nbDeMensualites: nbMois}}); // Envoi vers la page recap
                })
                .catch(error => (console.log(error)));
        }
    }
}
</script>

<style>
    .card-choix-lsf { cursor: pointer; border: 1px solid #5d93FF; border-radius: 5px}
    .card-choix-lsf h4, .card-choix-lsf-selected span { color: #5d93FF; }
    .card-choix-lsf-selected { cursor: pointer; background-color: #5d93FF !important; border-radius: 5px}
    .card-choix-lsf-selected h4, .card-choix-lsf-selected span { color: #fff; }
</style>