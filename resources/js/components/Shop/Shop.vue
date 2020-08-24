<template>
    <div class="container">
        <Loader :show="loading"></Loader>

        <div class="row my-3">
            <h1>SHOP</h1>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-3 pt-2" v-for="(item, index) in items" :key="index">
                <div class="card">
                  <img class="card-img-top img-fluid" :src="'/shops/'+item.photo" alt="">
                  <div class="card-body">
                    <div class="card-text">
                        <p class="text-center"> {{ item.item_name }} </p>
                        <p class="text-center"> ₱{{ Number(item.price).toLocaleString() }} </p>
                    </div>
                    <div class="text-center font-weight-light">
                        <router-link :to="{name:'View Item', params: { id: item.id} }" class="btn btn-primary">VIEW</router-link>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="row pt-4 pb-2">
            <div class="product-bar">
                <div class="col">
                    <div class="btn-group" role="group">
                        <button class="btn btn-secondary" @click.prevent="getData(links['first'])" :disabled="links['prev']==null">First</button>
                        <button class="btn btn-secondary" @click.prevent="getData(links['prev'])" :disabled="links['prev']==null">Previous</button>
                        <button class="btn btn-secondary" @click.prevent="getData(links['next'])" :disabled="links['next']==null">Next</button>
                        <button class="btn btn-secondary" @click.prevent="getData(links['last'])" :disabled="links['next']==null">Last</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>


<script>
export default {
    computed:{


    },
        async created(){
            if(this.$store.state.isLoggedIn){

                if(this.$store.state.userRole == 3){
                    let pModal              = this.$parent.$refs.pModal.$el;
                    this.$parent.title      = 'Authentication Error';
                    this.$parent.message    = 'You do not have any access to this yet. Wait for admin to approve your request.';
                    this.$router.push({name:'Home'});
                    $(pModal).modal('show');
                }
                this.getData();
            }else{
                let pModal              = this.$parent.$refs.pModal.$el;
                this.$parent.title      = 'Authentication Error';
                this.$parent.message    = 'Please login to continue';
                this.$router.push({name:'Login'});
                $(pModal).modal('show');
            }

        },
        data(){
            return{
                items: [],
                myId: this.$store.state.userId,
                links:[],
                current:'',
                total:'',
                loading:true,
            }
        },

    methods:{
        async getData(src){
            if(!src){
                src = '/api/shop/';
            }
            try{
                let result = await (axios.get(src));

                if(Object.keys(result.data).length){
                this.items = result.data.data;
                this.links = result.data.links;
                this.current = result.data.meta.current_page;
                this.total = result.data.meta.total;
                }else{
                    this.items = null;
                    this.links['prev'] = null;
                    this.links['next'] = null;
                    this.links['last'] = null;
                    this.links['first'] = null;
                    this.current = null;
                    this.total = null;
                }

            } catch (err){
                console.log(err);
            }

        },

    }

}
</script>

 <style scope>
    .product-bar{
        text-align:center;
        width:100%;
    }
    .form-check{
        padding-left:10px;
        font-size: 10px
    }
 </style>
