<template>
    <div class="container pt-5">
        <div class="row">
            <div class="col-3">
                <div class="btn-group btn-group-lg pb-3" role="group" aria-label="Photo Controls">
                    <button type="button" id="btn-front" class="btn btn-secondary active" @click.prevent="disableBack()"> <strong> FRONT </strong> </button>
                    <button type="button" id="btn-back" class="btn btn-secondary" @click.prevent="disableFront()"> <strong> BACK </strong> </button>
                </div>
                <div class="pb-3">
                    <label for="products"> <strong> SELECT PRODUCT </strong> </label>
                    <select id="products" v-model="selectedProduct" name="products" class="form-control">
                        <option value="crew"> MEN | Shirt </option>
                        <option value="mens_longsleeve"> MEN | Long Sleeve</option>
                        <option value="mens_tank"> MEN | Tank</option>
                        <option value="womens_crew"> WOMEN | Shirt</option>
                        <option value="mens_hoodie"> UNISEX | Sweater</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="photoFile"> <strong> INSERT CUSTOM DESIGN </strong> </label>
                    <input type="file" class="form-control-file" name="photoFile" id="photoFile" @change="uploadPhoto" >
                </div>

                <div class="pb-1">
                    <strong>PICK A COLOR:</strong>
                </div>
                <div class="pb-3">
                    <v-swatches
                    v-model="color"
                    swatches="text-advanced"
                    @close="changeColor()"
                    ></v-swatches>
                </div>
                <div>
                    <button class="btn btn-primary" @click="saveProduct()"> SAVE </button>
                </div>
                <div>

                </div>
            </div>
            <div class="col-6">
				<div id="tshirt_front" class="tshirt_div" :class="[this.hide_front ? active : inactive]">
				    <img id="tshirt_backgroundpicture" :src="'/product/'+selectedProduct+'_front.png'">
				    <div id="drawingArea_1" class="drawing_area">
				        <div class="canvas_container">
				            <canvas id="canvas_1" class="canvas" width="200" height="400"></canvas>
				        </div>
				    </div>
				</div>

                <div id="tshirt_back" class="tshirt_div" :class="[this.hide_back ? active : inactive]">
				    <img id="tshirt_backgroundpicture" :src="'/product/'+selectedProduct+'_back.png'">
				    <div id="drawingArea_2" class="drawing_area">
				        <div class="canvas_container">
				            <canvas id="canvas_2" class="canvas" width="200" height="400"></canvas>
				        </div>
				    </div>
				</div>
            </div>
            <div class="col-3">
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
            VSwatches
        },
        mounted() {
            console.log('Component mounted.');
        },
        data(){
            return{
                selectedProduct: 'crew',
                hide_front: true,
                hide_back: false,
                has_errors: false,
                active: 'show',
                inactive: 'hide',
                color: '',
            }
        },
        methods:{
            getImageUrl(data){
                return new Promise(resolve => {
                        resolve(domtoimage.toPng(data));
                });
            },
            async saveProduct(){
                this.hide_back=true;
                this.hide_front=true;


                let imageFront = document.getElementById('tshirt_front');
                let imageBack = document.getElementById('tshirt_back');
                let data1 = await this.getImageUrl(imageFront);
                let data2 = await this.getImageUrl(imageBack);

                let data = {
                    imageFront: data1,
                    imageBack: data2
                }

                axios.post(`api/products/save`, data)
                .then(response =>{
                    this.success = 201 === response.status;
                })
                .catch(err =>{
                    console.log("something is wrong",err)
                })
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
            uploadPhoto(event){
                let canvas_front = new fabric.Canvas('canvas_1');
                let canvas_back = new fabric.Canvas('canvas_2');
                let reader = new FileReader();
                let hideFront = this.hide_front;
                let hideBack = this.hide_back;

                reader.onload = function (f){
                    var imgObj = new Image();
                    imgObj.src = f.target.result;


                    imgObj.onload = function () {
                        let img = [];

                        img.push(new fabric.Image(imgObj));

                        const lastimg = img[img.length - 1];
                        console.log(lastimg)
                        console.log(img)
                        lastimg.scaleToHeight(300);
                        lastimg.scaleToWidth(300);

                        if(hideFront == true){
                            canvas_front.centerObject(lastimg);
                            canvas_front.add(new fabric.Group(img));
                            canvas_front.renderAll();
                        }if(hideBack == true){
                            canvas_back.centerObject(lastimg);
                            canvas_back.add(lastimg);
                            canvas_back.renderAll();

                        }

                    };
                };

                    reader.readAsDataURL(event.target.files[0]);
            }
        }

    }
</script>
<style scoped>
    .drawing_area{
        position: absolute;
        top: 75px;
        left: 162px;
        z-index: 10;
        width: 200px;
        height: 400px;
    }

    .canvas_container{
        width: 200px;
        height: 400px;
        position: relative;
        user-select: none;
    }

    .tshirt_div{
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
</style>
