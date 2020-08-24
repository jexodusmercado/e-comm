<template>
    <div>
        <Loader :show="loading"></Loader>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img :src="'/shops/'+items.photo" class="img-fluid">
                </div>
                <form class="col-md-8 mt-5">
                    <div class="form-group">
                      <label for="file">Change photo:</label>
                      <input type="file" class="form-control" id="file" @change="onImageChange">
                    </div>

                    <div class="form-group">
                      <label for="product_name">ID:</label>
                      <input type="input" class="form-control" id="product_name" v-model="items.product_id" disabled>
                    </div>

                    <div class="form-group">
                      <label for="product_name">Product:</label>
                      <input type="input" class="form-control" id="product_name" v-model="items.product_name">
                    </div>

                    <div class="form-group">
                      <label for="description">Description:</label>
                      <input type="text" class="form-control" id="description" v-model="items.description">
                    </div>

                    <div class="form-group">
                      <label for="price">Price:</label>
                      <input type="text" class="form-control" id="price" v-model="items.price">
                    </div>

                    <div class="form-group">
                      <label for="price">Current Quantity:</label>
                      <input type="text" class="form-control" id="price" v-model="items.qty">
                    </div>

                    <button type="submit" class="btn btn-success" @click.prevent="updateData">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            items:'',
            file:'',
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
        },
        async updateData(){
            this.loading = true;
            const formData = new FormData();

            try {
                formData.append('product_name', this.items.product_name);
                formData.append('product_description', this.items.description);
                formData.append('product_price', this.items.price);
                formData.append('product_quantity', this.items.qty);
                formData.append('product_photo', this.file);

                const response = (await axios.post(`/api/shop/edit/`+this.items.product_id, formData));

                let pModal              = this.$parent.$refs.pModal.$el;
                this.$parent.title      = 'Success';
                this.$parent.message    = 'Changes has been saved';
                $(pModal).modal('show');

                this.getData();

                this.loading = false;

            } catch (error) {

                let pModal              = this.$parent.$refs.pModal.$el;
                this.$parent.title      = 'Error';
                this.$parent.message    = 'Something went wrong:'+error;
                $(pModal).modal('show');

            }


        },
        onImageChange(event){
            this.file = event.target.files[0];
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
