<template>

    <section v-show="publicaciones.length > 0" class="ds section_padding_100 columns_margin_bottom_20">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 class="section_header">Blog</h2>
                    <p class="small-text highlight lusitana">Publicaciones de la página</p>
                </div>
            </div>
            <div class="row">
                <div v-for="(publicacion, index) in publicaciones" :key="index" class="col-md-4 col-sm-6">
                    <article class="vertical-item content-padding with_background bottom_color_border text-center">
                        <div class="item-media">
                            <img v-lazy="'storage/' + publicacion.imagen" v-bind:alt="'Placerconce.cl - ' + publicacion.titulo">
                            <div class="media-links">
                                <a v-bind:href="'publicacion/' + publicacion.id" class="abs-link"></a>
                            </div>
                        </div>
                        <div class="item-content">
                            <header class="entry-header">
								<h3 class="entry-title">
									<a v-bind:href="'publicacion/' + publicacion.id" v-text="publicacion.titulo"></a>
								</h3>
                                <p class="text-justify" v-text="publicacion.resumen.substr(0, 200) + ' ... ver más aquí'"></p>
								<p class="text-center" v-text="'Publicado hace ' + publicacion.creado + ' horas.'"></p>
							</header>
                        </div>
                    </article>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                publicaciones: []
            }
        },
        methods:{
            listarPublicaciones (){
                let me=this;
                axios.get('/publicaciones/pagina').then(function (response) {
                    me.publicaciones = response.data.data;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
        },
        mounted() {
            this.listarPublicaciones();
        }
    }
</script>
