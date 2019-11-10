<template>
    <div class="page-wrapper">
        <div class="container">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Publicaciones</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                            <li class="breadcrumb-item active">Publicaciones</li>
                        </ol>
                        <button type="button" @click="abrirModal()" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Agregar publicación a la plataforma"><i class="fa fa-plus-circle"></i> Agregar publicación</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <template>
                                    <div class="table-responsive">
                                        <b-container fluid>
                                            <!-- User Interface controls -->
                                            <b-row>
                                            <b-col md="6" class="my-1">
                                                <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                                <b-input-group>
                                                    <b-form-input v-model="filter" placeholder="Escribe para buscar" />
                                                    <b-input-group-append>
                                                    <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                                    </b-input-group-append>
                                                </b-input-group>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="6" class="my-1">
                                                <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                                <b-input-group>
                                                    <b-form-select v-model="sortBy" :options="sortOptions">
                                                    <option slot="first" :value="null">-- nada --</option>
                                                    </b-form-select>
                                                    <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                                    <option :value="false">Asc</option> <option :value="true">Desc</option>
                                                    </b-form-select>
                                                </b-input-group>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="6" class="my-1">
                                                <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                                <b-input-group>
                                                    <b-form-select v-model="sortDirection" slot="append">
                                                    <option value="asc">Asc</option> <option value="desc">Desc</option>
                                                    <option value="last">Último</option>
                                                    </b-form-select>
                                                </b-input-group>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="6" class="my-1">
                                                <b-form-group label-cols-sm="3" label="Por página" class="mb-0">
                                                <b-form-select :options="pageOptions" v-model="perPage" />
                                                </b-form-group>
                                            </b-col>
                                            </b-row>

                                            <!-- Main table element -->
                                            <b-table
                                                show-empty
                                                responsive
                                                striped
                                                borderless
                                                outlined
                                                small
                                                hover
                                                :items="items"
                                                :fields="fields"
                                                :current-page="currentPage"
                                                :per-page="perPage"
                                                :filter="filter"
                                                :sort-by.sync="sortBy"
                                                :sort-desc.sync="sortDesc"
                                                :sort-direction="sortDirection"
                                                @filtered="onFiltered"
                                            >

                                            <template slot="empty">
                                                <center><h5>No hay registros para mostrar.</h5></center>
                                            </template>

                                            <template slot="emptyfiltered">
                                                <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                            </template>

                                            <template slot="index" slot-scope="data">
                                                {{ data.index + 1 }}
                                            </template>

                                            <template slot="acciones" slot-scope="row">
                                                <template>
                                                    <b-button size="xs" v-b-tooltip.hover title="Eliminar aviso" @click="borrar(row.item.id)" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </b-button>
                                                </template>
                                            </template>

                                            </b-table>

                                            <b-row>
                                                <b-col md="6" class="my-1">
                                                    <b-pagination
                                                    :total-rows="totalRows"
                                                    :per-page="perPage"
                                                    v-model="currentPage"
                                                    class="my-0"
                                                    />
                                                </b-col>
                                            </b-row>
                                        </b-container>
                                    </div>
                                    
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade bs-example-modal-md" :class="{'mostrar' : modal.estado}" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Agregar publicación</h4>
                            <button type="button" class="close" @click="cerrarModalAviso()" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-body">
                                <div class="form-group row alert alert-danger" role="alert" v-show="errors.all().length > 0">
                                    <ul>
                                        <li v-for="error in errors.all()" v-bind:key="error">{{ error }}</li>
                                    </ul>
                                </div>
                                <form class="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Título de la publicación</label>
                                                    <input type="text" class="form-control" v-model="publicacion.titulo" name="Titulo" v-validate.continues="'required|alpha_spaces'" data-vv-scope="modal_publicacion">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Resumen de la publicación</label>
                                                    <textarea v-model="publicacion.resumen" class="form-control" rows="5" v-validate.continues="'required'" name="Resumen" data-vv-scope="modal_publicacion"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Contenido del publicación</label>
                                                    <textarea v-model="publicacion.contenido" class="form-control" rows="11" v-validate.continues="'required'" name="Contenido" data-vv-scope="modal_publicacion"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="form-group text-center">
                                                    <label for="">Imagen de la publicación</label>
                                                    <picture-input v-if="modal.estado" id="imagen_url" name="imagen_url" margin="10" 
                                                            ref="imagen_url"
                                                            height="510" 
                                                            width="510" 
                                                            required
                                                            :prefill="publicacion.imagen_url = obtenerImagenPublicacion()"
                                                            :custom-strings="opciones"
                                                            @change="publicacion.imagen_url = cargarImagen('imagen_url')">
                                                    </picture-input>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="subirPublicacion()" class="btn btn-info">Agregar</button>
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    const items = [];

    export default {
        data() {
            return {
                items: items,
                publicacion: {
                    titulo: '',
                    resumen: '',
                    contenido: '',
                    imagen_url: null
                },
                modal: {
                    estado: 0
                },
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'titulo', label: 'TÍTULO', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
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
        computed:{
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods:{
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            obtenerImagenPublicacion(){  
                return this.publicacion.imagen_url;         
            },
            cargarImagen(ref){  
                return this.$refs[ref].image;           
            },
            listarPublicaciones (){
                let me=this;
                axios.get('/publicaciones').then(function (response) {
                    me.items = response.data.publicaciones;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            abrirModal(){
                this.limpiarDatos();
                this.modal.estado = 1;
            },
            cerrarModal(){
                this.limpiarDatos();
                this.modal.estado = 0;
            },
            borrar(id){
                swal.fire({
                    title: '¿Esta seguro de eliminar esta publicacion?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.post('/publicacion/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listarPublicaciones();
                            swal.fire(
                                'La publicación ha sido borrada',
                                'El registro ha sido actualizado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
            limpiarDatos(){
                this.$validator.reset();
                this.publicacion.titulo = '';
                this.publicacion.resumen = '';
                this.publicacion.contenido = '';
                this.imagen_url = null;
            },
            subirPublicacion(){
                this.$validator.validateAll('modal_publicacion').then(valido => {
                    if (valido) {
                        let me = this;

                        const formData = new FormData();

                        const imagen = document.querySelector('#imagen_url');
                        formData.append('imagen', imagen.files[0]);
                        formData.append('titulo', me.publicacion.titulo);
                        formData.append('resumen', me.publicacion.resumen);
                        formData.append('contenido', me.publicacion.contenido);

                        axios.post('/publicacion/crear/administrador',formData).then(function (response) {
                            me.listarPublicaciones();
                            me.cerrarModal();                            
                            swal.fire(
                                'Publicación agregada con éxito',
                                'El registro ha sido agregado con éxito.',
                                'success'
                            )

                        }).catch(function (error) {
                            console.log(error.response.data);
                        });
                    }
                })
            },
        },
        mounted() {
            this.listarPublicaciones();
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

    .form-group{
        margin-bottom: 5px; 
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #000000b3 !important;
    }

</style>