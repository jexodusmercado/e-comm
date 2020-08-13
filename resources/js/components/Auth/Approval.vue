<template>
    <div>
        <Loader :show="loading"></Loader>
        <vModal ref="imgModal" :img="imageData"></vModal>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <table class="table table-bordered table-responsive text-center" v-show="items.length >= 1">
                  <thead>
                    <tr>
                      <th class="h6" scope="col">First name</th>
                      <th class="h6" scope="col">Middle name</th>
                      <th class="h6" scope="col">Last name</th>
                      <th class="h6" scope="col">Address 1</th>
                      <th class="h6" scope="col">Address 2</th>
                      <th class="h6" scope="col">Barangay</th>
                      <th class="h6" scope="col">City</th>
                      <th class="h6" scope="col">Province</th>
                      <th class="h6" scope="col">Email</th>
                      <th class="h6" scope="col">Verification</th>
                      <th class="h6" scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                      <th class="align-middle" scope="row">{{ item.first_name }}</th>
                      <td class="align-middle">
                          {{ item.middle_name }}
                          <!-- <a @click.prevent="openModal" class="btn">
                          <img :src="'http://localhost/uploads/'+item.image+'.png'" class="img-thumbnail" width="125rem">
                          </a> -->
                      </td>
                      <td class="align-middle">{{ item.last_name }}</td>
                      <td class="align-middle">{{ item.address1 }}</td>
                      <td class="align-middle">{{ item.address2 }}</td>
                      <td class="align-middle">{{ item.barangay }}</td>
                      <td class="align-middle">{{ item.city }}</td>
                      <td class="align-middle">{{ item.province }}</td>
                      <td class="align-middle">{{ item.email }}</td>
                      <td class="align-middle"><button class="btn btn-sm btn-primary" @click.prevent="openModal(item.verification_id_img)">View</button></td>
                      <td class="align-middle"><button class="btn btn-sm btn-success">Approved</button></td>
                    </tr>
                  </tbody>
                </table>
                <div v-show="items.length == 0">
                    <p class="display-4"> no data yet </p>
                </div>
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
        openModal(image){
            this.loading = true;
            this.imageData = image;

            let iModal   = this.$refs.imgModal.$el;
            $(iModal).modal('show');

            this.loading = false;
        }
    },
    async created(){
        if(this.$store.state.isLoggedIn){
            this.loading = true;

            const response = (await axios.get(`/api/user/notVerified`));
            this.items = response.data;

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
