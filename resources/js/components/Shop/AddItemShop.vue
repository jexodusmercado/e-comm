<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <h1 class="display-4"> Add Item </h1>
                </div>
                <div class="col-md-12 bg-secondary">
                    &nbsp;
                </div>
                <div class="col-md-12 mt-3">
                    <dl class="row">
                        <form class="col-md-12" method="post">
                            <dt class="col-md-12">
                                PRODUCT NAME:
                            </dt>
                            <dd class="col-md-12">
                                <input type="text" name="product_name" id="product_name" class="form-control" v-model="product_name">
                            </dd>
                            <dt class="col-md-12">
                                DESCRIPTION:
                            </dt>
                            <dd class="col-md-12">
                                <input type="text" name="product_description" id="product_description" class="form-control" v-model="product_description">
                            </dd>
                            <dt class="col-md-12">
                                PRICE:
                            </dt>
                            <dd class="col-md-12">
                                <input type="text" name="product_price" id="product_price" class="form-control" v-model="product_price">
                            </dd>
                            <dt class="col-md-12">
                                QUANTITY:
                            </dt>
                            <dd class="col-md-12">
                                <input type="text" name="product_quantity" id="product_quantity" class="form-control" v-model="product_quantity">
                            </dd>
                            <dt class="col-md-12">
                                PRODUCT PHOTO:
                            </dt>
                            <dd class="col-md-12">
                                <input type="file" name="product_photo" id="product_photo" class="form-control" @change="onImageChange">
                            </dd>
                            <dt class="col-md-12">
                                <button class="btn btn-secondary" @click.prevent="addItem">
                                    Submit
                                </button>
                            </dt>
                        </form>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            product_name:'',
            product_description:'',
            product_price:'',
            product_quantity:'',
            product_photo:'',
            loading: false
        }
    },
    methods:{
        onImageChange(event){
            this.product_photo = event.target.files[0];
        },
        async addItem(){
            this.loading = true;
            const formData = new FormData();
            formData.append("seller_id", this.$store.state.user['id']);
            formData.append("product_name", this.product_name);
            formData.append("product_description", this.product_description);
            formData.append("product_price", this.product_price);
            formData.append("product_quantity", this.product_quantity);
            formData.append("product_photo", this.product_photo);

            try {
                const response = (await axios.post(`/api/shop/save`,formData));
                this.$router.push({name:'My Shop'});
                let pModal = this.$parent.$refs.pModal.$el;
                this.$parent.title = 'Success';
                this.$parent.message = 'Add item has been a success!';
                $(pModal).modal('show');
            } catch (error) {
                let pModal = this.$parent.$refs.pModal.$el;
                this.$parent.title = 'Error';
                this.$parent.message = 'Please complete all required fields';
                $(pModal).modal('show');
            }
        }

    },
    created(){
        if(this.$store.state.isLoggedIn){
            if(this.$store.state.userRole == 2){

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
    }

}
</script>
