<template>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Ciudades</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                            <li class="breadcrumb-item active">Ciudades</li>
                        </ol>
                        <button type="button" @click="abrirModal(1)" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Agrega una ciudad a la plataforma"><i class="fa fa-plus-circle"></i> Agregar ciudad</button>
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
                                                <b-button size="xs" v-b-tooltip.hover title="Actualizar información de Ciudad" @click="abrirModal(2, row.item)" class="btn btn-warning">
                                                    <i class="fa fa-pencil"></i>
                                                </b-button>


                                                <template>
                                                    <b-button v-if="row.item.deleted_at" size="xs" v-b-tooltip.hover title="Restaurar Ciudad" @click="borrarOrestaurar(row.item.id, 2)" class="btn btn-warning">
                                                        <i class="fa fa-undo"></i>
                                                    </b-button>

                                                    <b-button v-else size="xs" v-b-tooltip.hover title="Eliminar Ciudad" @click="borrarOrestaurar(row.item.id, 1)"  class="btn btn-danger">
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

        </div>

        <div class="modal fade bs-example-modal-md" :class="{'mostrar' : modal.estado}" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel" v-text="modal.titulo"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
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
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Nombre Ciudad</label>
                                                <input type="text" class="form-control" v-model="ciudad.nombre" name="Titulo" v-validate.continues="'required|alpha_spaces'" data-vv-as="nombre" data-vv-scope="modal_ciudad">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="modal.accion==1" class="btn btn-primary" @click="crearOactualizar(1)">Guardar</button>
                        <button type="button" v-if="modal.accion==2" class="btn btn-primary" @click="crearOactualizar(2)">Actualizar</button>
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
                ciudad: {
                    id: 0,
                    nombre: ''
                },
                modal: {
                    titulo: '',
                    estado: 0,
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
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
                indice: 0
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
            listrarCiudades (){
                let me=this;
                axios.get('/ciudades/administrador').then(function (response) {
                    me.items = response.data.ciudades;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            crearOactualizar(accion){
                let me = this;

                this.$validator.validateAll('modal_ciudad').then(valido => {
                    if (valido) {
                        this.$validator.reset();

                        var url = accion == 1 ? '/ciudad/crear' : '/ciudad/actualizar';
                        axios.post(url,{
                            'ciudad_id': me.ciudad.id,
                            'nombre': me.ciudad.nombre
                        }).then(function (response) {
                            me.listrarCiudades();
                            me.cerrarModal();
                            var mensaje = me.modal.accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                            swal.fire({
                                type: 'success',
                                title: mensaje,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }).catch(function (error) {
                            console.error(error);
                        });
                    }
                })
            },
            borrarOrestaurar(id, accion){
                var mensaje = accion == 2 ? '¿Deseas restaurar la Ciudad?' : '¿Deseas borrar la Ciudad?';
                swal.fire({
                    title: mensaje,
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

                        axios.post('/ciudad/borrar',{
                            'id': id
                        }).then(function (response) {
                            var mensaje_dos = accion == 2 ? 'La Ciudad ha sido restaurada!' : 'La Ciudad ha sido quitada!';
                            me.limpiarDatos();
                            me.listrarCiudades();
                            swal.fire(
                                mensaje_dos,
                                'El registro ha sido actualizado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal.estado = 0;
                this.modal.titulo = "";
                this.modal.accion = 0;
                this.limpiarDatos();

            },
            limpiarDatos(){
                this.$validator.reset();
                this.ciudad.id = 0;
                this.ciudad.nombre = '';
            },
            abrirModal(accion, data = []){
                let me = this;

                me.modal.estado = 1;
                me.limpiarDatos();

                if(accion == 1){
                    me.modal.titulo = "Agregar ciudad";
                    me.modal.accion = 1;
                } else if(accion == 2){
                    me.modal.titulo = "Modificar ciudad";
                    me.modal.accion = 2;

                    me.ciudad.id = data['id'];
                    me.ciudad.nombre = data['nombre'];
                }
            },
        },
        mounted() {
            this.listrarCiudades();
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

    .custom-file-input:lang(en) ~ .custom-file-label::after {
        content: 'Buscar';
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;   
        cursor: inherit;
        display: block;
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

    .tabla-altura {
        max-height: 325px;
    }

</style>