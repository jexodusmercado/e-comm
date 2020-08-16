<template>
    <div>
        <contact-modal ref="contactModal" :subject="this.subject" :message="this.message" :first_name="this.fname" :last_name="this.lname"> </contact-modal>
        <div class="container">
            <div class="row">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Message</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in items" :key="index">
                        <th scope="row">{{ item.id }}</th>
                        <td>{{ item.email }}</td>
                        <td>{{ item.subject }}</td>
                        <td>{{ item.message }}</td>
                        <td><button class="btn btn-success" @click.prevent="openModal(item.subject, item.message, item.first_name, item.last_name)">View</button></td>
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
            loading:'',
            subject:'',
            message:'',
            fname:'',
            lname:'',
        }
    },
    methods:{
        async getData(){
            this.loading = true;

            try {
                const response = (await axios.get('/api/inquiries/'));
                this.items = response.data;

            } catch (error) {
                console.log('something is wrong' + error);
            }

            this.loading = false;
        },
        openModal(subject, message, fname, lname){
            let Modal = this.$refs.contactModal.$el;
            this.subject = subject;
            this.message = message,
            this.fname = fname;
            this.lname = lname;

            $(Modal).modal('show');

        }
    },

    async created(){
        if(this.$store.state.isLoggedIn && this.$store.state.userRole == 0){
            this.getData();
        }else{
            let pModal              = this.$parent.$refs.pModal.$el;
            this.$parent.title      = 'Error';
            this.$parent.message    = 'Something went wrong';
            this.$router.push({name:'Home'});
            $(pModal).modal('show');

        }
    }
}
</script>

