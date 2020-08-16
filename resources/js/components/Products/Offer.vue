<template>
    <div class="pt-3">
        <Loader :show="loading"></Loader>
        <div class="container">
            <span>
                <div class="row">
                    <div class="col-md-12">
                        <button @click="$router.go(-1)" class="btn btn-secondary btn-sm"> BACK </button>
                    </div>
                </div>
                <div class="row border mt-2" v-for="(item, index) in items" :key="index">
                    <!-- <div class="col-md-3">
                        <img src="/assets/images/image-placeholder.jpg" class="img-fluid">
                        <star-rating :read-only="true" :rating="item.user.ratings" :show-rating="false"> </star-rating>
                    </div> -->

                    <div class="col-md-12">
                        <dl class="row p-2">
                            <dt class="col-md-12 my-3">
                            <star-rating :read-only="true" :rating="item.user.ratings" :show-rating="false"> </star-rating>
                            </dt>
                            <dt class="col-md-4">Name:</dt>
                            <dd class="col-md-8">{{ item.user.last_name }}, {{ item.user.first_name }} </dd>

                            <dt class="col-md-4">Address:</dt>
                            <dd class="col-md-8">{{ item.user.address1 }} {{ item.user.address2 }} {{ item.user.barangay }} {{ item.user.city }} {{ item.user.province }} </dd>

                            <dt class="col-md-4">Mobile:</dt>
                            <dd class="col-md-8">{{ item.user.mobile_number }} </dd>

                            <dt class="col-md-4">Email:</dt>
                            <dd class="col-md-8">{{ item.user.email }} </dd>

                            <dt class="col-md-4">Offer:</dt>
                            <dd class="col-md-8">₱{{ Number(item.offer_amount).toLocaleString() }} </dd>

                            <dt class="col-md-4">Shipping fee:</dt>
                            <dd class="col-md-8">₱{{ Number(item.shipping_amount).toLocaleString() }} </dd>

                            <dt class="col-md-4">Total:</dt>
                            <dd class="col-md-8 bg-warning">₱{{ Number(item.shipping_amount + item.offer_amount).toLocaleString() }} </dd>

                            <dt class="col-md-4"></dt>
                            <dd class="col-md-8 mt-3">
                                <button
                                class="btn btn-success btn-sm"
                                @click="acceptOffer(item.id, item.seller_id, item.offer_amount, item.shipping_amount)"
                                :disabled="loading">
                                    ACCEPT
                                </button>
                            </dd>

                        </dl>
                    </div>
                </div>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            items:'',
            loading:false,
        }
    },
    computed:{

    },
    methods:{
        async acceptOffer(auctionId, sellerId, offer, shipping){
            const prompt = confirm('Are you sure?');

            if(prompt == true){
            this.loading = true;

                const formData = new FormData();
                formData.append('auctionLineId',   auctionId);
                formData.append('product_id',      this.$route.params.id);
                formData.append('user_id',         sellerId);
                formData.append('buyer_id',        this.$store.state.userId);
                formData.append('seller_id',       sellerId);
                formData.append('offer_amount',    offer);
                formData.append('shipping_amount', shipping);

                try {
                    const response = await (axios.post(`/api/auction/accept`, formData));
                    let pModal = this.$parent.$refs.pModal.$el;
                    this.$parent.title = 'SUCCESS';
                    this.$parent.message = 'Check your status of shipment in the product page here.';
                    this.$router.push({name:'View Design', params: {id: this.$route.params.id} });
                    $(pModal).modal('show');

                } catch (error) {
                    let pModal = this.$parent.$refs.pModal.$el;
                    this.$parent.title = 'ERROR';
                    this.$parent.message = 'Something went wrong.';
                    $(pModal).modal('show');
                }

            this.loading = false;

            }
        },

    },
    async created(){
        if(this.$store.state.isLoggedIn){
            this.loading = true;
            const pId    = this.$route.params.id;

            if(this.$store.state.userRole == 3){
                let pModal              = this.$parent.$refs.pModal.$el;
                this.$parent.title      = 'Authentication Error';
                this.$parent.message    = 'You do not have any access to this yet. Wait for admin to approve your request.';
                this.$router.push({name:'Home'});
                $(pModal).modal('show');
            }

            try {
                const response = await axios.get('/api/auction/check/'+pId);
                this.items = response.data;

            } catch (error) {
                let pModal = this.$parent.$refs.pModal.$el;
                this.$parent.title = 'Error';
                this.$parent.message = 'Something went wrong';
                this.$router.push({name:'Offer'});
                $(pModal).modal('show');
            }

            this.loading = false;
        }else{
                let pModal              = this.$parent.$refs.pModal.$el;
                this.$parent.title      = 'Authentication Error';
                this.$parent.message    = 'Please login to continue';
                this.$router.push({name:'Login'});
                $(pModal).modal('show');
        }
    }
}
</script>

<style scoped>

</style>
