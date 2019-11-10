<template>
    <section v-show="avisos.length > 0" id="avisos" class="ds section_padding_100 container_padding_60 bottompadding_10">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 class="section_header">¿Buscas algo o deseas publicar?</h2>
                    <p class="small-text highlight lusitana">Avisos eróticos</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-group">
                        <div v-for="(aviso, index) in avisos" :key="index"  class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a v-bind:href="'aviso/' + aviso.id">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 text-center">
                                                <img v-lazy="'storage/' + aviso.perfil_url" v-bind:alt="'Placerconce.cl - ' + aviso.usuario" class="img-fluid rounded" width="120px">
                                            </div>
                                            <div class="col-md-9 col-sm-3 text-left">
                                                <h3 v-text="aviso.usuario + ', ' + aviso.titulo"></h3>
                                                <p class="text-justify" v-text="aviso.contenido.substr(0, 200) + ' ... ver más aquí'"></p>
                                                <b></b>
                                                <p class="text-left" v-text="'Publicado hace ' + aviso.actualizado + ' horas'"></p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
    export default {
        props:[
            'ciudad'
        ],
        data() {
            return {
                avisos: []
            }
        },
        methods:{
            listarAvisos (){
                let me=this;
                axios.get('/avisos/' + this.ciudad).then(function (response) {
                    me.avisos = response.data.data;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
        },
        mounted() {
            this.listarAvisos();
        }
    }
</script>

<style>
    .panel-title h3 {
        text-transform: uppercase;
    }

    .rounded {
        border-radius: 1.5rem !important;
    }
</style>