<template>
  <div class="col-md-8 text-justify">
      <div v-if="loading">
          chargement...
      </div>
      <div v-else>

      
      <h1>Récapitulatif de votre commande</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <div>
          <h2>Vos informations <b-button v-b-modal.modal-address><img src="https://simulateur.2020.le-site-francais.fr/assets/Shape.png" alt="stylo"></b-button></h2>
          <address>
            Prénom, Nom: {{prenom}} {{nom}}<br>
            Email : {{email}} <br>
            N° de téléphone : {{telephone}} <br>
            Société : {{societe}} <br>
            Adresse : {{adresse}} <br>
            Code postal, Ville : {{cp}} {{ville}} <br>
            N° de Siret : {{siret}}
          </address>
            <b-modal id="modal-address">
                <b-form>
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
                            <label for="siret">Siret</label><span v-b-popover.hover.topright="'Lorem ipsum'"><img src="https://2020.le-site-francais.fr/simulateur/lsfv2/src/assets/i.png" alt="icone information"></span>
                            <b-form-input type="text" v-model="siret" class="form-control" placeholder="12345678901234" :state="siretState"></b-form-input>
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="adresse">Adresse</label>
                            <b-form-input type="text" v-model="adresse" class="form-control" placeholder="9 rue Vauban"></b-form-input>
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="codePostal">Code postal</label>
                            <b-form-input type="text" v-model="cp" class="form-control" placeholder="33000"></b-form-input>
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="ville">Ville</label>
                            <b-form-input type="text" v-model="ville" class="form-control" placeholder="Bordeaux"></b-form-input>
                        </div>
                    </div>
                    <b-button pill :disabled="formComplet" type="submit" class="btn btn-contact">Continuer</b-button>
                </b-form>
            </b-modal>
      </div>
      <div>
          <h2>Votre structure</h2>
          <p>{{formule.titre}} {{formule.description}}</p>
      </div>
        <div>
          <h2>Vos fonctionnalités</h2>
          <ul id="listeFonctionnalitesPageRecap">
              <li v-for="(fonct, index) in fonctionnalites" :key="index">{{fonct.titre}} - {{fonct.description_courte}}</li>
          </ul>
      </div>
      <div>
          <h2>J'achète ou je loue</h2>
          <p v-if="type == 1">Location</p>
          <p v-else>Achat</p>
      </div>
      </div>
  </div>
</template>

