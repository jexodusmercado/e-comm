<template>
    <div>
        <div class="container">
            <div class="row mt-3">

                <div class="col-md-4 mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="h3 text-center"> {{ items.product_name }} </h1>
                        </div>
                        <div class="col-md-12">
                            <img :src="'/shops/'+items.photo" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <dl class="row">
                                <dt class="col-md-12">
                                    <h1 class="display-4 font-weight-bold text-orange">₱ {{ Number(items.price).toLocaleString() }}</h1>
                                </dt>
                                <dt class="col-md-3 mt-2">
                                    <h2 class="h6">Description:</h2>
                                </dt>
                                <dd class="col-md-9 mt-2">
                                    <p class="h6">{{ items.description }}</p>
                                </dd>

                                <dt class="col-md-3 mt-2">
                                    <h2 class="h6">Sold by:</h2>
                                </dt>
                                <dd class="col-md-9 mt-2">
                                    <p class="h6">{{ items.company_name }}
                                    <star-rating :read-only="true" :show-rating="false" :rating="items.rating" :star-size="10" :inline="true"> </star-rating>
                                    </p>
                                </dd>

                                <dt class="col-md-12 my-5">
                                    <!-- <button class="btn bg-orange text-white">
                                        ADD TO BASKET
                                    </button> -->
                                    <button class="btn bg-maroon text-white">
                                        BUY NOW
                                    </button>
                                </dt>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-12 bg-secondary">
                    <p class="h3 text-white my-auto"> Ratings & Review </p>
                </div>
            </div>
            <div class="row mt-5">
                <dl class="row">
                    <dt class="col-md-12">
                        <star-rating :read-only="true" :rating="3" :show-rating="false"></star-rating>
                    </dt>
                    <dt class="col-md-12">
                        <p class="h6 m-2"> By: John Exodus Mercado </p>
                    </dt>
                    <dt class="col-md-12">
                        <p class="h6 m-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </dt>

                </dl>
            </div> -->
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
    methods:{
        async getData(){

            try {
                const response = (await axios.get(`/api/shop/view/`+this.$route.params.id));
                this.items = response.data.data[0];
            } catch (error) {
                console.log('Failed to fetch shop items: '+error);
            }
        }
    },
    async created(){
        this.loading = true;

        if(this.$store.state.isLoggedIn){
                this.getData();
                this.loading = false;
        }else{
            let pModal              = this.$parent.$refs.pModal.$el;
            this.$parent.title      = 'Authentication Error';
            this.$parent.message    = 'Please login to continue';
            this.$router.push({name:'Login'});
            $(pModal).modal('show');
        }

        this.loading = false;
    }

}
</script>

<style scoped>
    .text-orange{
        color:#f57224;
    }

    .bg-orange{
        background-color:#f57224;
    }

    .bg-maroon{
        background-color:#810000;
    }
</style>
