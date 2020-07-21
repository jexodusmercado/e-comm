<template>
    <div class="container pt-5">
        <div class="row">
            <div class="col-3">
                <div class="pb-3">
                    <button>FRONT</button>
                    <button>BACK</button>
                </div>
                <div class="pb-3">
                    <label for="products"> SELECT PRODUCT </label>
                    <select id="products" v-model="selectedProduct" name="products">
                        <option value="crew"> MEN | Shirt </option>
                        <option value="mens_longsleeve"> MEN | Long Sleeve</option>
                        <option value="mens_tank"> MEN | Tank</option>
                        <option value="womens_crew"> WOMEN | Shirt</option>
                        <option value="mens_hoodie"> UNISEX | Sweater</option>
                    </select>
                </div>

                <div class="pb-1">
                    <strong>Please choose a color:</strong>
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
				<div id="tshirt_front" class="tshirt_div" v-if="this.hide_front">
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
import fabric from 'fabric';

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
                color: ''
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
