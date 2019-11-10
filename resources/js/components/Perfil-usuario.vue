<template>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Usuarios</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                            <li class="breadcrumb-item active">Usuarios</li>
                        </ol>
                        <button type="button" @click="actualizarPerfil()" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza la información sobre tu perfil"><i class="fa fa-plus-circle"></i> Actualizar información</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row alert alert-danger" role="alert" v-show="errors.all().length > 0">
                                <ul>
                                    <li v-for="error in errors.all()" v-bind:key="error">{{ error }}</li>
                                </ul>
                                <br>
                            </div>
                            <form class="for">
                                <div class="form-group row">
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control" v-model="link" readonly>
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-info" v-clipboard:copy="link" v-clipboard:success="copiarEnlace"> Presiona para copiar tu link</button>      
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <h4 class="card-title text-center">Foto de Perfil</h4>   
                                        <picture-input id="foto_perfil" name="foto_perfil" margin="10" 
                                                ref="perfil"
                                                size="10"
                                                :prefill="usuario.perfil = obtenerImagenPerfil()"
                                                :custom-strings="opciones"
                                                @change="usuario.perfil = cargarImagen('perfil')">
                                        </picture-input>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="card-title text-center">Datos</h4> 
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="alias">Alias</label>
                                                    <input type="text" class="form-control" v-model="usuario.nombre" name="nombre" v-validate.continues="'required'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="telefono">Teléfono</label>
                                                    <input type="number" class="form-control" v-model="usuario.telefono" name="telefono" v-validate.continues="'required|numeric|digits:9'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Usuario</label>
                                                    <input type="text" class="form-control" v-model="usuario.usuario" name="usuario" readonly data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="clave">Clave</label>
                                                    <input type="password" class="form-control" v-model="usuario.clave" name="clave"  data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="edad">Edad</label>
                                                    <input type="number" class="form-control" v-model="usuario.edad" name="edad" v-validate.continues="'required|numeric|between:18,99'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="nacionalidad">Nacionalidad</label>
                                                    <input type="text" class="form-control" v-model="usuario.nacionalidad" name="nacionalidad" v-validate.continues="'required|alpha_spaces'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label> Ciudad</label>
                                                <select class="form-control p-0" v-model="usuario.ciudad_id" name="ciudad" v-validate.continues="'required|min:1'" data-vv-scope="modal_usuario">
                                                    <option value="0">Selecciona una opción</option>
                                                    <option v-for="(ciudad, index) in ciudades" :key="index" :value="ciudad.id" v-text="ciudad.nombre"></option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label> ¿Vende?</label>
                                                <select class="form-control p-0" v-model="usuario.vende" name="vende" v-validate.continues="'required|included:0,1'" data-vv-scope="modal_usuario">
                                                    <option value="0">No</option>
                                                    <option value="1">Sí</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Altura (MT)</label>
                                                    <input type="text" class="form-control" v-model="usuario.altura" name="altura" v-validate.continues="'required'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Busto (CM)</label>
                                                    <input type="number" class="form-control" v-model.number="usuario.busto" name="busto" v-validate.continues="'required|numeric|between:1,250'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Cintura (CM)</label>
                                                    <input type="number" class="form-control" v-model.number="usuario.cintura" name="cintura" v-validate.continues="'required|numeric|between:1,250'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Caderas (CM)</label>
                                                    <input type="number" class="form-control" v-model.number="usuario.caderas" name="caderas" v-validate.continues="'required|numeric|between:1,250'" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h4 class="card-title text-left">Vídeo</h4> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b-form-file id="video_perfil" name="video_perfil"
                                                        v-model="usuario.video"
                                                        accept="video/*"
                                                        placeholder="Selecciona tu vídeo"
                                                        drop-placeholder="Arrastra y suelta aquí..."
                                                        >
                                                    </b-form-file>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nombre">Descripción sobre ti .....</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="4" v-model="usuario.descripcion" name="descripcion" v-validate.continues="'required|min:5'" data-vv-scope="modal_usuario"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <div class="form-group">
                                                <h4 class="card-title text-left">Fotos de galería (12 como máximo)</h4> 
                                            </div>
                                        </div> 
                                        <div class="form-group row row-eq-height">
                                            <div class="col-md-3" v-for="(imagen, index) in usuario.imagenes" :key="index">
                                                <div class="form-group">
                                                    <picture-input :ref="'imagen_' + index" :id="'imagen_' + index" :name="'imagen_' + index" margin="10" 
                                                        size="10"
                                                        :prefill="obtenerImagenGaleria(index)"
                                                        :custom-strings="opciones"
                                                        @change="usuario.imagenes[index] = cargarImagenGaleria('imagen_' + index)">
                                                    </picture-input>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>         
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    const items = [];

    import VueClipboard from 'vue-clipboard2'
    
    Vue.use(VueClipboard)


    export default {
        data() {
            return {
                link: '',
                usuario: {
                    id: 0,
                    nombre: '',
                    telefono: null,
                    usuario: '',
                    clave: '',
                    edad: null,
                    nacionalidad: '',
                    ciudad_id: 0,
                    altura: null,
                    busto: null,
                    cintura: null,
                    caderas: null,
                    descripcion: '',
                    perfil: null,
                    imagenes: [],
                    vende: 0,
                    video: null
                },
                indice: 0,
                ciudades: [],
                opciones: {
                    upload: '<p>Su dispositivo no admite la carga de archivos.</p>',
                    drag: 'Toca y selecciona <br> o arrastra',
                    tap: 'Toque aquí para seleccionar una foto <br> desde tu galería',
                    change: 'Cambiar foto',
                    remove: 'Eliminar foto',
                    select: 'Seleccionar foto',
                    selected: '<p>!Foto seleccionada exitosamente!</p>',
                    fileSize: 'El tamaño del archivo supera el límite',
                    fileType: 'Este tipo de archivo no es compatible.',
                    aspect: 'Landscape/Portrait'
                }
            }
        },    
        methods:{
            listarUsuario (){
                let me=this;

                this.usuario.imagenes = [];

                axios.get('/usuario/obtener').then(function (response) {
                    var url_imagenes = ["foto_uno_url", "foto_dos_url", "foto_tres_url", "foto_cuatro_url", "foto_cinco_url", "foto_seis_url", "foto_siete_url", "foto_ocho_url", "foto_nueve_url", "foto_diez_url", "foto_once_url", "foto_doce_url"];

                    me.usuario.id = response.data.usuario.id,
                    me.usuario.nombre = response.data.usuario.nombre,
                    me.usuario.telefono = response.data.usuario.telefono,
                    me.usuario.usuario = response.data.usuario.usuario,
                    me.usuario.edad = response.data.usuario.edad,
                    me.usuario.nacionalidad = response.data.usuario.nacionalidad,
                    me.usuario.ciudad_id = response.data.usuario.ciudad_id,
                    me.usuario.altura = response.data.usuario.altura,
                    me.usuario.busto = response.data.usuario.busto,
                    me.usuario.cintura = response.data.usuario.cintura,
                    me.usuario.caderas = response.data.usuario.caderas,
                    me.usuario.descripcion = response.data.usuario.descripcion,
                    me.usuario.perfil = 'storage/' + response.data.usuario.perfil_url;
                    me.link = "www.placerconce.cl/modelo/" + response.data.usuario.id + "/ver";
                    
                    url_imagenes.forEach(function(item) {
                        if(response.data.usuario[item] != null){
                            me.usuario.imagenes.push('storage/' + response.data.usuario[item]);
                        }
                    });

                    console.log(me.usuario.imagenes);

                    if(me.usuario.imagenes.length == 0){
                        me.usuario.imagenes.push(null);
                    }

                    me.indice = me.usuario.imagenes.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarCiudades (){
                let me=this;
                axios.get('/ciudades/usuario').then(function (response) {
                    me.ciudades = response.data.ciudades;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            actualizarPerfil(){
                let me = this;
                this.$validator.validateAll('perfil_usuario').then(valido => {
                    if (valido) {

                        if(me.usuario.perfil == null || me.usuario.perfil == ''){
                            me.errors.add({
                                field: 'foto_perfil',
                                msg: 'La imagen de perfil es obligatoria.'
                            });

                            return false;
                        }

                        me.$validator.reset();

                        let formData = new FormData();
                        let f_perfil = document.querySelector('#foto_perfil');
                        formData.append('imagen_perfil', f_perfil.files[0]);
                        
                        let video = document.querySelector('#video_perfil');
                        formData.append('video', video.files[0]);

                        me.usuario.imagenes.forEach(function(item, index) {
                            let imagen = document.querySelector('#imagen_' + index);
                            formData.append('foto_' + (index + 1), imagen.files[0]);
                        });

                        formData.append('usuario', JSON.stringify(me.usuario));

                        axios.post('/usuario/actualizar', formData).then(function (response) {
                            me.listarUsuario();
                            swal.fire({
                                type: 'success',
                                title: 'Perfil actualizado exitosamente',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                })
            },
            obtenerImagenPerfil(){  
                return this.usuario.perfil;         
            },
            obtenerImagenGaleria(index){  
                if(this.usuario.imagenes[index] != null){
                    return this.usuario.imagenes[index];        
                } 
            },
            cargarImagenGaleria(ref, index){

                if(this.usuario.imagenes.length < 12){
                    this.usuario.imagenes.push(null);
                }

                return this.$refs[ref][0].image; 
            },
            borrarImagen(index){
                this.usuario.imagenes.splice(index, 1);
                this.indice -= 1;
            },
            copiarEnlace(){
                swal.fire({
                    type: 'success',
                    title: 'Enlace copiado exitosamente',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        },
        mounted() {
            this.listarUsuario();
            this.listarCiudades();
        }
    }
</script>

<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }

    .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .modal-lg{
        max-width: 90%;
    }

    .form-group{
        margin-bottom: 5px; 
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #000000b3 !important;
    }

    .btn-bottom{
        bottom: 0;
        position: absolute;
    }  

    .btn-block {
        width: 90%;
    }

    .btn-block-modal {
        width: 100%;
    }

    .picture-input {
        position: sticky;
    }

</style>