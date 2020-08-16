<template>
    <div class="container-fluid">
        <loader :show="loading"></loader>
        <div class="row py-3">
            <div class="col">
                <div class="breadcrumbs">
                    <!-- <router-link :to="{name: 'Editor'}" class="btn btn-primary"> VIEW BID </router-link> -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="bg-white pt-3 pb-3 border">
                    <button class="btn btn-secondary ml-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> FILTER </button>

                    <div class="collapse ml-3 mr-3" id="collapseExample">
                      <div class="p-3">
                          <div class="row">
                          <div class="col-md-2 form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="mens_crew" id="mens_crew" value="mens_crew"  v-model="categories" @change="getData()">
                            <label for="mens_crew" class="form-check-label">
                                MENS CREW
                            </label>
                          </div>
                          <div class="col-md-2 form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="mens_longsleeve" id="mens_longsleeve" value="mens_longsleeve" v-model="categories" @change="getData()">
                            <label for="mens_longsleeve" class="form-check-label">
                                MENS LONGSLEEVE
                            </label>
                          </div>
                          <div class="col-md-2 form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="mens_tank" id="mens_tank" value="mens_tank" v-model="categories" @change="getData()">
                            <label for="mens_tank" class="form-check-label" >
                                MENS TANK
                            </label>
                          </div>
                          <div class="col-md-2 form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="womens_crew" id="womens_crew" value="womens_crew" v-model="categories" @change="getData()">
                            <label for="womens_crew" class="form-check-label">
                                WOMENS CREW
                            </label>
                          </div>
                          <div class="col-md-2 form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="mens_hoodie" id="mens_hoodie" value="mens_hoodie" v-model="categories" @change="getData()">
                            <label for="mens_hoodie" class="form-check-label">
                                HOODIE
                            </label>
                          </div>
                          </div>


                      </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 pt-2" v-for="(item, index) in items" :key="index">
                <div class="card">
                  <img class="card-img-top img-fluid" :src="thisURL+'/uploads/'+item.front" alt="">
                  <div class="card-body">
                    <p class="card-text"></p>
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
                thisURL: 'http://127.0.0.1:80',
                links:[],
                current:'',
                total:'',
                loading:true,
                categories: [
                    'mens_crew',
                    'mens_longsleeve',
                    'mens_tank',
                    'womens_crew',
                    'mens_hoodie'
                ]
            }
        },

    methods:{
        async getData(src){
            if(!src){
                src = 'api/market?'+this.check;
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
