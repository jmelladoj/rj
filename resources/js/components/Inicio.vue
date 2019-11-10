<template>
    <section v-show="ciudad.id == 0" id="about" class="ds ms page_about parallax section_padding_100 columns_padding_25 columns_margin_bottom_30">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 class="section_header">Bienvenidos</h2>
                    <p class="small-text highlight lusitana">* Date un relajo *</p>
                </div>
            </div>
            <div class="col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6 text-center">
                <select class="form-control" v-model="ciudad.id" @change="cambiarCiudad()">
                    <option value="0">Selecciona tu ciudad</option>
                    <option v-for="(ciudad, index) in ciudades" :key="index" :value="ciudad.id" v-text="ciudad.nombre"></option>
                </select>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </section> 
</template>

<script>
    export default {
        data() {
            return {
                ciudad:{
                    id: 0
                },
                ciudades: []
            }
        },    
        methods:{
            listarCiudades (){
                let me=this;
                axios.get('/ciudades/usuario').then(function (response) {
                    me.ciudades = response.data.ciudades;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            cambiarCiudad(){
                let me = this;
                this.$root.ciudad = me.ciudad.id;
            }
        },
        mounted() {
            this.listarCiudades();
        }
    }
</script>