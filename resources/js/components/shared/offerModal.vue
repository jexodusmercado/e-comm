<template>
        <div class="modal" id="modal">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h5 class="modal-title">PLACE YOUR OFFER</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label" > OFFER AMOUNT:</label>
                    <input type="number" class="form-control" id="recipient-name" v-model="offer_amount" min="1">
                  </div>
                  <div class="form-group">
                    <label for="message-text" class="col-form-label" >SHIPPING FEE:</label>
                    <input type="number" class="form-control" id="recipient-name" v-model="shipping_amount" min="1">
                  </div>
                </form>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="$emit('place-bet', offer_amount, shipping_amount)">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
</template>

<script>
export default {
    data(){
        return{
            offer_amount: 1,
            shipping_amount: 1
        }
    },
    methods:{
        placingBet(){
            console.log('hello');
            $('#modal').modal('hide');
        }
    }

}
</script>
