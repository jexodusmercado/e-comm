<template>
        <div class="modal">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">{{ title }}</h4>
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                {{ message }}
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
 props: ['title', 'message']
}
</script>
