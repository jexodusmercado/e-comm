<template>
    <div>
        <Loader :show="loading"></Loader>
        <Modal ref="modal" :title="modal.title" :message="modal.message"></Modal>
        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-4">Get your design printed at the lowest rates!</h1>
            <p class="lead">
                Debuhu is a company that let the customer design their desired product and put it up on our own bidding system where other printing companies will bid their price for product.
            </p>

            <router-link :to="{name:'Editor'}" class="btn btn-primary btn-lg">
                Start designing now
            </router-link>

          </div>
        </div>

        <div class="container">

        <div class="row py-5" id="wwd">
            <div class="col-md-5">
                <img src="/assets/images/img-1.png" class="img-fluid" alt="Design">
            </div>

            <div class="col-md-7 my-auto text-center">
                <h2 class="display-1">
                    Design
                </h2>

                <p class="h5">
                    Design your own product with our own web application.
                </p>
            </div>
        </div>

        <div class="row py-5">
            <div class="col-md-7 my-auto text-center">
                <h2 class="display-1">
                    Bid
                </h2>

                <p class="h5">
                    Put your design in queue and choose the printing company that will bring your design to life!
                </p>
            </div>

            <div class="col-md-5">
                <img src="/assets/images/img-2.png" class="img-fluid" alt="Design">
            </div>
        </div>

        <div class="row py-5">
            <div class="col-md-5">
                <img src="/assets/images/img-3.png" class="img-fluid" alt="Design">
            </div>

            <div class="col-md-7 my-auto text-center">
                <h2 class="display-1">
                    Deliver
                </h2>

                <p class="h5">
                    Once your design is created, the printing company, of your choosing, will deliver the product to you
                </p>
            </div>
        </div>

        <div class="row bg-custom" id="pm">
            <div class="col-md-6">
                <img src="/assets/images/delivery-graphics.png" class="img-fluid" alt="Design">
            </div>

            <div class="col-md-6 my-auto">
                <h2 class="display-4">
                    Cash on Delivery.
                </h2>

                <p class="h6 text-danger ml-2">
                    <small> *Shipping fee may vary. Cannot guarantee delivery date due to COVID-19. </small>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <img src="/assets/images/person-sign-up.png" class="img-fluid" alt="Design">
            </div>

            <div class="col-md-8 my-auto">
                <h1 class="display-4">
                    Sign up as one of our printing partner.
                </h1>
                <div class="d-block pt-5">
                    <router-link :to="{name: 'Partner Registration'}" class="btn btn-lg btn-primary px-5">
                        Sign up
                    </router-link>
                </div>
            </div>

        </div>


        <div class="row bg-contact p-2" id="cu">
            <div class="col-md-12 p-5 text-center">
                <h1 class="display-2"> CONTACT US </h1>
            </div>
            <div class="col-md-12">
                <img src="/assets/images/contact-us.png" class="img-fluid" alt="Design">
            </div>
            <div class="col-md-12">
                <div class="form-row">

                  <div class="form-group col-md-6">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" v-model="inquiry.first_name" required>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" v-model="inquiry.last_name" required>
                  </div>

                  <div class="form-group col-md-12">
                    <label for="email">Email Address:</label>
                    <input type="email" class="form-control" id="email" v-model="inquiry.email" required>
                  </div>

                  <div class="form-group col-md-12">
                    <label for="subject">Subject:</label>
                    <input type="text" class="form-control" id="subject" v-model="inquiry.subject" required>
                  </div>

                  <div class="form-group col-md-12">
                    <label for="message">Message:</label>
                    <textarea class="form-control" id="message" v-model="inquiry.message" required></textarea>
                  </div>

                  <div class="form-group col-md-12">
                      <vue-recaptcha
                      @verify="onVerify"
                      :sitekey="'6LfZAbwZAAAAAHYjtfX765qSCx-52XI_2hxamm_S'"
                      :loadRecaptchaScript="true">
                      </vue-recaptcha>
                  </div>

                  <div class="form-group col-md-12">
                      <button :disabled="loading" class="btn btn-lg btn-success" @click="submitInquiry">Submit</button>
                  </div>



                </div>
            </div>
        </div>


        </div>
    </div>
</template>

<script>
export default {
    beforeMount(){
        this.loading = true;
    },
    mounted(){
        this.loading = false;
    },
    data(){
        return{
            inquiry:{
                first_name:'',
                last_name:'',
                email:'',
                subject:'',
                message:'',
                robot: false
            },
            loading: false,
            modal:{
                title:'',
                message:''
            }
        }
    },
    methods:{
        async submitInquiry(){
            const formData = new FormData();
            this.loading   = true;

            if(this.inquiry.robot){
                formData.append("first_name", this.inquiry.first_name);
                formData.append("last_name", this.inquiry.last_name);
                formData.append("email", this.inquiry.email);
                formData.append("subject", this.inquiry.subjects);
                formData.append("message", this.inquiry.message);

                try {

                    const res = await axios.post(`/api/inquiries/save`, formData);
                    this.modal.title = 'FORM SENT!';
                    this.modal.message = 'Thank you for contacting Debuhu. We will reply within 24 hours and help you right away with you concern';
                    let modal = this.$refs.modal.$el;
                    $(modal).modal('show');

                } catch (error) {
                    console.log('something is wrong:'+error);
                }

                this.loading = false;
            }else{
                console.log('robot false');
                this.loading = false;
            }
        },
        onVerify(response){
            if(response) this.inquiry.robot = true;
        },
        regModal(){
            let regModal = this.$refs.regModal.$el;
            $(regModal).modal('show');
        }
    }


}
</script>


<style scoped>

    .bg-custom{
        background-color:#b8d0fd;
    }

    .bg-contact{
        background-color:#b8d0fd;
    }

    .jumbotron{
        background-image:url('/assets/images/146.svg');
        background-size:cover;
        background-repeat: no-repeat;
        background-position: center;
        min-height: 600px;
    }



</style>
