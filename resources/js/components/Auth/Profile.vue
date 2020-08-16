<template>
    <div>
        <Loader :show="loading"> </Loader>
        <div class="container">
            <button @click="$router.go(-1)" class="btn btn-secondary btn-sm mt-3"> BACK </button>
            <div class="row mt-5">
                <!-- <div class="col-md-3">
                    <img :src="'http://localhost/profiles/no_profile.jpg'" class="img-fluid" />
                    <h3 class="text-center mt-3"> {{ items.first_name }} {{ items.last_name }}</h3>
                    <star-rating :read-only="true" v-model="items.ratings" :show-rating="false"> </star-rating>
                </div> -->
                <div class="col-md-12">
                    <div class="row">
                        <h3 class="mt-3 mr-3"> {{ items.first_name }} {{ items.last_name }}</h3>
                        <star-rating :read-only="true" v-model="items.ratings" :show-rating="false"> </star-rating>
                        <div class="col-md-12 bg-secondary text-white">
                             INFORMATION
                        </div>
                        <div class="col-md-12">
                        <dl class="row">
                                <dt class="col-md-4">User ID:</dt>
                                <dd class="col-md-8">{{ items.id }}</dd>

                                <dt class="col-md-4">Role:</dt>
                                <dd class="col-md-8" v-if="items.role==0">Admin</dd>
                                <dd class="col-md-8" v-if="items.role==1">Buyer</dd>
                                <dd class="col-md-8" v-if="items.role==2">Seller</dd>

                                <dt class="col-md-4">Address:</dt>
                                <dd class="col-md-8">{{  items.address1 }} {{ items.address2 }}, {{items.barangay}}, {{items.city}}, {{items.province}}</dd>

                                <dt class="col-md-4">Mobile number:</dt>
                                <dd class="col-md-8">{{ items.mobile_number }} </dd>

                                <dt class="col-md-4">Email Address:</dt>
                                <dd class="col-md-8"> {{ items.email }} </dd>

                            </dl>
                        </div>

                        <div class="col-md-12 bg-secondary text-white" v-if="this.$store.state.userRole == 2">
                             RATING
                        </div>
                        <div class="col-md-12 mt-3" v-for="(comment, index) in comments.data" :key="index" >
                            <dl class="row" v-if="this.$store.state.userRole == 2">
                                <div class="col-md-3">
                                    <img :src="'http://localhost/uploads/'+comment.product.imageFront+'.png'" class='img-fluid'>
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

        }else if(this.$store.state.userRole == 3){
            let pModal              = this.$parent.$refs.pModal.$el;
            this.$parent.title      = 'Authentication Error';
            this.$parent.message    = 'You do not have any access to this yet. Wait for admin to approve your request.';
            this.$router.push({name:'Home'});
            $(pModal).modal('show');

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
