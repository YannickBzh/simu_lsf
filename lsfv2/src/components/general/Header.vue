<template>
  <b-navbar :sticky="sticky">
      <div class="container">
          <b-navbar-brand href="https://le-site-francais.fr">
            <img src="https://simulateur.2020.le-site-francais.fr/assets/lsf-blanc-ss-fond_1.png" alt="logo le site français">
          </b-navbar-brand>
            <ul class="progressBar">
                <li 
                v-for="(etape, index) in etapes"
                :key="index" 
                class="nav-item active">
                {{etape.numero}}
                </li>
            </ul>
            <div class="float-right div-prix-lsf">
                <div class="btn-switch">
                    <label class="switch">
                        <input id="lsf-switch" type="checkbox" v-model="choixType">
                        <span class="slider round"></span>
                    </label>
                    <p>{{typeSelected}}</p>
                </div>
                <div class="montant-lsf">
                    <p>{{montant}} €{{moisOuPas}}</p>
                </div>
                
            </div>
      </div>      
    </b-navbar>
</template>

<script>
export default {
    name: "Header",
    data() {
        return {
            etapes: [
                {numero: "étape 1"},
                {numero: "étape 2"},
                {numero: "étape 3"},
                {numero: "étape 4"}
            ],
            montant: 69,
            formuleSelected: [],
            typeSelected: "Location",
            choixType: false,
            moisOuPas: "/Mois",
            sticky: true
        }
    },
    props: {
        prixtotal: {
            type: Number
        },
        type: {
            type: String
        }
    },
    watch: {
        choixType: function() {
            if(this.choixType === false) {
                this.typeSelected = "Location";
                this.$emit("choixType", this.typeSelected);
                this.moisOuPas = "/Mois";
            } else {
                this.typeSelected = "Achat";
                this.$emit("choixType", this.typeSelected);
                this.moisOuPas = "";
            }
        },
        prixtotal: function() {
            this.montant = this.prixtotal;
        },
        type: function() {
            this.type == "Location" ? this.choixType = false : this.choixType = true;
        }
    }
}
</script>

<style>
    input:checked+.slider {background-color: #fff;}
    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    nav {background-color: #5D93FF;color: #fff;}
    .btn-switch {
        position: relative;
        max-width: 30%;
        float: left;
        margin-right: 5px!important;
    }
    .container{position: relative;}
    .div-prix-lsf { width: 150px;}
    .montant-lsf { float: right;}
    .progressBar {
        overflow: hidden;
        counter-reset: step;
        margin: 0 auto 30px;
    }
    .progressBar li {
        list-style-type: none;
        color: #fff;
        font-size: 17px;
        font-weight: 300;
        width: 25%;
        float: left;
        position: relative;
    }
    .progressBar li.active:before {
        background: #fff;
        color: #5D93FF;
    }
    .progressBar li:before {
        content: counter(step);
        counter-increment: step;
        width: 20px;
        line-height: 20px;
        display: block;
        font-size: 16px;
        font-weight: 700;
        color: #3da7df;
        background: #5D93FF;
        border-radius: 50%;
        margin: 0 auto 5px auto;
    }
    .progressBar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: #fff;
        position: absolute;
        left: -50%;
        top: 19px;
        z-index: -1;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #fff;
        -webkit-transition: .4s;
        transition: .4s;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: #5D93FF;
        -webkit-transition: .4s;
        transition: .4s;
    }
    .slider.round {border-radius: 34px;}
    .slider.round:before {border-radius: 50%;}
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        margin-bottom: 0;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
</style>