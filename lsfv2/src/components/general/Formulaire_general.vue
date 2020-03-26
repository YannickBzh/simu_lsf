<template>
    <div id="formGeneral">
        <h2>Simulez votre tarif<span class="color-blue">.</span></h2>
        <b-form @submit="addProspect">
            <div class="form-row">
                <div class="form-group col-md-6 col-xs-12">
                    <label for="nom">Nom</label>
                    <b-form-input v-model="nom" class="form-control" placeholder="Nom" :state="nomState"></b-form-input>
                    <b-form-invalid-feedback>Nous avons besoin de votre nom</b-form-invalid-feedback>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="prenom">Prénom</label>
                    <b-form-input type="text" v-model="prenom" class="form-control" placeholder="Prenom" :state="prenomState"></b-form-input>
                    <b-form-invalid-feedback>Nous avons besoin de votre prénom</b-form-invalid-feedback>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="email">Email</label>
                    <b-form-input type="email" v-model="email" class="form-control" placeholder="hello@lsf.fr" :state="emailState"></b-form-input>
                    <b-form-invalid-feedback>Merci de renseigner une adresse mail valide</b-form-invalid-feedback>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="telephone">Téléphone</label>
                    <b-form-input type="tel" v-model="telephone" class="form-control" placeholder="0599887766" :state="telState"></b-form-input>
                    <b-form-invalid-feedback>Merci de renseigner un n° de téléphone valide</b-form-invalid-feedback>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="societe">Société</label>
                    <b-form-input type="text" v-model="societe" class="form-control" placeholder="LSF" :state="societeState"></b-form-input>
                    <b-form-invalid-feedback>Nous avons besoin du nom de votre société</b-form-invalid-feedback>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="secteur">Secteur d'activité</label>
                    <b-form-select class="form-control" v-model="secteurActivite" :options="listeSecteursActivites" :state="activiteState">
                    </b-form-select>
                    <b-form-invalid-feedback>Nous avons besoin de votre secteur d'activité</b-form-invalid-feedback>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="siret">Siret</label><span v-b-popover.hover.topright="'Lorem ipsum'"><img src="https://simulateur.2020.le-site-francais.fr/assets/i.png" alt="icone information"></span>
                    <b-form-input type="text" v-model="siret" class="form-control" placeholder="12345678901234" :state="siretState"></b-form-input>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="adresse">Adresse</label>
                    <b-form-input type="text" v-model="adresse" class="form-control" placeholder="9 rue Vauban"></b-form-input>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="codePostal">Code postal</label>
                    <b-form-input type="text" v-model="codePostal" class="form-control" placeholder="33000"></b-form-input>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="ville">Ville</label>
                    <b-form-input type="text" v-model="ville" class="form-control" placeholder="Bordeaux"></b-form-input>
                </div>
            </div>
            <b-button pill :disabled="formComplet" type="submit" class="btn btn-contact">Continuer</b-button> <!-- bouton non disabled si tous les champs required remplis -->
        </b-form>
    </div>
</template>

<script>
//import {myLoginRoutine} from '../../assets/js/connectingToZohoCRM'
export default {
    mounted() {
        this.axios
            .get('https://simulateur.2020.le-site-francais.fr/api/getSecteurActivite.php')
            .then(response => (this.listeSecteursActivites = response.data))
            .catch(error => console.log(error));
    },
    computed: {
        emailState() { // Vérification champ email
            if(this.email === "") return null
            else {
                let re = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/
                return re.test(this.email);
            }             
        },
        telState() { // Vérification champ tel
            if(this.telephone === "")return null
            else {
                let re = /^(0)[1-9](\d{2}){4}$/
                return re.test(this.telephone)
            }
        },
        nomState() { // Vérification champ nom > à 0 caractère
            if(this.nom === "")return null
            else return this.nom.length > 0 ? true : false
        },
        prenomState() { // Vérification champ prénom > à 0 caractère
            if(this.prenom === "")return null
            else return this.prenom.length > 0 ? true : false
        },
        societeState() { // Vérification champ société > à 0 caractère
            if(this.societe === "")return null
            else return this.societe.length > 0 ? true : false
        },
        activiteState() {  // Vérification champ secteur activité non null
            if(this.secteurActivite === null)return null
            else return this.secteurActivite > 0 ? true : false
        },
        siretState() { // verifier la longueur du siret
            if(this.siret === "")return null
            else {
                let re = /[0-9]{3}[ .-]?[0-9]{3}[ .-]?[0-9]{3}[ .-]?[0-9]{5}$/
                return re.test(this.siret)
            }
        },
        formComplet() { // option disabled retirée lorsque le formulaire est complété
            if(this.prenom !== "" && this.nom !== "" && this.email !== "" && this.telephone !== "" && this.societe !== "" && this.secteurActivite !== null) {
                return false
            } else {
                return true
            }
        }
    },
    watch: {
        codePostal: function() { // Vérification champ prénom > à 0 caractère
            let result = this.$CodesPostaux.find(this.codePostal)
            if(result[0].nomCommune != undefined ) this.ville = result[0].nomCommune
            else return this.ville = ""
        },
        secteurActivite: function() {
            if(this.prospectId !== "") {
                this.$emit("inputData", this.secteurActivite);
            } else {
                return;
            }
        }
    },
    name: "FormulaireGeneral",
    data() {
        return {
            prenom: "",
            nom: "",
            email: "",
            telephone: "",
            societe: "",
            secteurActivite: null,
            siret: "",
            codePostal: "",
            adresse: "",
            ville: "",
            listeSecteursActivites: [], // Appel en bdd
            partie1validee: false,
            prospectId: ""
        }
    },
    methods: {
        addProspect(evt) {
            this.$emit("inputData", this.secteurActivite); // Envoi de la donnée pour qu'elle soit dispo dans toute l'app
            evt.preventDefault();
            this.axios
                .post('https://simulateur.2020.le-site-francais.fr/api/setProspect.php', {
                    configId: "",
                    prenom: this.prenom,
                    nom: this.nom,
                    telephone: this.telephone,
                    email: this.email,
                    societe: this.societe,
                    secteur_activite: this.secteurActivite,
                    siret: this.siret,
                    cp: this.codePostal,
                    ville: this.ville,
                    adresse: this.adresse
                })
                .then(response => {
                    this.prospectId = response.data;
                    this.$emit("inputData2", this.prospectId);
                    //this.sendToZoho();
                })
                .catch(error => (console.log(error)))
        },
        verifyStateName() {
            return this.nom.length > 0 ? true : false
        },
        /*sendToZoho() {
            this.axios
                .post("https://accounts.zoho.eu/oauth/v2/token", {
                    headers: { 
                        'Access-Control-Allow-Origin': 'http://localhost:8080',
                        'Content-Type': 'application/json'
                    },
                    client_id: "1000.54YEA59SUQ8ITERJO5YC2R1MMXRTPR",
                    client_secret: "717a3e8e706b4a55d54ae4b0e00ddb32019353db8b",
                    refresh_token: "1000.0979c5b0413433840d671c3886d73e54.8e9ed8a1a33eb9e6736b9d63fa882de9",
                    grant_type: "1000.0979c5b0413433840d671c3886d73e54.8e9ed8a1a33eb9e6736b9d63fa882de9"
                })
                .then(response => {
                    response.headers.add('Access-Control-Allow-Origin', '*');
                    console.log(response.data);
                })
                .catch(error => console.log(error));
        }*/
    }
}
</script>

<style>
    
</style>