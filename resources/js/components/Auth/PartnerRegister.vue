<template>
    <div class="bg-img">

        <Loader :show="loading"></Loader>
        <Modal></Modal>

        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto p-5">
                    <div class="card shadow py-3 px-2">
                        <div class="card-header">
                            <h2 class="h2">
                                Register
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row">

                            <div class="form-group col-md-4">
                                <label for="fname">First name:</label>
                                <input type="text" class="form-control" id="fname" v-model="fname" required>
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mname">Middle name:</label>
                                <input type="text" class="form-control" id="mname" v-model="mname">
                                <small id="mnameHelp" class="form-text text-muted">Optional</small>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lname">Last name:</label>
                                <input type="text" class="form-control" id="lname" v-model="lname" required>
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="add1">Address 1:</label>
                                <input type="text" class="form-control" id="add1" v-model="add1" required>
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="add2">Address 2:</label>
                                <input type="text" class="form-control" id="add2" v-model="add2">
                                <small id="add2Help" class="form-text text-muted">Optional</small>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="barangay">Barangay:</label>
                                <input type="text" class="form-control" id="barangay" v-model="barangay" required>
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="city">City:</label>
                                <input type="text" class="form-control" id="city" v-model="city" required>
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="prov">Province:</label>
                                <input type="text" class="form-control" id="prov" v-model="prov" required>
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="mobile">Mobile No:</label>
                                <input type="text" class="form-control" id="mobile" v-model="mobile" required>
                                <small id="mobileHelp" class="form-text text-muted">We'll never share your mobile number with anyone else.</small>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" v-model="email" required>
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="passwd">Password:</label>
                                <input type="password" class="form-control" id="passwd" v-model="passwd" required>
                                <!-- <small id="mobileHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="cpasswd">Confirm Password:</label>
                                <input type="password" class="form-control" id="cpasswd" v-model="cpasswd" required>
                                <!-- <small id="mobileHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group col-md-12">
                                <label for="cpasswd">Verification ID:</label>
                                <input type="file" class="form-control" id="photo" @change="onImageChange" required>
                                <small id="mobileHelp" class="form-text text-muted">We'll never share your ID with anyone else.</small>
                            </div>
                            <div class="form-group col-md-12">
                                <vue-recaptcha
                                @verify="onVerify"
                                :sitekey="'6LfZAbwZAAAAAHYjtfX765qSCx-52XI_2hxamm_S'"
                                :loadRecaptchaScript="true">
                                </vue-recaptcha>
                                <button type="button" class="btn btn-block btn-primary mt-2" @click.prevent="accReg">
                                     Submit
                                </button>
                            </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { logIn } from "../../shared/utils/auth";

export default {
    beforeMount(){
        if(this.$store.state.isLoggedIn){
            this.$router.push({name:"Home"});
        }
    },
    mounted(){

    },
    data(){
        return{
            photo: [],
            fname: null,
            mname: null,
            lname: null,
            add1: null,
            add2: null,
            barangay: null,
            city: null,
            prov: null,
            mobile: null,
            email: null,
            passwd: null,
            cpasswd: null,
            loading: false,
            verified: false,
            errors: []
        }
    },
    methods:{
        async accReg(){
            this.loading = true;
            const formData = new FormData();
            if(this.passwd == this.cpasswd){
                if(this.verified == true){
                    formData.append('role', 3);
                    formData.append('photo', this.photo);
                    formData.append('fname', this.fname);
                    formData.append('mname', this.mname);
                    formData.append('lname', this.lname);
                    formData.append('add1', this.add1);
                    formData.append('add2', this.add2);
                    formData.append('barangay', this.barangay);
                    formData.append('city', this.city);
                    formData.append('prov', this.prov);
                    formData.append('mobile', this.mobile);
                    formData.append('email', this.email);
                    formData.append('passwd', this.passwd);

                        try {
                            const response = await axios.post('/register', formData);
                            if(201 === response.status){
                                logIn();
                                this.$store.dispatch("loadUser");
                                this.$router.push({name:"Home"});
                            }

                        } catch (error) {
                            let pModal = this.$parent.$refs.pModal.$el;
                            this.$parent.title = 'Error';
                            this.$parent.message = 'Please complete all required fields';
                            $(pModal).modal('show');
                        }
                }else{
                    let pModal = this.$parent.$refs.pModal.$el;
                    this.$parent.title = 'Error';
                    this.$parent.message = 'Please complete captcha';
                    $(pModal).modal('show');
                }

            }else{
                let pModal = this.$parent.$refs.pModal.$el;
                this.$parent.title = 'Error';
                this.$parent.message = 'Password does not match';
                $(pModal).modal('show');
            }

            this.loading = false;
        },
        onImageChange(e){
            this.photo = e.target.files[0];
        },
         onVerify(response){
            if(response) this.verified = true;
        }
    },
    created(){
        if(this.$store.state.isLoggedIn){
            this.$router.push({name:'Home'});

        }
    }
}
</script>

<style scoped>
    .bg-img{
        background-color:hsl(226, 40%, 50%);
    }

</style>