<script>
export default {
    name: "Details",
    mounted() {
        this.prospectId = this.$route.params.prospectId;
        this.configId = this.$route.params.configId;
        this.formuleId = this.$route.params.formule;

        let one = this.axios.get('https://simulateur.2020.le-site-francais.fr/api/getProspects.php', {params: {idProspect: this.prospectId}});
        let two = this.axios.get('https://simulateur.2020.le-site-francais.fr/api/getConfiguration.php', {params: {idConfig: this.configId}});
        let three = this.axios.get('https://simulateur.2020.le-site-francais.fr/api/getFormules.php', {params: {idForm: this.formuleId}});
        let four = this.axios.get('https://simulateur.2020.le-site-francais.fr/api/getLinkConfigFonct.php', {params: {idConfig: this.configId}});

        this.axios
            .all([one, two, three, four])
            .then(
                this.axios.spread((...responses) => {
                    const responseOne = responses[0];
                    const responseTwo = responses[1];
                    const responseThree = responses[2];
                    const responseFour = responses[3];

                    this.configId = responseOne.data[0].configId;
                    this.prenom = responseOne.data[0].prenom;
                    this.nom = responseOne.data[0].nom;
                    this.email = responseOne.data[0].email;
                    this.telephone = responseOne.data[0].telephone;
                    this.societe = responseOne.data[0].societe;
                    responseOne.data[0].siret == "0" ? this.siret = "" : this.siret = responseOne.data[0].siret; // si retour bdd à 0, remplacer par ""
                    this.cp = responseOne.data[0].cp;
                    this.adresse = responseOne.data[0].adresse;
                    this.ville = responseOne.data[0].ville;

                    this.formule.id = responseTwo.data[0].formuleId;
                    this.type = responseTwo.data[0].type;
                    this.nbMensualites = responseTwo.data[0].nb_mensualites;
                    this.optionsSup.maintenance = responseTwo.data[0].maintenance;
                    this.optionsSup.hebergement = responseTwo.data[0].hebergement;
                    this.prixTotal = responseTwo.data[0].prix_total;
                    let prix = 0;
                    this.type == 1 ? prix = this.prixTotal / this.nbMensualites : prix = this.prixTotal;
                    this.$emit("prixConfig", prix);
                    this.$emit("type", this.type);
                    
                    this.formule.titre = responseThree.data[0].nom;
                    this.formule.description = responseThree.data[0].description;
                    
                    if(responseFour.data.length !== 0) {
                        if(responseFour.data.length === 1) this.idsFonctions.push(responseFour.data[0].fonctId);
                        else {
                            responseFour.data.forEach(element => 
                                this.idsFonctions.push(element.fonctId)    
                            );
                        } 
                        
                    } else {
                        console.log('pas de fonctionnalité');
                    }
                })
            )
            .catch(error => console.log(error))
            .finally(() => this.loading = false)
    },
    computed: {
        emailState() { // Vérification champ email
            let re = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/
            return re.test(this.email)     
        },
        telState() { // Vérification champ tel
            let re = /^(0)[1-9](\d{2}){4}$/
            return re.test(this.telephone)
        },
        nomState() { // Vérification champ nom > à 0 caractère
            return this.nom.length > 0 ? true : false
        },
        prenomState() { // Vérification champ prénom > à 0 caractère
            return this.prenom.length > 0 ? true : false
        },
        societeState() { // Vérification champ société > à 0 caractère
            return this.societe.length > 0 ? true : false
        },
        siretState() { // verifier la longueur du siret
            let re = /[0-9]{3}[ .-]?[0-9]{3}[ .-]?[0-9]{3}[ .-]?[0-9]{5}$/
            return re.test(this.siret)
        },
        formComplet() { // option disabled retirée lorsque le formulaire est complété
            if(this.prenom !== "" && this.nom !== "" && this.email !== "" && this.telephone !== "" && this.societe !== "") {
                return false
            } else {
                return true
            }
        }
    },
    data() {
        return {
            loading: true,
            prospectId: "",
            configId: "",
            prenom: "",
            nom: "",
            email: "",
            telephone: "",
            societe: "",
            siret: "",
            cp: "",
            adresse: "",
            ville: "",
            formule: {
                id: "",
                titre: "",
                description: ""
            },
            idsFonctions: [],
            fonctionnalites: [
            ],
            type: "",
            nbMensualites: 48,
            montantTotal:0,
            optionsSup: {
                maintenance: 1,
                hebergement: 1
            },
            prixTotal: 0
        }
    },
    watch: {
        idsFonctions() {
            this.idsFonctions.forEach(element => 
            this.axios
                .get('https://simulateur.2020.le-site-francais.fr/api/getFonct.php', {params: {idFonct: element}})
                .then(response5 => 
                {
                    let objFonct = {
                        titre: response5.data[0].nom,
                        description_courte: response5.data[0].description_courte
                    }
                    this.fonctionnalites.push(objFonct);
                })
                .catch(error => console.log(error))
            )
        },
        adresse() {
            this.areAddressAndSiretOk();
        },
        siret() {
            this.areAddressAndSiretOk();
        },
        cp() {
            this.areAddressAndSiretOk();
        },
        ville() {
            this.areAddressAndSiretOk();
        }
    },
    methods: {
        areAddressAndSiretOk() {
            console.log('is it me you\'re looking for?');
            if(this.siret != "" && this.adresse != "" && this.cp != "" && this.ville != "") this.$emit("champsOk", true);
        }
    }
}
</script>

<style>

</style>