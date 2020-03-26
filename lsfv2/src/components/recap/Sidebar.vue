<template>
  <div class="col-md-4">
      <b-card>
          <b-card-header>
              <h3>Votre panier</h3>
          </b-card-header>
          <b-card-body>
              <b-card-text>
                  <p>À payer chaque mois</p>
                  <p v-if="type == 1">{{montant}} €/ mois pendant {{ nbDeMensualites }} mois.</p>
                  <p v-else>{{montant | round }} € TTC</p>
                  <b-form-text v-if="codePromoLocation">{{ nbDeMoisOfferts }} mois remboursés !</b-form-text>
              </b-card-text>
                <div class="form-group">
                    <b-form @submit="validOrder">
                        <label for="codePromo">Avez-vous un code promo ?</label>
                        <b-container fluid>
                            <b-row>
                                <b-col sm="8" class="inputPromo">
                                    <b-form-input type="text" v-model="codePromo" class="form-control"></b-form-input>
                                    <b-form-text v-if="badCodePromo">
                                        Code promo invalide
                                    </b-form-text>
                                    <b-form-text v-if="tentative2CodesPromo">
                                        Vous ne pouvez pas cumulez les codes promo.
                                    </b-form-text>
                                </b-col>
                                <b-col sm="4" class="submitPromo">
                                    <b-button size="sm" @click="verifCodePromo">Valider</b-button>
                                </b-col>
                            </b-row>
                        </b-container>
                        <span v-b-popover.hover.rightbottom="'Vous devez renseigner un siret et une adresse mail valide pour valider votre commande'">
                            <b-button pill :disabled="adressesEtSiretRenseignes" type="submit" class="btn btn-contact">Commander</b-button>
                        </span>
                    </b-form>
                </div>
              <b-card-text>
              </b-card-text>
              <div class="d-flex flex-row justify-content-around">
                <b-card-img 
                    src="https://simulateur.2020.le-site-francais.fr/assets/Rectangle_39.png" 
                    alt="réassurance"
                    class="b-card-recap-lsf">
                </b-card-img>
                <b-card-img 
                    src="https://simulateur.2020.le-site-francais.fr/assets/Rectangle_39.png" 
                    alt="réassurance"
                    class="b-card-recap-lsf">
                </b-card-img>
            </div>
          </b-card-body>
      </b-card>
  </div>
</template>

<script>
export default {
    name: "Sidebar",
    mounted() {
        let date = new Date();
        this.dateDuJour = date.getFullYear()+"-"+0+(date.getMonth()+1)+"-"+0+date.getDate();
    },
    data() {
        return {
            adressesEtSiretRenseignes: true,
            codePromo: "",
            locationOuAchat: 1,
            montant: 0,
            adresse: false,
            siret: false,
            dateDuJour: "",
            badCodePromo: false,
            nbDeMoisOfferts: 0,
            codePromoLocation: false,
            nbDeMensualites: this.$route.params.nbDeMensualites,
            codePromoValide: false, // si true, alors ne plus déduire ne nouveaux codes promo
            tentative2CodesPromo : false
        }
    },
    props: {
        totalPrice: {
           type: Number 
        },
        type: {
            type: Number
        },
        champsValid: {
            type: Boolean
        }
    },
    watch: {
        totalPrice() {
            this.montant = this.totalPrice;
        },
        type() {
            this.locationOuAchat = this.type;
        },
        adresse() {
            if(this.adresse === true && this.siret === true) this.adressesEtSiretRenseignes = true;
            else this.adressesEtSiretRenseignes = false;
        },
        siret() {
            if(this.adresse === true && this.siret === true) this.adressesEtSiretRenseignes = true;
            else this.adressesEtSiretRenseignes = false;
        },
        champsValid() {
            this.champsValid === true ? this.adressesEtSiretRenseignes = false : this.adressesEtSiretRenseignes = true;
        }
    },
    methods: {
        validOrder() {
            console.log('merci');
        },
        verifCodePromo() {
            if(this.codePromoValide == true) {
                this.tentative2CodesPromo = true;
            } else {
                this.axios
                .get('https://simulateur.2020.le-site-francais.fr/api/getCodePromo.php', {params: {code: this.codePromo }})
                .then(resp => {
                    if(resp.data[0].montant == null) { this.badCodePromo = true;}
                    else if(this.locationOuAchat == 1) {
                        this.badCodePromo = false;
                        this.codePromoValide = true;
                        this.codePromoLocation = true;
                        switch(this.nbDeMensualites) {
                            case 48: 
                                this.nbDeMoisOfferts = 3;
                                break;
                            case 36:
                                this.nbDeMoisOfferts = 2;
                                break;
                            case 24:
                                this.nbDeMoisOfferts = 1;
                                break;
                        }                
                    }
                    else {
                        this.badCodePromo = false;
                        this.codePromoValide = true;
                        let dateDebut = resp.data[0].date_debut;
                        let dateFin = resp.data[0].date_fin;
                        if(this.dateDuJour >= dateDebut && this.dateDuJour <= dateFin) { // date du jour entre dans les conditions du code promo
                            if(resp.data[0].pourcentage == 1) this.montant -= parseInt(resp.data[0].montant); //montant fixe déduit
                            else(this.montant = this.montant*(1-(parseInt(resp.data[0].montant)/100))); // % déduit
                            //renvoyer le nouveau montant en bdd
                            this.axios
                                .post('https://simulateur.2020.le-site-francais.fr/api/setConfiguration.php', {
                                    configId: this.$route.params.configId,
                                    prix_total: this.montant
                                })
                                .then(response => {
                                    console.log(response);
                                })
                                .catch(error => console.log(error))
                        }
                    }
                })
                .catch(error => console.log(error)) // si code promo inexistant
            } 
        }
    }
}
</script>

<style>
    .b-card-recap-lsf {
        max-width: 45%;
    }
</style>