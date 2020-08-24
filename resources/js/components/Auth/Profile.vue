<template>
    <div>
        <Loader :show="loading"> </Loader>
        <div class="container">
            <button @click="$router.go(-1)" class="btn btn-secondary btn-sm mt-3"> BACK </button>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-12">
                            <h2 class="m-5 display-4" v-if="this.$store.state.userRole == 1"> {{ items.first_name }} {{ items.last_name }}</h2>
                            <h2 class="m-5 display-4" v-if="this.$store.state.userRole == 2 || this.$store.state.userRole == 3"> {{ items.company_name }}</h2>
                        </div>

                        <div class="col-md-12 bg-secondary text-white">
                             <p class="h6 my-2"> INFORMATION </p>
                        </div>

                        <div class="col-md-12">
                            <dl class="row">
                                <dt class="col-md-4">User ID:</dt>
                                <dd class="col-md-8">{{ items.id }}</dd>
                                <dt class="col-md-4">Role:</dt>
                                <dd class="col-md-8" v-if="items.role==0">Admin</dd>
                                <dd class="col-md-8" v-if="items.role==1">Buyer</dd>
                                <dd class="col-md-8" v-if="items.role==2">Seller</dd>
                                <dd class="col-md-8" v-if="items.role==3">Seller</dd>
                                <dt class="col-md-4">Address:</dt>
                                <dd class="col-md-8">{{  items.address1 }} {{ items.address2 }}, {{items.barangay}}, {{items.city}}, {{items.province}}</dd>
                                <dt class="col-md-4">Mobile number:</dt>
                                <dd class="col-md-8">{{ items.mobile_number }} </dd>
                                <dt class="col-md-4">Email Address:</dt>
                                <dd class="col-md-8"> {{ items.email }} </dd>
                            </dl>
                        </div>

                        <div class="col-md-12 bg-secondary text-white" v-if="this.$store.state.userRole == 2">
                             <p class="h6 my-2"> Rating & Review </p>
                        </div>
                        <div class="col-md-12 mt-3">
                            <star-rating :read-only="true" v-model="items.ratings" :show-rating="false" v-if="this.$store.state.userRole == 2"> </star-rating>
                        </div>
                        <div class="col-md-12 mt-3" v-for="(comment, index) in comments.data" :key="index" >
                            <dl class="row" v-if="this.$store.state.userRole == 2">
                                <div class="col-md-3">
                                    <img :src="'/uploads/'+comment.product.imageFront" class='img-fluid'>
                                    <star-rating :read-only="true" :rating="Number(comment.rating)" :star-size="25" :show-rating="false"> </star-rating>
                                </div>
                                <div class="col-md-12">
                                    <p class="font-italic">{{ comment.buyer.first_name  }} {{ comment.buyer.last_name}}</p>
                                    <p class="font-weight-light"> {{ comment.comment }}</p>
                                </div>

                            </dl>
                        </div>
                        <div class="col-md-9 text-center my-2" v-if="this.$store.state.userRole == 2">
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-secondary" @click.prevent="ratingButton(comments.first_page_url)">First</button>
                            </div>
                            <div class="btn-group mr-2" role="group" aria-label="Second group">
                                <button type="button" class="btn btn-sm btn-secondary" @click.prevent="ratingButton(comments.prev_page_url)">Previous</button>
                                <button type="button" class="btn btn-sm btn-secondary" @click.prevent="ratingButton(comments.next_page_url)">Next</button>
                            </div>
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-secondary" @click.prevent="ratingButton(comments.last_page_url)">Last</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            rating:'',
            items: '',
            loading: false,
            comments: '',

        }
    },
    methods:{
        async ratingButton(src){
            const comments = (await axios.get(src));
            this.comments = comments.data;
        }
    },
    async created(){
        this.loading = true;

        if(this.$store.state.isLoggedIn){




            try {
                const response = (await axios.get(`/api/user/view/`+this.$store.state.userId));
                this.items = response.data;
                this.rating = response.data.ratings;

            } catch (error) {
                console.log('error with fetch user' + error);
            }

            try {
                const comments = (await axios.get(`/api/rate/user/`+this.$store.state.userId));
                this.comments = comments.data;
            } catch (error) {
                console.log('error with fetch comments' + error);
            }

        }else{
            let pModal              = this.$parent.$refs.pModal.$el;
            this.$parent.title      = 'Authentication Error';
            this.$parent.message    = 'Please login to continue';

            this.$router.push({name:'Login'});
            $(pModal).modal('show');
        }

        this.loading = false
    }

}
</script>
