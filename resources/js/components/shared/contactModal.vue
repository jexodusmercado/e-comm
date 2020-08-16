<template>
        <div class="modal">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">{{ subject }}</h4>
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <dl class="row">
                    <dd class="col-md-4">Name: </dd>
                    <dt class="col-md-8">{{ first_name }} {{ last_name }}</dt>
                        <hr/>
                    <dd class="col-md-4">Subject: </dd>
                    <dt class="col-md-8">{{ subject }}</dt>
                        <hr/>
                    <dd class="col-md-4">Message: </dd>
                    <dt class="col-md-8">{{ message }}</dt>
                </dl>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
</template>

<script>
export default {
 props: ['subject', 'message', 'first_name', 'last_name', ]
}
</script>
