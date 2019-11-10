<template>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Mis estados</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                            <li class="breadcrumb-item active">Mis estados</li>
                        </ol>
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
                                                    <b-button size="xs" v-b-tooltip.hover title="Eliminar usuario" @click="borrar(row.item.id)" class="btn btn-danger">
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
    </div>
</template>

<script>

    const items = [];

    export default {
        data() {
            return {
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'created_at', label: 'FECHA', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null
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
            listarEstados (){
                let me=this;
                axios.get('/estados/usuario').then(function (response) {
                    me.items = response.data.estados;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            eliminarVideo(id){
                swal.fire({
                    title: '¿Esta seguro de eliminar este estado?',
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

                        axios.post('/video/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listarVideos();
                            swal.fire(
                                'El estado ha sido borrado',
                                'El registro ha sido actualizado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
        },
        mounted() {
            this.listarEstados();
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
</style>