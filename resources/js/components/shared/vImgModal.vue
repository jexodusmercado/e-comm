<template>
        <div class="modal">
                <button type="button" class="close text-white mr-3 mt-2" data-dismiss="modal">&times;</button>
            <div class="container pt-5">
                <div class="row">
                    <div class="col-md-12 text-center">
                            <img class="img-fluid" id="img1" :src="'http://localhost/verification/'+img">
                    </div>
                </div>

            </div>
        </div>
</template>

<script>
export default {
 props: ['img']
}
</script>
