<template>
    <div>
        <Header></Header>
        <div class="container">
            <div class="row">
                <Details 
                    @prixConfig="sendTotalPrice"
                    @type="sendType"
                    @champsOk="sendChampsOk">
                </Details>
                <Sidebar 
                    :totalPrice="totalPrice"
                    :type="type"
                    :champsValid="champsValid">
                </Sidebar> 
            </div> 
        </div>
    </div>
  
</template>

<script>
import Header from './Header.vue'
import Details from './Details.vue'
import Sidebar from './Sidebar.vue'

export default {
    name: "Recap",
    components: {
        Header,
        Details,
        Sidebar,
    },
    data() {
        return {
            totalPrice: 0,
            type: 1,
            champsValid: false
        }
    },
    methods: {
        sendTotalPrice(variable) {
            this.totalPrice = parseInt(variable);
        },
        sendType(variable) {
            this.type = parseInt(variable);
        },
        sendChampsOk(variable) {
            this.champsValid = variable;
        }
    }
}
</script>

<style>

</style>