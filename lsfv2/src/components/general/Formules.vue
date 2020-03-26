<template>
    <div id="formule" v-if="formGeneralValid">
        <h2>Je choisis la structure de mon site<span class="color-blue">.</span></h2>
        <div class="row">
            <div class="col-md-12">
                <h3>Toujours inclus dans votre <span class="blue-text">achat / location de site Internet</span> :</h3>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <ul class="fonctDeBase">
                            <li>
                                <div class="d-inline-flex">
                                    <h4>Google Analytics</h4>
                                    <p>Offert</p>
                                    <b-img src="https://simulateur.2020.le-site-francais.fr/assets/check.png" alt="picto check" height="14px"></b-img>
                                </div>    
                                <p>je souhaite présenter les informations essentielles à mes visiteurs sur 1 seule page.
                                    Plus d'informations
                                </p>
                            </li>
                            <li>
                                <div class="d-inline-flex">
                                    <h4>Référence naturel</h4>
                                    <p>Offert</p>
                                    <b-img src="https://simulateur.2020.le-site-francais.fr/assets/check.png" alt="picto check" height="14px"></b-img>
                                </div> 
                                <p>je souhaite présenter les informations essentielles à mes visiteurs sur 1 seule page.
                                    Plus d'informations
                                </p>
                            </li>
                            <li>
                                <div class="d-inline-flex">
                                    <h4>Formulaire de contact standard</h4>
                                    <p>Offert</p>
                                    <b-img src="https://simulateur.2020.le-site-francais.fr/assets/check.png" alt="picto check" height="14px"></b-img>
                                </div> 
                                <p>je souhaite présenter les informations essentielles à mes visiteurs sur 1 seule page.
                                    Plus d'informations
                                </p>
                            </li>
                            <li>
                                <div class="d-inline-flex">
                                    <h4>Google Maps</h4>
                                    <p>Offert</p>
                                    <b-img src="https://simulateur.2020.le-site-francais.fr/assets/check.png" alt="picto check" height="14px"></b-img>
                                </div> 
                                <p>je souhaite présenter les informations essentielles à mes visiteurs sur 1 seule page.
                                    Plus d'informations
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <ul class="fonctDeBase">
                            <li>
                                <div class="d-inline-flex">
                                    <h4>Maintenance</h4>
                                    <p>Offert</p>
                                    <b-img src="https://simulateur.2020.le-site-francais.fr/assets/check.png" alt="picto check" height="14px"></b-img>
                                </div> 
                                <p>je souhaite présenter les informations essentielles à mes visiteurs sur 1 seule page.
                                    Plus d'informations
                                </p>
                            </li>
                            <li>
                                <div class="d-inline-flex">
                                    <h4>Hébergement</h4>
                                    <p>Offert</p>
                                    <b-img src="https://simulateur.2020.le-site-francais.fr/assets/check.png" alt="picto check" height="14px"></b-img>
                                </div> 
                                <p>je souhaite présenter les informations essentielles à mes visiteurs sur 1 seule page.
                                    Plus d'informations
                                </p>
                            </li>
                            <li>
                                <div class="d-inline-flex">
                                    <h4>Nom de domaine + 3 emails pro</h4>
                                    <p>Offert</p>
                                    <b-img src="https://simulateur.2020.le-site-francais.fr/assets/check.png" alt="picto check" height="14px"></b-img>
                                </div>
                                <p>je souhaite présenter les informations essentielles à mes visiteurs sur 1 seule page.
                                    Plus d'informations
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12" v-for="formule in typesFormules" :key="formule.id">       
                <b-card-group deck>
                    <b-card
                        border-variant="primary"
                        header-bg-variant="transparent"
                        header-text-variant="white"
                        align="center">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text group-text-lsf">
                                <b-form-checkbox 
                                    v-model="formuleChoisie" 
                                    :value="formule.id"
                                    name="formule"></b-form-checkbox>
                                </div>
                            </div>
                            <span>Je le veux</span>
                        </div>
                        <b-card-text>
                            <h4 class="card-title">{{formule.nom}}</h4>
                            <p class="card-text">{{formule.description}}</p>
                            <b-button v-b-modal="formule.modal">> Plus d'infos</b-button>
                        </b-card-text>
                    </b-card>
                </b-card-group>
            </div>
            <Modal1 :is="'modal1'"></Modal1>
            <Modal2 :is="'modal2'"></Modal2>
            <Modal3 :is="'modal3'"></Modal3>
            <b-button pill type="btn" class="btn btn-contact" v-on:click="toFonctionnalites">Continuer</b-button>         
        </div>
    </div>
</template>

<script>
import axios from 'axios'

import Modal1 from './modals/modal_1.vue'
import Modal2 from './modals/modal_2.vue'
import Modal3 from './modals/modal_3.vue'

export default {
    mounted() {
        axios
            .get('https://simulateur.2020.le-site-francais.fr/api/getFormules.php')
            .then(response => (this.typesFormules = response.data))
            .catch(error => console.log(error))
    },
    name: "Formules",
    props: {
        idProspect: {
            type: String
        }
    },
    components: {
        Modal1,
        Modal2,
        Modal3
    },
    data() {
        return {
            typesFormules: [], // Appel bdd
            formuleChoisie: 2,
            formGeneralValid: false,
            prixFormule: 0 // À remplir dynamiquement en f° du type (location ou achat) choisi 
        }
    },
    watch: {
        formuleChoisie: function() {
            this.$emit("inputFormule", parseInt(this.formuleChoisie));
        },
        idProspect: function() {
            this.formGeneralValid = true;
        }
    },
    updated() {
        this.getToTheNextAnchor();
    },
    methods: {
       getToTheNextAnchor: function() {
            this.$scrollTo('#formule', 1000, { easing: 'ease' });
        },
        toFonctionnalites: function() {
            if(this.formuleChoisie !== "") this.$emit("btnNextCliqued", true);
        }
    }
}
</script>

<style>
    .fonctDeBase {
        list-style: none;
        padding-left: 0;
    }
</style>