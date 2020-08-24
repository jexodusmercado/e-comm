<template>
    <div class="container pt-5">
        <Loader :show="loading"></Loader>
        <Offer ref="offerModal" @place-bet="placeBet"></Offer>
            <button @click="$router.go(-1)" class="btn btn-secondary btn-sm"> BACK </button>
        <div class="row pt-3">
            <div class="col-md-6 bg-white text-center">
                <div class="card border-white">
                  <img class="card-img-top img-fluid " :style="'height:auto; width:700px;'" :src="'/uploads/'+image" alt="">
                  <div class="card-body">
                    <p class="card-text"></p>
                    <div class="text-center font-weight-light">
                        <button class="btn btn-secondary" @click="frontBtn">FRONT</button>
                        <button class="btn btn-secondary" @click="backBtn">BACK</button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-6 bg-white border" v-show="deliverable.length == 0">
                <dl class="row">
                    <div class="col-md-12 bg-secondary text-white text-center border pt-2">
                        <h3> INFORMATION </h3>
                    </div>
                    <dt class="col-md-6">Location:</dt>
                    <dd class="col-md-6">{{ userInfo.city }},{{ userInfo.province }}</dd>
                    <dt class="col-md-6">Email:</dt>
                    <dd class="col-md-6">{{ userInfo.email }}</dd>
                    <dt class="col-md-6">Mobile number:</dt>
                    <dd class="col-md-6">{{ userInfo.mobile_number   }}</dd>
                    <dt class="col-md-6">Payment Method:</dt>
                    <dd class="col-md-6">CASH ON DELIVERY</dd>
                </dl>
                 <div class="row text-center">
                     <div class="col-md-12 bg-secondary text-white border-left border-right border-top pt-2">
                        <h3> SIZES </h3>
                     </div>
                     <div class="col-md-12 border">
                         <dl class="row p-2 ">
                             <dt class="col-md-6 "> XXS:</dt> <dd class="col-md-6">{{ items.XXS }} </dd>
                             <dt class="col-md-6 "> XSM:</dt> <dd class="col-md-6">{{ items.XSM }} </dd>
                             <dt class="col-md-6 "> SML:</dt> <dd class="col-md-6">{{ items.SML }} </dd>
                             <dt class="col-md-6 "> MED:</dt> <dd class="col-md-6">{{ items.MED }} </dd>
                             <dt class="col-md-6 "> LRG:</dt> <dd class="col-md-6">{{ items.LRG }} </dd>
                             <dt class="col-md-6 "> XLG:</dt> <dd class="col-md-6">{{ items.XLG }} </dd>
                             <dt class="col-md-6 "> XXL:</dt> <dd class="col-md-6">{{ items.XXL }} </dd>
                         </dl>
                     </div>
                     <div class="col-md-12 bg-secondary text-white py-3 border">
                         <h4> TOTAL : {{ items.totalQty }} </h4>
                     </div>
                 </div>
                 <div class="row">
                    <div class="col-md-12 pt-3">
                        <button type="button" class="btn btn-primary btn-block" v-if="getRoleId == 2" @click="openOffer"> PLACE BID </button>
                        <router-link :to="{name:'View Offer', params:{id: items.id} }" class="btn btn-primary btn-lg mr-2" v-if="getRoleId == 1">VIEW OFFER</router-link>
                        <button type="button" class="btn btn-danger btn-lg mr-2" v-if="getRoleId == 1" @click.prevent="deleteItem"> DELETE </button>
                    </div>
                 </div>
            </div>
            <div class="col-md-6 border" v-show="deliverable.length <= 1" v-for="(deliver, index) in deliverable" :key="index">
                <dl class="row">
                    <dt class="col-md-12 h2 bg-secondary" >
                        <span v-if="deliver.status == 0" class="text-white">
                            Waiting for payment
                        </span>
                        <span v-if="deliver.status == 1" class="text-info">
                            Processing
                        </span>
                        <span v-if="deliver.status == 2" class="text-primary">
                            Shipped
                        </span>
                        <span v-if="deliver.status == 3" class="text-success">
                            Delivered
                        </span>
                    </dt>
                    <dt class="col-md-12" v-if="deliver.status == 0">
                        Click <a href="#" class="card-link">here</a> if you are already paid.
                    </dt>
                    <dt class="col-md-12" v-if="deliver.status != 0">
                        Kindly wait for the seller to reach you via email or text. If you have any question regarding the shipping and/or the item, we have included the seller's information below. Thank you.
                    </dt>
                    <dt class="col-md-12 bg-secondary h2 text-white mt-3">
                        Seller information
                    </dt>
                    <dt class="col-md-4">Name: </dt>
                    <dl class="col-md-8" v-show="$store.state.userRole == 1">{{deliver.seller.last_name}} , {{ deliver.seller.first_name }}</dl>
                    <dl class="col-md-8" v-show="$store.state.userRole == 2">{{deliver.buyer.last_name}} , {{ deliver.buyer.first_name }}</dl>

                    <dt class="col-md-4">Address: </dt>
                    <dl class="col-md-8" v-show="$store.state.userRole == 1">{{deliver.seller.address1}} {{ deliver.seller.address2 }} {{ deliver.seller.barangay }} {{ deliver.seller.city }}, {{ deliver.seller.province }}</dl>
                    <dl class="col-md-8" v-show="$store.state.userRole == 2">{{deliver.buyer.address1}} {{ deliver.buyer.address2 }} {{ deliver.buyer.barangay }} {{ deliver.buyer.city }}, {{ deliver.buyer.province }}</dl>

                    <dt class="col-md-4">Mobile number: </dt>
                    <dl class="col-md-8" v-show="$store.state.userRole == 1">{{deliver.seller.mobile_number}}</dl>
                    <dl class="col-md-8" v-show="$store.state.userRole == 2">{{deliver.buyer.mobile_number}}</dl>

                    <dt class="col-md-4">Email: </dt>
                    <dl class="col-md-8" v-show="$store.state.userRole == 1">{{deliver.seller.email}}</dl>
                    <dl class="col-md-8" v-show="$store.state.userRole == 2">{{deliver.buyer.email}}</dl>

                    <dt class="col-md-12 bg-secondary h2 text-white mt-3" v-show="$store.state.userRole == 2 && deliver.status != 3">
                        Update status
                    </dt>

                    <dt class="col-md-12 bg-secondary h2 text-white mt-3" v-show="$store.state.userRole == 1 && deliver.status == 2">
                        Update status
                    </dt>

                    <dt class="col-md-12" v-show="$store.state.userRole == 2 && deliver.status == 1">
                        <button class="btn btn-primary" @click.prevent="updateStatus(2,deliver.id)"> Ship </button>
                        <button class="btn btn-primary" @click.prevent="updateStatus(3,deliver.id)"> Delivered </button>
                    </dt>

                    <dt class="col-md-12" v-show="$store.state.userRole == 2 && deliver.status == 2">
                        <button class="btn btn-primary" @click.prevent="updateStatus(1,deliver.id)"> Processing </button>
                        <button class="btn btn-primary" @click.prevent="updateStatus(3,deliver.id)"> Delivered </button>
                    </dt>

                    <dt class="col-md-12" v-show="$store.state.userRole == 1 && deliver.status == 2">
                        <button class="btn btn-primary" @click.prevent="updateStatus(3,deliver.id)"> Delivered </button>
                    </dt>

                    <dt class="col-md-12 bg-secondary h2 text-white mt-3" v-show="$store.state.userRole == 1 && deliver.status == 3">
                        Rate
                    </dt>

                    <div class="col-md-12 mt-3" v-show="!comments.length">
                        <dt class="col-md-12 mt-3" v-show="$store.state.userRole == 1 && deliver.status == 3">
                            <star-rating :increment="1" :max-rating="5" :show-rating="false" v-model="rating"> </star-rating>
                        </dt>
                        <dt class="col-md-12 mt-2" v-show="$store.state.userRole == 1 && deliver.status == 3">
                              Comment:<textarea class="form-control" v-model="commentText"></textarea>
                        </dt>
                        <dt class="col-md-12 mt-2" v-show="$store.state.userRole == 1 && deliver.status == 3">
                              <button class="btn btn-primary" @click.prevent="insertComment" :disabled="loading">Submit</button>
                        </dt>
                    </div>

                    <div class="col-md-12 mt-3" v-show="comments.length">
                        <dt class="col-md-12 mt-3" v-show="$store.state.userRole == 1 && deliver.status == 3">
                           <h2 class="h4">You already rated this product!</h2>
                        </dt>
                    </div>


                </dl>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    async created(){
        if(this.$store.state.isLoggedIn){

            if(this.$store.state.userRole == 3 && this.$store.state.userRole == 2){
                let pModal              = this.$parent.$refs.pModal.$el;
                this.$parent.title      = 'Authentication Error';
                this.$parent.message    = 'You do not have any access to this yet. Wait for admin to approve your request.';
                this.$router.push({name:'Home'});
                $(pModal).modal('show');
            }

            this.loading      = true;
            const id          = this.$route.params.id;
            try {
                const result      = await (axios.get(`/api/products/view/`+id));
                this.items        = result.data;
                this.image        = result.data.imageFront;

            } catch (error) {
                console.log('fail to fetch product' + error);
            }

            try {
                const uId         = this.items.user_id;
                const userResult  = await (axios.get(`/api/user/view/`+uId));
                this.userInfo     = userResult.data;
            } catch (error) {
                console.log('fail to fetch user' + error);
            }

            try {
                const deliverable = await (axios.get(`/api/delivery/check/`+id));
                this.deliverable  = deliverable.data;
            } catch (error) {
                console.log('fail to fetch deliverable' + error);

            }

            try {

                // console.log(this.items.id);
                const comments = await (axios.get(`/api/rate/check/`+this.items.id+`/`+this.items.user_id));
                this.comments = comments.data;

            } catch (error) {
                console.log('fail to fetch comments' + error);

            }
            this.loading = false;
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

    },
    mounted(){

    },
    data(){
        return{
            thisURL:'http://localhost',
            items:  '',
            deliverable: '',
            selected: '',
            image:  '',
            userInfo: '',
            userId: this.$store.state.userId,
            loading:false,
            status: '',
            comments:'',
            rating: 0,
            commentText: ''
        }
    },
    computed:{
        getRoleId(){
            return this.$store.state.userRole;
        },
    },

    methods:{
        frontBtn(){
            this.image = this.items.imageFront;
        },
        backBtn(){
            this.image = this.items.imageBack;
        },
        openOffer(){
            let offerModal = this.$refs.offerModal.$el;
            $(offerModal).modal('show');
        },
        async insertComment(){
            this.loading = true;
            let pModal     = this.$parent.$refs.pModal.$el;
            const formData = new FormData();
            try {
                formData.append('product_id', this.items.id);
                formData.append('buyer_id', this.items.user_id);
                formData.append('seller_id', this.deliverable[0].seller_id);
                formData.append('rating', this.rating);
                formData.append('comment', this.commentText);

                const response = (await axios.post(`/api/rate/save/`, formData));

                if(200 == response.status){
                    this.$parent.title   = 'Success!';
                    this.$parent.message = 'Thank you for the rating. The seller will surely appreciate this.'
                    $(pModal).modal('show');
                }

                const comments = await (axios.get(`/api/rate/check/`+this.items.id+`/`+this.items.user_id));
                this.comments = comments.data;


            } catch (error) {
                    this.$parent.title   = 'Error!';
                    this.$parent.message = 'You have already rate this product.'
                    $(pModal).modal('show');


            }



            this.loading = false;
        },
        async placeBet($amount1, $amount2){
            this.loading   = true;
            let offerModal = this.$refs.offerModal.$el;
            let pModal     = this.$parent.$refs.pModal.$el;
            const formData = new FormData();
            try {
                formData.append('product_id', this.items.id);
                formData.append('seller_id', this.$store.state.userId);
                formData.append('offer_amount', $amount1);
                formData.append('shipping_amount', $amount2);

                const result = await axios.post(`/api/auction/offer`, formData);

                if(200 === result.status){
                    this.$parent.title   = 'Success!';
                    this.$parent.message = 'Thank you for your offer. Kindly wait until buyer decides.'
                    $(pModal).modal('show');
                }

                $(offerModal).modal('hide');

            } catch (error) {

                $(offerModal).modal('hide');
                this.$parent.title   = 'Error';
                this.$parent.message = 'You already offered to this item.';
                $(pModal).modal('show');

            }

            this.loading = false;
        },

        async deleteItem(){
            let alert = confirm('Are you sure?');
            if(alert == true){
                this.loading = true;
                const pId    = this.items.id;
                let pModal   = this.$parent.$refs.pModal.$el;

                try {
                    const response = await axios.get(`/api/products/remove/`+pId);
                    if(200 === response.status){
                        this.$parent.title = 'SUCCESS';
                        this.$parent.message = 'Product has been deleted';

                        $(pModal).modal('show');
                    }
                } catch (error) {
                        this.$parent.title = 'ERROR';
                        this.$parent.message = 'Something went wrong';
                        $(pModal).modal('show');
                }

                this.loading = false;
            }

        },
        async updateStatus(status, id){
            let alert = confirm('Are you sure?');
            if(alert == true){
                this.loading            = true;
                const pId               = id;
                const delivery_status   = status;
                const formData          = new FormData();
                let pModal   = this.$parent.$refs.pModal.$el;

                formData.append('id', pId);
                formData.append('status', delivery_status);

                const response = (await axios.post(`/api/delivery/status/update/`, formData));

                    if(200 === response.status){
                        this.$parent.title = 'SUCCESS';
                        this.$parent.message = 'Order has been updated';
                        $(pModal).modal('show');
                    }else{
                        this.$parent.title = 'ERROR';
                        this.$parent.message = 'Something went wrong';
                        $(pModal).modal('show');
                    }

                this.getData();
                this.loading = false;
            }
        },
        async getData(){
            this.loading      = true;
            const id          = this.$route.params.id;
            try {
                const result      = await (axios.get(`/api/products/view/`+id));
                this.items        = result.data;
                this.image        = result.data.imageFront;

            } catch (error) {
                console.log('fail to fetch product' + error);
            }

            try {
                const uId         = this.items.user_id;
                const userResult  = await (axios.get(`/api/user/view/`+uId));
                this.userInfo     = userResult.data;
            } catch (error) {
                console.log('fail to fetch user' + error);
            }

            try {
                const deliverable = await (axios.get(`/api/delivery/check/`+id));
                this.deliverable  = deliverable.data;
            } catch (error) {
                console.log('fail to fetch deliverable' + error);

            }
            this.loading = false;
        }

    }
}
</script>

<style scoped>
.bg-custom{
    background-color:#929292;
}
</style>
