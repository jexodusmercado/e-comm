<template>
    <div>
        <Loader :show="loading"> </Loader>
        <imageModal ref="imgModal" :img="imageData"></imageModal>
        <div class="container">
            <div class="row mt-3">
                <router-link :to="{name: 'Add Item'}" class="btn btn-secondary">Add New</router-link>
            </div>
            <div class="row mt-3">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <th class="h4" scope="col">Product ID</th>
                      <th class="h4" scope="col">Photo</th>
                      <th class="h4" scope="col">Product Name</th>
                      <th class="h4" scope="col">Description</th>
                      <th class="h4" scope="col">Price</th>
                      <th class="h4" scope="col">Quantity</th>
                      <th class="h4" scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                      <th class="align-middle" scope="row">{{ item.id }}</th>
                      <td class="align-middle">
                          <a @click.prevent="openModal(item.photo)" class="btn">
                          <img :src="'/shops/'+item.photo" class="img-thumbnail" width="125rem">
                          </a>
                      </td>
                      <td class="align-middle">{{ item.item_name }}</td>
                      <td class="align-middle">{{ item.description }}</td>
                      <td class="align-middle">₱{{ Number(item.price).toLocaleString() }}</td>
                      <td class="align-middle">{{ Number(item.qty).toLocaleString() }}</td>
                      <td class="align-middle">
                          <button class="btn btn-secondary btn-block" v-if="item.active == 0" @click.prevent="toggleActivation(item.id, 1)">
                              Activate
                          </button>
                          <button class="btn btn-secondary btn-block" v-if="item.active == 1" @click.prevent="toggleActivation(item.id, 0)">
                              Deactivate
                          </button>

                          <router-link :to="{name: 'Edit Item', params:{ id: item.id } }" class="btn bg-orange btn-block text-white">
                              Edit
                          </router-link>
                          <button class="btn btn-danger btn-block" @click.prevent="deleteItem(item.id)">
                              Delete
                          </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            items:'',
            imageData:'',
            loading:false,
        }
    },
    methods:{
        async getData(){
            try {
                const response = (await axios.get(`/api/shop/`+this.$store.state.userId));
                this.items = response.data;
            } catch (error) {
                console.log('something went wrong: '+error);
            }
        },
        openModal(img){
            this.imageData = '/shops/'+img;
            this.loading = true;

            let iModal   = this.$refs.imgModal.$el;
            $(iModal).modal('show');

            this.loading = false;
        },
        async deleteItem(id){
            const alert = confirm('Are you sure?');

            if(alert === true){
                try {
                    this.loading = true;

                    const response = (await axios.get(`/api/shop/delete/`+id));

                    if(200 === response.status){
                       this.getData();

                        let pModal              = this.$parent.$refs.pModal.$el;
                        this.$parent.title      = 'Success';
                        this.$parent.message    = 'Item has been deleted!';
                        $(pModal).modal('show');
                    }


                    this.loading = false;
                } catch (error) {

                    let pModal              = this.$parent.$refs.pModal.$el;
                    this.$parent.title      = 'Error';
                    this.$parent.message    = 'Something went wrong';
                    $(pModal).modal('show');

                }
            }
        },
        async toggleActivation(id, status){
            const alert = confirm('Are you sure?');

            if(alert === true){
                try {
                    this.loading = true;

                    const response = (await axios.get(`/api/shop/update/`+id+'/'+status));

                    if(200 === response.status){
                       this.getData();

                        let pModal              = this.$parent.$refs.pModal.$el;
                        this.$parent.title      = 'Success';
                        this.$parent.message    = 'Changes has been saved!';
                        $(pModal).modal('show');
                    }


                    this.loading = false;
                } catch (error) {

                    let pModal              = this.$parent.$refs.pModal.$el;
                    this.$parent.title      = 'Error';
                    this.$parent.message    = 'Something went wrong';
                    $(pModal).modal('show');

                }
            }
        },
    },
    async created(){
            this.loading = true;

        if(this.$store.state.isLoggedIn){
            if(this.$store.state.userRole == 2){
                this.getData();
                this.loading = false;

            }else{
                this.$router.push({name:'Home'});
            }
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
.bg-orange{
        background-color:#f57224;
    }

</style>
