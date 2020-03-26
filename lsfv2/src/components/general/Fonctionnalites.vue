<template>
  <div id="fonctionnalites" role="tablist" v-if="formulesValid">
    <b-card v-for="categorie in categories" :key="categorie.id" no-body class="mb-1 accordion-lsf">
      <b-card-header header-tag="header" class="p-1 card-header-lsf" role="tab">
        <b-button 
            class="button-accordion-lsf" 
            block href="#" 
            v-b-toggle="categorie.idAccordion" 
            variant="info">
                <span class="float-left">{{categorie.nom}}</span>
                <span v-if="categorie.nbSelectionnes >1" class="float-right">{{categorie.nbSelectionnes}} sélectionnés</span>
                <span v-else class="float-right">{{categorie.nbSelectionnes}} sélectionné</span>
        </b-button>
      </b-card-header>
      <b-collapse v-for="(fonctionnalite, index) in categorie.listeFonctionnalites" :key="index" class="card-body-lsf" :id="categorie.idAccordion" :visible="categorie.visible" accordion="my-accordion" role="tabpanel">
        <b-card-body class="d-flex flex-row justify-content-between">
          <b-card-text>
                <img :src="fonctionnalite.icone" :alt="fonctionnalite.nom"> 
          </b-card-text>
          <b-card-text>
                <h3>{{fonctionnalite.nom}}</h3>
                <p>{{fonctionnalite.description_courte}} En savoir plus</p>
          </b-card-text>
          <b-card-text v-if="fonctionnalite.selection">
                <img src="https://simulateur.2020.le-site-francais.fr/assets/badge.png" alt="badge">
          </b-card-text>
          <b-card-text>
                <input type="checkbox" v-model="fonctSelected" :value="fonctionnalite.id" v-on:change="incrementCat(categorie.id, fonctionnalite.id)">
          </b-card-text>
        </b-card-body>
      </b-collapse>
    </b-card>
    <b-button pill type="btn" class="btn btn-contact" v-on:click="toChoixType">Continuer</b-button>
  </div>
</template>

<script>

