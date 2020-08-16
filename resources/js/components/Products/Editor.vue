<template>
    <div class="container pt-5">
        <Loader :show="loading"></Loader>
        <Modal ref="errModal" :title="error_data.title" :message="error_data.message"></Modal>
        <div class="row">
            <div class="col-md-3 p-3 border bg-light">
                <div>
                    <h1>PRODUCT DESIGN</h1>
                </div>
                <div class="btn-group btn-block btn-group-lg pb-3" role="group" aria-label="Photo Controls">
                    <button type="button" id="btn-front" class="btn btn-secondary active" @click.prevent="disableBack()"> <strong> FRONT </strong> </button>
                    <button type="button" id="btn-back" class="btn btn-secondary" @click.prevent="disableFront()"> <strong> BACK </strong> </button>
                </div>
                <div class="pb-3">
                    <label for="products"> <strong> SELECT PRODUCT </strong> </label>
                    <select id="products" v-model="selectedProduct" name="products" class="form-control">
                        <option value="mens_crew"> MEN | Shirt </option>
                        <option value="mens_longsleeve"> MEN | Long Sleeve</option>
                        <option value="mens_tank"> MEN | Tank</option>
                        <option value="womens_crew"> WOMEN | Shirt</option>
                        <option value="mens_hoodie"> UNISEX | Sweater</option>
                    </select>
                </div>

                <div class="form-group pb-3">
                    <label for="photoFile"> <strong> INSERT CUSTOM DESIGN </strong> </label>
                    <input type="file" ref="file1" :class="[this.hide_front ? active : inactive]" class="form-control-file" name="asset_image_1" id="asset_image_1" @change="uploadPhotoFront" required>
                    <input type="file" ref="file2" :class="[this.hide_back ? active : inactive]" class="form-control-file" name="asset_image_2" id="asset_image_2" @change="uploadPhotoBack" required>
                </div>
                <div class="pb-3">
                <strong class="pr-5">PICK A COLOR:</strong>
                    <v-swatches
                    v-model="color"
                    swatches="text-advanced"
                    @close="changeColor()"
                    ></v-swatches>
                </div>

                <!-- <div>
                    <button class="btn btn-primary" @click="saveProduct()"> SAVE </button>
                </div> -->
                <div>

                </div>
            </div>
            <div class="col-md-6 p-3 border bg-light">
				<div ref="tshirt_front" id="tshirt_front" class="tshirt-div" :class="[this.hide_front ? active : inactive]">
				    <img id="tshirt_backgroundpicture" :src="'/product/'+selectedProduct+'_front.png'">
				    <div id="drawingArea_1" class="drawing-area">
				        <div class="canvas-container">
				            <canvas ref="canvas_1" id="canvas_1" class="canvas" width="200" height="400"></canvas>
				        </div>
				    </div>
				</div>

                <div ref="tshirt_back" id="tshirt_back" class="tshirt-div" :class="[this.hide_back ? active : inactive]">
				    <img id="tshirt_backgroundpicture" :src="'/product/'+selectedProduct+'_back.png'">
				    <div id="drawingArea_2" class="drawing-area">
				        <div class="canvas-container">
				            <canvas ref="canvas_2" id="canvas_2" class="canvas" width="200" height="400"></canvas>
				        </div>
				    </div>
				</div>
            </div>
            <div class="col-md-3 p-3 border bg-light">
                <div>
                        <h1> QUANTITY AND SIZES </h1>
                </div>
                 <div class="row form-group">
                    <label for="XXS" class="col-sm-2 col-form-label">XXS: </label>
                    <div class="col-10">
                        <input type="number" class="form-control" name="XXS" id="XXS" v-model.number="XXS" @input="total" required>
                    </div>
                </div>
                 <div class="row form-group">
                    <label for="XSM" class="col-sm-2 col-form-label">XSM: </label>
                    <div class="col-10">
                        <input type="number" class="form-control" name="XSM" id="XSM" v-model.number="XSM" @input="total" required>
                    </div>
                </div>
                 <div class="row form-group">
                    <label for="SML" class="col-sm-2 col-form-label">SML: </label>
                    <div class="col">
                        <input type="number" class="form-control" name="SML" id="SML" v-model.number="SML" @input="total" required>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="MED" class="col-sm-2 col-form-label">MED: </label>
                    <div class="col">
                        <input type="number" class="form-control" name="MED" id="MED" v-model.number="MED" @input="total" required>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="LRG" class="col-sm-2 col-form-label">LRG: </label>
                    <div class="col">
                        <input type="number" class="form-control" name="LRG" id="LRG" v-model.number="LRG" @input="total" required>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="XLG" class="col-sm-2 col-form-label">XLG: </label>
                    <div class="col">
                        <input type="number" class="form-control" name="XLG" id="XLG" v-model.number="XLG" @input="total" required>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="XXL" class="col-sm-2 col-form-label">XXL: </label>
                    <div class="col">
                        <input type="number" class="form-control" name="XXL" id="XXL" v-model.number="XXL" @input="total" required>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="totalQty" class="col-sm-2 col-form-label">TOTAL QTY: </label>
                    <div class="col">
                        <input type="input" class="form-control" name="totalQty" id="totalQty" v-model="totalQty" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-success btn-block" @click.prevent="saveProduct"> SUBMIT </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import domtoimage from 'dom-to-image-more';
