<template>
    <div class="container-fluid">
        <loader :show="loading"></loader>
        <div class="row pb-3">
            <div class="col">
                <div class="breadcrumbs">
                    <router-link :to="{name: 'Editor'}" class="btn btn-primary"> CREATE NEW </router-link>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 pt-2" v-for="(item, index) in items" :key="index">
                <div class="card">
                  <img class="card-img-top img-fluid" :src="thisURL+'/uploads/'+item.image+'.png'" alt="">
                  <div class="card-body">
                    <p class="card-text text-center">
                        <span class="h4" v-show="item.delivery_status == 0">
                            WAITING FOR PAYMENT
                        </span>
                        <span class="h4" v-show="item.delivery_status == 1">
                            PREPARING YOUR ORDER
                        </span>
                        <span class="h4" v-show="item.delivery_status == 2">
                            SHIPPED
                        </span>
                        <span class="h4" v-show="item.delivery_status == 3">
                            DELIVERED
                        </span>

                    </p>
                    <div class="text-center font-weight-light">
                        <router-link :to="{name:'View Design', params: { id: item.product_id} }" class="btn btn-primary">VIEW</router-link>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="row pt-4 pb-2">
            <div class="product-bar">
                <div class="col">
                    <div class="btn-group" role="group">
                        <button class="btn btn-secondary" @click.prevent="getData(links['first']+'&'+check)">First</button>
                        <button class="btn btn-secondary" @click.prevent="getData(links['prev']+'&'+check)" :disabled="links['prev']==null">Previous</button>
                        <button class="btn btn-secondary" @click.prevent="getData(links['next']+'&'+check)" :disabled="links['next']==null">Next</button>
                        <button class="btn btn-secondary" @click.prevent="getData(links['last']+'&'+check)">Last</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>


<script>
export default {
    computed:{

        check(){
            let i ='';
            var query ='';

            for(i=0; i < this.categories.length;i++){
                if(i === 0){
                query += 'category[]='+this.categories[i];
                continue;
                }
                query += '&category[]='+this.categories[i];
            }

            return query;
        }
    },
    data(){
        return{
            items: [],
            myId: this.$store.state.userId,
            thisURL: 'http://localhost',
            links:[],
            current:'',
            total:'',
            loading:true,

        }

    },
    async created(){
        if(this.$store.state.isLoggedIn){
            this.getData();
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
    methods:{
        async getData(){

            try{
                let result = await (axios.get(`/api/delivery/user/`+this.$store.state.userId));

                if(Object.keys(result.data).length){
                    this.items      = result.data.data;
                    this.links      = result.data.links;
                    this.current    = result.data.meta.current_page;
                    this.total      = result.data.meta.total;
                }else{
                    this.items          = null;
                    this.links['prev']  = null;
                    this.links['next']  = null;
                    this.links['last']  = null;
                    this.links['first'] = null;
                    this.current        = null;
                    this.total          = null;
                }

            } catch (err){
                console.log(err);
            }

        },
        async deleteItem(){
            let alert = confirm('Are you sure?');
            if(alert == true){
                this.loading = true;
                const pId    = this.items.id;
                let pModal   = this.$parent.$refs.pModal.$el;

                try {
                    const response = await axios.get(`/api/product/remove/`+pId);
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

        }

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