export default {
    mounted() {
        this.axios
            .get('https://simulateur.2020.le-site-francais.fr/api/getFonct.php')
            .then(response => {
                this.fonctionnalites = response.data;
                this.fonctionnalites.forEach(element => { // classe les fonctionnalités par catégories
                    switch(element.categorie) {
                        case 1:
                            this.categories[1].listeFonctionnalites.push(element);
                            break;
                        case 2:
                            this.categories[2].listeFonctionnalites.push(element);
                            break;
                        case 3:
                            this.categories[3].listeFonctionnalites.push(element);
                            break;
                        case 4:
                            this.categories[4].listeFonctionnalites.push(element);
                            break;
                    }
                });
            })
            .catch(error => console.log(error));    
    },
    name: "Fonctionnalites",
    props: {
        idCat: {
            type: String
        },
        affichage: {
            type: Boolean
        },
        typeChoix: {
            type: String
        },
    },
    data() {
        return {
            fonctSelected: [],
            fonctionnalites: [], // Appel en bdd
            selections: [],
            categories: [
                {
                    "id": 0,
                    "nom": "notre sélection pour vous",
                    "nbSelectionnes": 0,
                    "idAccordion": "accordion-1",
                    "visible": true,
                    "listeFonctionnalites": [] // Appel via f° watch idCat
                },
                {
                    "id": 1,
                    "nom": "présenter son activité",
                    "nbSelectionnes": 0,
                    "idAccordion": "accordion-2",
                    "visible": false,
                    "listeFonctionnalites": [] // Appel en bdd
                },
                {
                    "id": 2,
                    "nom": "attirer localement",
                    "nbSelectionnes": 0,
                    "idAccordion": "accordion-3",
                    "visible": false,
                    "listeFonctionnalites": [] // Appel en bdd
                },
                {
                    "id": 3,
                    "nom": "générer des prospects",
                    "nbSelectionnes": 0,
                    "idAccordion": "accordion-4",
                    "visible": false,
                    "listeFonctionnalites": [] // Appel en bdd
                },
                {
                    "id": 4,
                    "nom": "autres",
                    "nbSelectionnes": 0,
                    "idAccordion": "accordion-5",
                    "visible": false,
                    "listeFonctionnalites": [] // Appel en bdd
                },
                {
                    "id": 5,
                    "nom": "récap",
                    "nbSelectionnes": 0,
                    "idAccordion": "accordion-6",
                    "visible": false,
                    "listeFonctionnalites": [] // Appel via f° watch fonctSelected
                }
            ],
            formulesValid: false,
            locationOuAchat: "Location"
        }
    },
    watch: {
        idCat: function() {
            // Sélection des fonctionnalités en F° du secteur d'activité
            for(let a=0 ; a<this.fonctionnalites.length ; a++) { // Remise à false de la propriété selection de toutes les fonctionnalités en cas de changement de secteur d'activité
                this.fonctionnalites[a].selection = false;
            }
            let listeFonct = "";
            this.axios
                .get('https://simulateur.2020.le-site-francais.fr/api/getSecteurActivite.php', {params: {idCat: this.idCat}})
                .then(response => {
                    listeFonct = response.data; // retourne une chaine de caractères avec 3 id espacés par des ","
                    let arrayFonctionnalites = listeFonct.split(",");
                    for(let i=0; i<arrayFonctionnalites.length ; i++) { 
                        let idFonct = +arrayFonctionnalites[i];
                        let idFonctionnalitesToModify = this.fonctionnalites.findIndex(fonct => fonct.id == idFonct); // On cherche dans le tableau des toutes les fonctionnalités celles qui correspondent à la selection
                        this.fonctionnalites[idFonctionnalitesToModify].selection = true; // on met leur propriété selection à true
                    }
                    this.addToSelections();
                })
                .catch(error => console.log(error));
        },
        fonctSelected: function() {
            this.$emit("listeFonctionnalites", this.fonctSelected);
            this.categories[5].listeFonctionnalites = []; // Vide la variable
            this.prixTotalFonctionnalites = 0; // Vide la variable
            this.categories[5].nbSelectionnes = 0; // Vide la variable
            for(let i=0 ; i<this.fonctSelected.length ; i++) {
                this.categories[5].listeFonctionnalites.push(this.fonctionnalites[this.fonctSelected[i]-1]); // Affiche les fonctionnalités cochées dans "récap"
                this.categories[5].nbSelectionnes ++;
            }
        },
        affichage: function() {
            this.formulesValid = true;
        },
        typeChoix: function() { // Si changement location/achat
            this.locationOuAchat = this.typeChoix;
        }
    },
    updated() {
        this.getToTheNextAnchor();
    },
    methods: {
        getToTheNextAnchor: function() {
            this.$scrollTo('#fonctionnalites', 1000, { easing: 'ease' });
        },
        toChoixType: function() {
            this.$emit("btnGoToChoixType", true);
        },
        incrementCat: function(idCategorie, idFonctionnalite) { // Incrémente ou décrémente le nb d'options selectionnées
            if(this.fonctSelected.indexOf(idFonctionnalite) !== -1){
                this.categories[idCategorie].nbSelectionnes++;
            } else {
                this.categories[idCategorie].nbSelectionnes--;
            }
        },
        addToSelections: function() { // Rempli la variable selections avec les 3 fonctions recommandées
            this.selections = [];
            for(let j=0 ; j<this.fonctionnalites.length ; j++) {
                if(this.fonctionnalites[j].selection === true) {
                    this.selections.push(this.fonctionnalites[j]);
                    this.categories[0].listeFonctionnalites = this.selections; // rempli la liste des fonctionnalités selectionnées par rapport au secteur d'activité
                }
            }
        }
    }
}
</script>

<style>
    #accordion button, #accordion span {color: #fff;}
    .button-accordion-lsf span {
        line-height: 80px;
        vertical-align: middle;
    }
    .card-body-lsf { width: 80%; margin: 0 auto; border: 1px solid #5D93FF; border-radius: 5px; background-color: #EAF1FF; margin-top: 15px; max-height: 70px;}
</style>