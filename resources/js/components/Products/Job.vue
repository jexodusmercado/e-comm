<template>
    <div>
        <imageModal ref="imgModal" :img="imageData"></imageModal>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <th class="h4" scope="col">Order #</th>
                      <th class="h4" scope="col">Item</th>
                      <th class="h4" scope="col">Customer</th>
                      <th class="h4" scope="col">Status</th>
                      <th class="h4" scope="col">Price</th>
                      <th class="h4" scope="col">Payment</th>
                      <th class="h4" scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                      <th class="align-middle" scope="row">{{ item.delivery_id }}</th>
                      <td class="align-middle">
                          <a @click.prevent="openModal" class="btn">
                          <img :src="'http://localhost/uploads/'+item.image+'.png'" class="img-thumbnail" width="125rem">
                          </a>
                      </td>
                      <td class="align-middle">{{item.full_name}}</td>
                      <td class="align-middle">
                          <span v-if="item.delivery_status == 0">Waiting for payment</span>
                          <span v-if="item.delivery_status == 1">Processing</span>
                          <span v-if="item.delivery_status == 2">Ship</span>
                          <span v-if="item.delivery_status == 3">Delivered</span>
                      </td>
                      <td class="align-middle">₱{{ Number(item.total_amount).toLocaleString() }}</td>
                      <td class="align-middle"> CASH ON DELIVERY</td>
                      <td class="align-middle"><router-link :to="{name:'View Design', params: { id: item.product_id} }" class="btn btn-primary btn-sm mr-2">VIEW</router-link></td>
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
            items: '',
            loading:'',
            imageData:''
        }
    },
    methods:{
        openModal(){
            this.loading = true;

            let iModal   = this.$refs.imgModal.$el;
            $(iModal).modal('show');

            this.loading = false;
        }
    },
    async created(){
        if(this.$store.state.isLoggedIn){
            this.loading = true;

            if(this.$store.state.userRole == 3){
                let pModal              = this.$parent.$refs.pModal.$el;
                this.$parent.title      = 'Authentication Error';
                this.$parent.message    = 'You do not have any access to this yet. Wait for admin to approve your request.';
                this.$router.push({name:'Home'});
                $(pModal).modal('show');
            }

            const response = (await axios.get(`/api/delivery/job/`+this.$store.state.userId));
            this.items = response.data.data;
            this.imageData = this.items[0].image;


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
