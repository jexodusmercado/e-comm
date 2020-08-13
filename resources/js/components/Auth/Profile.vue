<template>
    <div>
        <Loader :show="loading"></Loader>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mx-auto p-5">
                            <div class="form-group col-md-12" v-show="$store.state.userRole == 2">
                                <label for="fname">First name:</label>
                                <input type="text" class="form-control" id="fname" v-model="fname">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="fname">First name:</label>
                                <input type="text" class="form-control" id="fname" v-model="fname">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="mname">Middle name:</label>
                                <input type="text" class="form-control" id="mname" v-model="mname">
                                <small id="mnameHelp" class="form-text text-muted">Optional</small>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="lname">Last name:</label>
                                <input type="text" class="form-control" id="lname" v-model="lname">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="add1">Address 1:</label>
                                <input type="text" class="form-control" id="add1" v-model="add1">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="add2">Address 2:</label>
                                <input type="text" class="form-control" id="add2" v-model="add2">
                                <small id="add2Help" class="form-text text-muted">Optional</small>

                            </div>
                            <div class="form-group col-md-12">
                                <label for="barangay">Barangay:</label>
                                <input type="text" class="form-control" id="barangay" v-model="barangay">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="city">City:</label>
                                <input type="text" class="form-control" id="city" v-model="city">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="prov">Province:</label>
                                <input type="text" class="form-control" id="prov" v-model="prov">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="mobile">Mobile No:</label>
                                <input type="text" class="form-control" id="mobile" v-model="mobile">
                                <small id="mobileHelp" class="form-text text-muted">We'll never share your mobile number with anyone else.</small>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" v-model="email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="passwd">Password:</label>
                                <input type="password" class="form-control" id="passwd" v-model="passwd">
                                <!-- <small id="mobileHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <button type="button" class="btn btn-block btn-primary" @click.prevent="UpdateData">
                                     Save
                                </button>
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
            fname:"",
            mname:"",
            lname:"",
            add1: "",
            add2: "",
            barangay: "",
            city: "",
            prov: "",
            mobile: "",
            email: "",
            passwd:"",
        }
    },
    methods:{
        async getData(){
            this.loading = true;
            const response = (await axios.get(`/api/user/view/`+this.$store.state.userId));
            this.fname = response.data.first_name;
            this.mname = response.data.middle_name;
            this.lname = response.data.last_name;
            this.add1 = response.data.address1;
            this.add2 = response.data.address2;
            this.barangay = response.data.barangay;
            this.city = response.data.city;
            this.prov = response.data.province;
            this.mobile = response.data.mobile_number;
            this.email = response.data.email;

            this.loading = false;
        },
        async UpdateData(){
                const formData = new FormData();
                formData.append('first_name', this.fname);
                formData.append('middle_name', this.mname);
                formData.append('last_name', this.lname);
                formData.append('address1', this.add1);
                formData.append('address2', this.add2);
                formData.append('barangay', this.barangay);
                formData.append('city', this.city);
                formData.append('province', this.prov);
                formData.append('mobile_number', this.mobile);
                formData.append('email', this.email);
                formData.append('password', this.passwd);

                try {

                    const response = (await axios.post(`/api/user/update/`+this.$store.state.userId, formData));
                    let pModal = this.$parent.$refs.pModal.$el;
                    this.$parent.title = 'Success';
                    this.$parent.message = 'Changes has been saved';
                    $(pModal).modal('show');
                    this.getData();

                } catch (error) {
                    let pModal = this.$parent.$refs.pModal.$el;
                    this.$parent.title = 'Error';
                    this.$parent.message = error;
                    $(pModal).modal('show');
                }
        },
        async 
    },
    created(){
        if(this.$store.state.isLoggedIn){
            this.getData();
        }else{
            let pModal = this.$parent.$refs.pModal.$el;
            this.$parent.title = 'Authentication Error';
            this.$parent.message = 'Please login to continue';
            this.$router.push({name:'Login'});
            $(pModal).modal('show');
        }
    }

}
</script>