import VSwatches from 'vue-swatches'
import {fabric} from 'fabric';
    export default {
        components:{
            VSwatches,
        },
        mounted() {
            console.log('Component mounted.');
        },
        data(){
            return{
                selectedProduct: 'mens_crew',
                hide_front: true,
                hide_back: false,
                err_modal:false,
                error_data:{
                    title: '',
                    message: ''
                },
                size:'45px',
                loading: false,
                active: 'show',
                inactive: 'hide',
                color: '',
                asset_image_1:false,
                asset_image_2:false,
                XXS: 0,
                XSM: 0,
                SML: 0,
                MED: 0,
                LRG: 0,
                XLG: 0,
                XXL: 0,
                totalQty: 0
            }
        },
        computed: {

        },
        methods:{
            openModal() {
                this.modalOpen = !this.modalOpen;
            },
            total(event){
                let XXS = this.XXS;
                let XSM = this.XSM;
                let SML = this.SML;
                let MED = this.MED;
                let LRG = this.LRG;
                let XLG = this.XLG;
                let XXL = this.XXL;

                this.totalQty = XXS+XSM+SML+MED+LRG+XLG+XXL;
            },
            getImageUrl(data){
                return new Promise(resolve => {
                        resolve(domtoimage.toPng(data));
                });
            },
            async saveProduct(){
                this.loading=true;

                this.hide_back=true;
                this.hide_front=true;

                let file1 = this.$refs.file1;
                let file2 = this.$refs.file2;

                let imageFront = this.$refs.tshirt_front;
                let imageBack = this.$refs.tshirt_back;
                let data1 = await this.getImageUrl(imageFront);
                let data2 = await this.getImageUrl(imageBack);

                const formData = new FormData();
                formData.append("imageFront", data1);
                formData.append("imageBack", data2);
                formData.append("selectedProduct", this.selectedProduct);
                formData.append("userId", "1");
                formData.append("XXS", this.XXS);
                formData.append("XSM", this.XSM);
                formData.append("SML", this.SML);
                formData.append("MED", this.MED);
                formData.append("LRG", this.LRG);
                formData.append("XLG", this.XLG);
                formData.append("XXL", this.XXL);
                formData.append("totalQty", this.totalQty);


                if(file1.length == 0 || file2.length == 0){
                    this.error_data.title = "ERROR";
                    this.error_data.message ="NO GRAPHIC INSERTED";
                    this.loading = false;
                    let errModal = this.$refs.errModal.$el;
                    $(errModal).modal('show');
                }else{
                    if(this.totalQty == 0){
                        this.error_data.title = "ERROR";
                        this.error_data.message ="NO QUANTITY ENTERED";
                        let errModal = this.$refs.errModal.$el;
                        this.loading = false;
                        $(errModal).modal('show');
                    }else{
                        try {
                            const response = await (axios.post(`/api/products/save`, formData));
                            this.error_data.title = "SUCCESS";
                            this.error_data.message = "Design has been saved!"
                            let errModal = this.$refs.errModal.$el;
                            this.loading = false;
                            $(errModal).modal('show');
                        } catch (error) {

                        }
                    }

                }

                this.hide_back=false;

            },
            changeColor(){
                let bgcolor = this.color;
                document.getElementById('tshirt_front').style.backgroundColor = bgcolor;
                document.getElementById('tshirt_back').style.backgroundColor = bgcolor;
            },
            disableFront(){
                let btnFront = document.getElementById('btn-front');
                let btnBack = document.getElementById('btn-back');

                btnBack.classList.add('active');
                btnFront.classList.remove('active');

                this.hide_front=false;
                this.hide_back=true;

            },
            disableBack(){
                let btnFront = document.getElementById('btn-front');
                let btnBack = document.getElementById('btn-back');

                btnFront.classList.add('active');
                btnBack.classList.remove('active');

                this.hide_front=true;
                this.hide_back=false;
            },
            uploadPhotoFront(event){
                let file = event.target.files[0];
                let data1 = this.$refs.canvas_1;
                let canvas_1 = new fabric.Canvas(data1);
                let hideFront = this.hide_front;

                 let reader = new FileReader();

    			     reader.onload = function (event){
    			        let imgObj = new Image();

    			         imgObj.onload = function () {
                            let img = new fabric.Image(imgObj);
                            img.scale(0.25);
                            canvas_1.add(img);
                            canvas_1.renderAll();
                        };
                        imgObj.src = event.target.result;
                        // canvas_1.remove(canvas_1.getActiveObject());

    			    };
                    reader.readAsDataURL(file);
                    this.asset_image_1 = true;
            },
            uploadPhotoBack(event){
                let file = event.target.files[0];
                let data2 = this.$refs.canvas_2;
    	  		let canvas_2 = new fabric.Canvas(data2);

                 let reader = new FileReader();


    			     reader.onload = function (event){
    			        let imgObj = new Image();

    			         imgObj.onload = function () {
                             let img = new fabric.Image(imgObj);
                            img.scale(0.20);

    			            canvas_2.add(img);
                            canvas_2.renderAll(img);
    			        };
    			        imgObj.src = event.target.result;
                        // canvas_2.remove(canvas_2.getActiveObject());
    			    };
    			    reader.readAsDataURL(file);
                    this.asset_image_2 = true;
            }
        },
        created(){
            if(this.$store.state.isLoggedIn){

            }else if(this.$store.state.userRole == 3){
            let pModal              = this.$parent.$refs.pModal.$el;
            this.$parent.title      = 'Authentication Error';
            this.$parent.message    = 'You do not have any access to this yet. Wait for admin to approve your request.';
            this.$router.push({name:'Home'});
            $(pModal).modal('show');
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

<style scoped>
    .drawing-area{
        position: absolute;
        top: 75px;
        left: 162px;
        z-index: 10;
        width: 200px;
        height: 400px;
    }

    .canvas-container{
        width: 200px ;
        height: 400px;
        position: relative;
        user-select: none;
    }

    .tshirt-div{
        width: 530px;
        height: 630px;
        position: relative;
        background-color: #fff;
    }

    .canvas{
        position: absolute;
        width: 200px;
        height: 400px;
        left: 0px;
        top: 0px;
        user-select: none;
        cursor: default;
    }

    .hide{
        display:none;
    }

    .show{
        display:block;
    }

    h1{
        font-size: 1.6em;
        text-align: center;
    }
</style>
