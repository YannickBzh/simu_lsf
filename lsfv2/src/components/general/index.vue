<template>
    <div class="container-fluid">
      <Header 
        :prixtotal="prixtotal"
        :type="choixType"
        @choixType="modifChoixType">
      </Header>
      <div class="container">
        <div class="row sidebar">
          <Sidebar></Sidebar>
          <main class="col-md-9">
            <FormulaireGeneral 
              @inputData="updateMessage" 
              @inputData2="updateProspect">
            </FormulaireGeneral>
            <Formules 
              :idProspect="prospectId"
              @inputFormule="updateFormuleId" 
              @btnNextCliqued="goToFonctionnalites">
            </Formules>
            <Fonctionnalites 
              :idCat="childData" 
              :affichage="affichageFonct" 
              :typeChoix="choixType"
              @btnGoToChoixType="goToChoixType"
              @listeFonctionnalites="sendList">
            </Fonctionnalites>
            <ChoixType 
              :msg="prospectId" 
              :affichage="affichageChoixType"
              :formule="formuleId"
              :listeFonct="listeFonct"
              :prixtotal="prixtotal"
              @choixType="modifChoixType"
              @nbMois="modifPrixSuivantNbMois">
            </ChoixType>
          </main>
        </div>
      </div>
    </div>
</template>

<script>
    import Header from './Header.vue'
    import Sidebar from './Sidebar.vue'
    import FormulaireGeneral from './Formulaire_general.vue'
    import Formules from './Formules.vue'
    import Fonctionnalites from './Fonctionnalites.vue'
    import ChoixType from './choix_type.vue'

export default {
    name: "index",
    components: {
        Header,
        Sidebar,
        FormulaireGeneral,
        Formules,
        Fonctionnalites,
        ChoixType
  },
  data () {
    return {
      childData: "",
      prospectId: "",
      formuleId: 2,
      affichageFonct: false,
      affichageChoixType: false,
      choixType: "Location",
      prixFormule: 69,
      prixFonctionnalite: 0,
      prixtotal: 69,
      listeFonct: [],
      nbDeMois: 48
    }
  },
  methods: {
    updateMessage(variable) { // Met à jour le secteur d'activité dispo dans toute l'app
      this.childData = variable;
    },
    updateProspect(variable) {
      this.prospectId = variable;
    },
    updateFormuleId(variable) { // Si type formule (mini site, essentiel ou classique modifié)
      this.formuleId = variable;
      this.getFormule();
    },
    goToFonctionnalites(variable) {
      this.affichageFonct = variable;
    },
    goToChoixType(variable) {
      this.affichageChoixType = variable;
    },
    modifChoixType(variable) {
      this.choixType = variable;
    },
    modifPrixHeader(variable) {
      this.prixFonctionnalite = variable;
    },
    sendList(variable) {
      this.listeFonct = variable;
      if(this.listeFonct.length < 1) {
        this.prixFonctionnalite = 0;
        return;
      }
      for(let i=0 ; i<this.listeFonct.length ; i++) {
        this.getFonctionnalites();
      }
    },
    modifPrixSuivantNbMois(variable) {
      this.nbDeMois = variable;
    },
    getFonctionnalites: function() {
      if(this.listeFonct.length < 1) {
        this.prixFonctionnalite = 0;
        return;
      }
      this.listeFonct.forEach(element => {
        this.prixFonctionnalite = 0;
        this.axios
        .get('https://simulateur.2020.le-site-francais.fr/api/getFonct.php', {params: {idFonct: element}})
        .then(response => {
            switch(this.choixType) { // recherche du prix de chaque fonctionnalité en f° du type choisi
              case "Location":
                switch(this.nbDeMois) {
                  case 48: 
                    this.prixFonctionnalite += parseInt(response.data[0].prix_location_48);
                    break;
                  case 36:
                    this.prixFonctionnalite += parseInt(response.data[0].prix_location_36);
                    break;
                  case 24:
                    this.prixFonctionnalite += parseInt(response.data[0].prix_location_24);
                    break;
                }
                break;
              case "Achat":
                this.prixFonctionnalite += parseInt(response.data[0].prix_achat);
                break;
              default:
                this.prixFonctionnalite += parseInt(response.data[0].prix_location_48);
            }  
        })
        .catch(error => console.log(error)); 
      })
    },
    getFormule: function() {
      if(isNaN(this.formuleId)) {
        this.prixFormule = 0;
      }
      else {
        this.axios
          .get('https://simulateur.2020.le-site-francais.fr/api/getFormules.php', {params: {idForm: this.formuleId}})
            .then(response => {
              if(this.choixType === "Location") { // Si location selectionné
                switch(this.nbDeMois) {
                  case 48: 
                    this.prixFormule = parseInt(response.data[0].prix_location_48); // ajout du montant 48 mois
                    break;
                  case 36:
                    this.prixFormule = parseInt(response.data[0].prix_location_36); // ajout du montant 36 mois
                    break;
                  case 24:
                    this.prixFormule = parseInt(response.data[0].prix_location_24); // ajout du montant 36 mois
                    break;
                  default: 
                    this.prixFormule = parseInt(response.data[0].prix_location_48);
                }     
              } else { // Si achat
                this.prixFormule = parseInt(response.data[0].prix_achat);
              }   
            })
          .catch(error => console.log(error));
      }
    }
  },
  watch: {
    prixFormule: function() { // Si prix Formule change (mini site, essentiel, classique)
      this.prixtotal = parseInt(this.prixFormule) + parseInt(this.prixFonctionnalite);
    },
    prixFonctionnalite: function() { // Si array des fonctionnalités modifié
      this.prixtotal = parseInt(this.prixFormule) + parseInt(this.prixFonctionnalite);
    },
    nbDeMois: function() { // Si nb de mois des mensualité modifié
      this.getFormule();
      this.getFonctionnalites();
    },
    choixType: function() { // Si choix location ou achat modidié
      this.getFormule();
      this.getFonctionnalites();
    }
  }
}
</script>

<style>

</style>