<template>
    <section v-show="usuarios.length > 0" id="valoradas" class="ds section_padding_100 container_padding_60 bottompadding_10">
        <div class="container-fluid">
            <div class="row bottommargin_50 boxed-padding">
                <div class="col-lg-12 text-lg-left">
                    <h2 class="muellerhoff topmargin_5 bottommargin_50 highlight">TOP 10 MEJOR VALORADAS</h2>
                </div>
            </div>

            <div class="isotope row masonry-layout columns_margin_0 columns_padding_0">
                <div v-for="usuario in usuarios.slice(0, 10)" :key="usuario.id" class="isotope-item">
                    <div class="vertical-item content-absolute hover-content type2 text-center">
                        <div class="item-media">
                            <a v-bind:href="'modelo/' + usuario.id + '/ver'">
                                <img v-lazy="'storage/' + usuario.perfil_url" v-bind:alt="'Placerconce.cl - ' + usuario.nombre" class="perfil-imagen">
                            </a>
                        </div>
                        <div class="item-content transp_gradient_bg text-center">
                            <p class="iconos">
                                <a class="p-link" v-bind:href="usuario.whatsapp" target="_blank"><img src="../../../public/general/images/whatsapp.png" height="30px" width="30px" alt=""></a>
                                <a class="p-link espacio-izquierda" v-bind:href="'tel:+' + usuario.telefono" target="_blank"><img src="../../../public/general/images/telefono.png" height="30px" width="30px" alt=""></a>
                            </p>
                            <a class="p-link" title="" v-bind:href="'modelo/' + usuario.id + '/ver'" v-text="usuario.nombre"></a>     
                            <p><i class="fa fa-map-marker" aria-hidden="true"></i> {{ usuario.ciudad }}</p>  
                            <p v-text="'Edad: ' + usuario.edad"></p>
                            <p v-if="usuario.busto != 0 && usuario.cintura != 0 && usuario.caderas != 0" class="medidas" v-text="'Medidas: ' + usuario.busto + '-' + usuario.cintura + '-' + usuario.caderas"></p>
                            <p class="medidas" v-text="'Actualizado hace ' + usuario.actualizado + ' horas'"></p>
                            <label for=""><i class="fa fa-star" v-for="(item, index) in usuario.nota" :key="index"></i></label>
                        </div>
                    </div>
                </div>                     
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            'ciudad'
        ],
        data() {
            return {
                usuarios: []
            }
        },
        methods:{
            listarUsuarios (){
                let me=this;
                axios.get('/usuarios/mejor_valoradas/' + this.ciudad).then(function (response) {
                    me.usuarios = response.data.data;

                    me.usuarios = me.usuarios.filter(u => u.nota > 0);

                    me.usuarios.sort(function (a, b) {
                        if (a.nota > b.nota) {
                            return -1;
                        }
                        if (a.nota < b.nota) {
                            return 1;
                        }
                        
                        return 0;
                    });

                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
        },
        mounted() {
            this.listarUsuarios();
        }
    }
</script>

<style>
    .medidas {
        font-size: 12px;
    }

    .p-link {
        text-transform: uppercase;
        font-size: 15px;
    }

    .espacio-izquierda {
        margin-left: 6px;
    }

    .fa-star{
        display: inline-flex;
        color: yellow;
    }

    .altura {
        height: auto;
    }

    .item-media {
        margin: 10px 10px 0px 10px;
    }

    .item-content {
        margin: 0px 10px 0px 10px;
    }

    @media (min-width: 240px) {
        .isotope-item {
            width: 50%;
        }

        .perfil-imagen {
            width:110%;
            height:390px;
            padding-bottom:180px;
            border-radius:1em;
            -o-object-fit: cover;
            object-fit:cover;
            margin-bottom:-180px;
        }

        .item-media {
            position: relative;
            overflow: hidden;
            margin: 2px 2px 0px 2px;
        }
        
        .item-content {
            margin: 0px 2px 0px 2px;
        }
    }

    @media (min-width: 768px) {
        .isotope-item {
            width: 33.33%;
        }

        .perfil-imagen {
            width:100%;
            height:400px;
            padding-bottom:0px;
            border-radius:1em;
            object-fit:cover;
            margin-bottom:-20px;
        }

        .item-media {
            position: relative;
            overflow: hidden;
            margin: 10px 10px 0px 10px;
        }

        .item-content {
            margin: 0px 10px 0px 10px;
        }
    }
    @media (min-width: 992px) {
        .isotope-item {
            width: 25%;
        }

        .models_square .vertical-item.content-absolute .item-content {
            margin-top: -30px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .perfil-imagen {
            width: 100%;
            height: 400px;
            padding-bottom: 20px;
            border-radius: 1em;
        }

    }

</style>