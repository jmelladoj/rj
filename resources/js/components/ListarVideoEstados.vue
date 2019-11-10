<template>
    <section v-show="usuarios.length > 0" id="independientes" class="ds page_models models_square gorizontal_padding section_padding_70 columns_padding_0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-3 text-center" v-for="usuario in usuarios" :key="usuario.id">
                    <img v-lazy="'storage/' + usuario.perfil_url" v-bind:alt="'Placerconce.cl - ' + usuario.nombre" class="rounded-circle" @click="cargarVideo(usuario.estado_url)">
                    <p v-text="'Hace ' + usuario.creado + ' horas'"></p>
                </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-md" :class="{'mostrar' : modal_video.estado}" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-body">
                            <div align="center" class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" :src="'storage/' + modal_video.video_url" controls autoplay></video>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" @click="cerrarModalVideo()">Cerrar</button>
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
                usuarios: [],
                modal_video: {
                    estado: 0,
                    video_url: ""
                },
            }
        },
        methods:{
            listarUsuarios (){
                let me=this;
                axios.get('/video/estado/' + this.ciudad).then(function (response) {
                    me.usuarios = response.data.data;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            cargarVideo(url){
                let me = this;
                me.modal_video.estado = 1;
                me.modal_video.video_url = url;
            },
            cerrarModalVideo(){
                let me = this;
                me.modal_video.estado = 0;
                me.modal_video.video_url = "";
            }
        },
        mounted() {
            this.listarUsuarios();
        }
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }

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

    .altura {
        height: auto;
    }

    .rounded-circle{
        border-radius: 100%;
        padding: 20px;
        max-height: 150px;
        max-width: 150px;
        border-color: '#FA8072';
        border-width: 10px;
    }

    @media (min-width: 240px) {
        .modal-content{
            width: 100% !important;
            position: absolute !important;
        }

        .modal-body{
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .isotope-item {
            width: 50%;
        }

        .perfil-imagen {
            width:100%;
            height:220px;
            padding-bottom:0px;
            border-radius:1em;
            object-fit:cover;
            margin-bottom:-20px;
        }

        .item-media {
            position: relative;
            overflow: hidden;
            margin: 2px;
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
            margin: 2px;
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

        .item-media {
            margin: 10px 10px 0px 10px;
        }

    }

</style>