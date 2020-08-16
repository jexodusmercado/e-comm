<template>
        <div class="modal" id="modal">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-md-6 text-center bg-white border shadow">
                        <button class="btn" @click.prevent="redirectToCustomer">
                            <img class="img-fluid" id="img1" src="/assets/images/reg-designer.png">
                            <span class="h5"> CUSTOMER </span>
                        </button>
                    </div>
                    <div class="col-md-6 text-center bg-white border shadow">
                        <button class="btn" @click.prevent="redirectToPartner">
                            <img class="img-fluid" id="img2" src="/assets/images/reg-partner.png">
                            <span class="h5"> PARTNER </span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
</template>

<script>
export default {
    methods:{
        redirectToCustomer(){
            this.$router.push({name:'Customer Registration'});
            $('#modal').modal('hide');
        },
        redirectToPartner(){
            this.$router.push({name:'Partner Registration'});
            $('#modal').modal('hide');
        }
    }
}
</script>

<style scoped>

</style>
