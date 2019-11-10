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
                        <button type="button" @click="abrirModal(1)" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un usuario a la plataforma"><i class="fa fa-plus-circle"></i> Agregar usuario</button>
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

                                            <template slot="tipo" slot-scope="row">
                                                <label for="" v-if="row.item.tipo_usuario == 2"> ESCORT </label>
                                                <label for="" v-else> PERSONA</label>
                                            </template>

                                            <template slot="acciones" slot-scope="row">
                                                <b-button size="xs" v-b-tooltip.hover title="Actualizar información modelo" @click="abrirModal(2, row.item)" class="btn btn-warning">
                                                    <i class="fa fa-pencil"></i>
                                                </b-button>

                                                <b-button size="xs" v-b-tooltip.hover title="Añadir video estado al usuario" @click="abrirModalVideoEstado(row.item.id)" class="btn btn-success">
                                                    <i class="fa fa-camera"></i>
                                                </b-button>

                                                <b-button size="xs" v-b-tooltip.hover title="Administrar videos del usuario" @click="abrirModalVideos(row.item.id)" class="btn btn-success">
                                                    <i class="fa fa-play"></i>
                                                </b-button>

                                                <b-button size="xs" v-b-tooltip.hover title="Administrar publicaciones del usuario" @click="abrirModalAviso(row.item.id)" class="btn btn-success">
                                                    <i class="fa fa-list"></i>
                                                </b-button>

                                                <template v-if="row.item.agencia == 1">
                                                    <b-button size="xs" v-b-tooltip.hover title="Quitar de la agencia" @click="agregarQuitarAgencia(row.item.id, 1)" class="btn btn-danger">
                                                        <i class="fa fa-star-o"></i>
                                                    </b-button>
                                                </template>
                                                <template v-else>
                                                    <b-button size="xs" v-b-tooltip.hover title="Añadir a la agencia" @click="agregarQuitarAgencia(row.item.id, 2)" class="btn btn-success">
                                                        <i class="fa fa-star"></i>
                                                    </b-button>
                                                </template>

                                                <template v-if="row.item.visible == 1">
                                                    <b-button size="xs" v-b-tooltip.hover title="Ocultar modelo" @click="ocultarMostrarUsuario(row.item.id, 1)" class="btn btn-danger">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </b-button>
                                                </template>
                                                <template v-else>
                                                    <b-button size="xs" v-b-tooltip.hover title="Mostrar modelo" @click="ocultarMostrarUsuario(row.item.id, 2)" class="btn btn-success">
                                                        <i class="fa fa-eye"></i>
                                                    </b-button>
                                                </template>

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

        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modal.estado}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                            <form class="for">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <h4 class="card-title text-center">Foto de Perfil</h4>   
                                        <picture-input v-if="modal.estado" id="foto_perfil" name="foto_perfil" margin="10" 
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
                                                    <input type="text" class="form-control" v-model="usuario.usuario" name="usuario" v-validate.continues="'required'" :readonly="modal.accion == 2" data-vv-scope="modal_usuario">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="clave">Clave</label>
                                                    <input type="password" class="form-control" v-model="usuario.clave" name="clave" v-validate.continues="modal.accion == 1 ? 'required' : ''" data-vv-scope="modal_usuario">
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
                                                    <picture-input v-if="modal.estado" :ref="'imagen_' + index" :id="'imagen_' + index" :name="'imagen_' + index" margin="10" 
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="modal.accion==1" class="btn btn-primary" @click="crearOactualizar(1)">Guardar</button>
                        <button type="button" v-if="modal.accion==2" class="btn btn-primary" @click="crearOactualizar(2)">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modal_video.estado}" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Vídeos</h4>
                        <button type="button" class="close" @click="cerrarModalVideo()" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="form-group row alert alert-danger" role="alert" v-show="errors.all().length > 0">
                                <ul>
                                    <li v-for="error in errors.all()" v-bind:key="error">{{ error }}</li>
                                </ul>
                            </div>
                            <form class="form m-t-20">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="video.titulo" placeholder="Título video" name="Titulo" v-validate.continues="modal_video.estado == 1 ? 'required|alpha_spaces' : ''" data-vv-scope="modal_video">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="video/*" id="video" name="video" v-validate.continues="modal_video.estado == 1 ? 'required' : ''" data-vv-scope="modal_video">
                                            <label class="custom-file-label" for="customFile">Buscar Vídeo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="button" v-b-tooltip.hover title="Ingresar videos al usuario" @click="subirVideo()" class="btn btn-info btn-block"><i class="fa fa-plus-circle"></i> Agregar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="table-responsive">
                                        <table id="" class="table table-bordered table-striped">
                                            <thead>
                                                <tr align="center">
                                                    <th>#</th>
                                                    <th>Título</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(video_usuario, index) in usuario.videos" :key="video_usuario.id" :value="video_usuario.id">
                                                    <td align="center" class="align-middle">{{ index + 1 }}</td>
                                                    <td class="align-left">{{ video_usuario.titulo }}</td>
                                                    <td align="center">
                                                        <button type="button" v-b-tooltip.hover title="Eliminar Vídeo" @click="eliminarVideo(video_usuario.id)"  class="btn btn-danger btn-xs">
                                                            <i class="icon-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalVideo()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modal_aviso.estado}" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Avisos</h4>
                        <button type="button" class="close" @click="cerrarModalAviso()" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="form-group row alert alert-danger" role="alert" v-show="errors.all().length > 0">
                                <ul>
                                    <li v-for="error in errors.all()" v-bind:key="error">{{ error }}</li>
                                </ul>
                            </div>
                            <form class="form m-t-20">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" v-model="aviso.titulo" placeholder="Título de aviso" name="Titulo" v-validate.continues="modal_aviso.estado == 1 ? 'required|alpha_spaces' : ''" data-vv-scope="modal_aviso">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea v-model="aviso.contenido" class="form-control" rows="10" placeholder="Ingresa el contenido del aviso aquí ......"   v-validate.continues="modal_aviso.estado == 1 ? 'required' : ''" name="Contenido" data-vv-scope="modal_aviso"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="button" v-b-tooltip.hover title="Ingresar aviso al usuario" @click="subirAviso()" class="btn btn-info btn-block-modal"><i class="fa fa-plus-circle"></i> Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-md-12">
                                            <div class="table-responsive tabla-altura">
                                                <table id="" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>#</th>
                                                            <th>Título</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tabla-altura">
                                                        <tr v-for="(aviso_usuario, index) in usuario.avisos" :key="aviso_usuario.id" :value="aviso_usuario.id">
                                                            <td align="center" class="align-middle">{{ index + 1 }}</td>
                                                            <td class="align-left">{{ aviso_usuario.titulo }}</td>
                                                            <td align="center">
                                                                <button type="button" v-b-tooltip.hover title="Eliminar aviso" @click="eliminarAviso(aviso_usuario.id)"  class="btn btn-danger btn-xs">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalAviso()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modal_video_estado.estado}" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Video Estado</h4>
                        <button type="button" class="close" @click="cerrarModalVideoEstado()" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <form class="form m-t-20">
                                <div class="form-group row">
                                    <div class="col-md-3"><button type="button" class="btn btn-block btn-info" id="start">INICIAR CAMARA</button></div>
                                    <div class="col-md-3"><button type="button" class="btn btn-block btn-success" id="record" disabled>GRABAR VÍDEO</button></div>
                                    <div class="col-md-3"><button type="button" class="btn btn-block btn-warning" id="play" disabled>REPRODUCIR</button></div>
                                    <div class="col-md-3"><button type="button" class="btn btn-block btn-danger" id="download" disabled>DESCARGAR Y SUBIR</button></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video id="gum" playsinline autoplay class="embed-responsive-item"></video>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video id="recorded" playsinline loop class="embed-responsive-item"></video>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalVideoEstado()">Cerrar</button>
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
                usuario: {
                    id: 0,
                    nombre: '',
                    telefono: null,
                    usuario: '',
                    clave: '',
                    edad: null,
                    nacionalidad: '',
                    ciudad_id: 0,
                    vende: 0,
                    altura: null,
                    busto: null,
                    cintura: null,
                    caderas: null,
                    descripcion: '',
                    perfil: null,
                    imagenes: [],
                    videos: [],
                    avisos: [],
                    video: null
                },
                video: {
                    titulo: ''
                },
                aviso: {
                    titulo: '',
                    contenido: ''
                },
                modal: {
                    titulo: '',
                    estado: 0,
                    accion: 0
                },
                modal_video: {
                    estado: 0
                },
                modal_video_estado: {
                    estado: 0
                },
                modal_aviso: {
                    estado: 0
                },
                items: items,
                ciudades: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'usuario', label: 'USUARIO', sortable: true, class: 'text-left' },
                    { key: 'tipo', label: 'TIPO USUARIO', sortable: true, class: 'text-left' },
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
            cargarImagen(ref){  
                return this.$refs[ref].image;           
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
            listarUsuarios (){
                let me=this;
                axios.get('/usuarios').then(function (response) {
                    me.items = response.data.usuarios;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error.response.data);
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
            listarVideos (){
                let me = this;
                axios.get('/video/usuario/' + me.usuario.id).then(function (response) {
                    me.usuario.videos = response.data.videos;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            listarAvisos (){
                let me = this;
                axios.get('/aviso/usuario/' + me.usuario.id).then(function (response) {
                    me.usuario.avisos = response.data.avisos;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            crearOactualizar(accion){
                let me = this;
                this.$validator.validateAll('modal_usuario').then(valido => {
                    if (valido) {

                        if(me.usuario.perfil == null || me.usuario.perfil == ''){
                            me.errors.add({
                                field: 'foto_perfil',
                                msg: 'La imagen de perfil es obligatoria.'
                            });

                            return false;
                        }

                        me.errors.clear();

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
                        
                        var url = accion == 1 ? '/usuario/crear' : '/usuario/actualizar';
                        axios.post(url, formData).then(function (response) {
                            me.cerrarModal();
                            me.listarUsuarios();
                            me.limpiarDatos();
                            var mensaje = me.modal.accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                            swal.fire({
                                type: 'success',
                                title: mensaje,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }).catch(function (error) {
                            if (error.response.status == 500 && accion == 1){
                                me.errors.add({
                                    field: 'crear',
                                    msg: 'El usuario ya esta en uso, intenta con otro por favor.'
                                })
                            } else {
                                console.error(error);
                            }
                        });
                    }
                })
            },
            borrar(id){
                swal.fire({
                    title: '¿Deseas quitar definitivamente al usuario de la plataforma?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Sí!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.post('/usuario/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.limpiarDatos();
                            me.listarUsuarios();
                            swal.fire(
                                'El usuario ha sido eliminado para siempre de la plataforma!',
                                'El registro ha sido eliminado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
            agregarQuitarAgencia(id, accion){
                var mensaje = accion == 2 ? '¿Deseas agregar el usuario a la agencia?' : '¿Deseas quitar el usuario de la agencia?';
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

                        axios.post('/usuario/agencia',{
                            'id': id
                        }).then(function (response) {
                            var mensaje_dos = accion == 2 ? 'El usuario ha sido agregado a la agencia!' : 'El usuario ha sido quitado de la agencia!';
                            me.limpiarDatos();
                            me.listarUsuarios();
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
            ocultarMostrarUsuario(id, accion){
                var mensaje = accion == 2 ? '¿Deseas mostrar el usuario en la página?' : '¿Deseas ocultar al usuario de la página?';
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

                        axios.post('/usuario/mostrar',{
                            'id': id
                        }).then(function (response) {
                            var mensaje_dos = accion == 2 ? 'El usuario es visible ahora en la página!' : 'El usuario se ha ocultado de la página!';
                            me.limpiarDatos();
                            me.listarUsuarios();
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
            cerrarModalVideo(){
                this.video.titulo = '';
                this.modal_video.estado = 0;
                this.usuario.id = 0;
                this.usuario.videos = [];
                $('#video').val(null);
                this.$validator.reset();
            },
            cerrarModalAviso(){
                this.aviso.titulo = '';
                this.aviso.contenido = ''
                this.modal_aviso.estado = 0;
                this.usuario.id = 0;
                this.usuario.avisos = [];
                this.$validator.reset();
            },
            cerrarModalVideoEstado(){
                this.modal_video_estado.estado = 0;
                this.usuario.id = 0;
            },
            limpiarDatos(){
                this.$validator.reset();
                this.usuario.id = 0;
                this.usuario.nombre = '';
                this.usuario.telefono = null;
                this.usuario.usuario = '';
                this.usuario.clave = '';
                this.usuario.edad = null;
                this.usuario.nacionalidad = '';
                this.usuario.ciudad_id = 0;
                this.usuario.altura = null;
                this.usuario.busto = null;
                this.usuario.cintura = null;
                this.usuario.caderas = null;
                this.usuario.descripcion = '';
                this.usuario.perfil = null;
                this.usuario.imagenes = [];
                this.usuario.video = null;
                this.usuario.vende = 0;
                $('#video_perfil').val(null);
            },
            abrirModal(accion, data = []){
                let me = this;

                me.modal.estado = 1;
                me.limpiarDatos();

                if(accion == 1){
                    me.modal.titulo = "Agregar usuario";
                    me.modal.accion = 1;
                    me.usuario.imagenes.push(null);
                } else if(accion == 2){
                    var url_imagenes = ["foto_uno_url", "foto_dos_url", "foto_tres_url", "foto_cuatro_url", "foto_cinco_url", "foto_seis_url", "foto_siete_url", "foto_ocho_url", "foto_nueve_url", "foto_diez_url", "foto_once_url", "foto_doce_url"];
                    me.modal.titulo = "Modificar usuario";
                    me.modal.accion = 2;

                    me.usuario.id = data['id'];
                    me.usuario.nombre = data['nombre'];
                    me.usuario.telefono = data['telefono'];
                    me.usuario.usuario = data['usuario'];
                    me.usuario.edad = data['edad'];
                    me.usuario.nacionalidad = data['nacionalidad'];
                    me.usuario.ciudad_id = data['ciudad_id'];
                    me.usuario.altura = data['altura'];
                    me.usuario.busto = data['busto'];
                    me.usuario.cintura = data['cintura'];
                    me.usuario.caderas = data['caderas'];
                    me.usuario.descripcion = data['descripcion'];
                    me.usuario.vende = data['vendedor'];

                    me.usuario.perfil = 'storage/' + data['perfil_url'];
                    me.obtenerImagenPerfil();
                    
                    url_imagenes.forEach(function(item) {
                        if(data[item] != null && data[item] != ''){
                            me.usuario.imagenes.push('storage/' + data[item]);
                        }
                    });

                    if(me.usuario.imagenes.length < 12){
                        me.usuario.imagenes.push(null);
                    }
                }
            },
            abrirModalVideos(id){
                let me = this;

                me.modal_video.estado = 1;
                me.usuario.id = id;

                me.listarVideos();
            },
            abrirModalVideoEstado(id){
                let me = this;

                me.modal_video_estado.estado = 1;
                me.usuario.id = id;
            },
            abrirModalAviso(id){
                let me = this;

                me.modal_aviso.estado = 1;
                me.usuario.id = id;

                me.listarAvisos();
            },
            subirVideo(){
                this.$validator.validateAll('modal_video').then(valido => {
                    if (valido) {
                        let me = this;

                        const formData = new FormData();

                        const video = document.querySelector('#video');
                        formData.append('video', video.files[0]);
                        formData.append('titulo', me.video.titulo);
                        formData.append('usuario_id', me.usuario.id);


                        axios.post('/video/crear/administrador',formData).then(function (response) {
                            me.listarVideos();
                            me.video.titulo = null;
                            me.$validator.reset();
                            $('#video').val(null);
                            
                            swal.fire(
                                'Vídeo agregado con éxito',
                                'El registro ha sido agregado con éxito.',
                                'success'
                            )

                        }).catch(function (error) {
                            console.log(error.response.data);
                        });
                    }
                })
            },
            subirAviso(){
                this.$validator.validateAll('modal_aviso').then(valido => {
                    if (valido) {
                        let me = this;

                        axios.post('/aviso/crear/administrador',{
                            'usuario_id': me.usuario.id,
                            'titulo': me.aviso.titulo,
                            'contenido': me.aviso.contenido
                        }).then(function (response) {
                            me.listarAvisos();
                            me.aviso.titulo = '';
                            me.aviso.contenido = '';
                            me.$validator.reset();
                            
                            swal.fire(
                                'Aviso agregado con éxito',
                                'El registro ha sido agregado con éxito.',
                                'success'
                            )

                        }).catch(function (error) {
                            console.log(error.response.data);
                        });
                    }
                })
            },
            eliminarVideo(id){
                swal.fire({
                    title: '¿Esta seguro de eliminar esta vídeo?',
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
                                'El vídeo ha sido borrado',
                                'El registro ha sido actualizado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
            eliminarAviso(id){
                swal.fire({
                    title: '¿Esta seguro de eliminar esta aviso?',
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

                        axios.post('/aviso/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listarAvisos();
                            swal.fire(
                                'El aviso ha sido borrado',
                                'El registro ha sido actualizado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            }
        },
        mounted() {
            this.listarUsuarios();
            this.listarCiudades();

            let me = this;

            'use strict';

            const mediaSource = new MediaSource();
            mediaSource.addEventListener('sourceopen', handleSourceOpen, false);

            let mediaRecorder;
            let recordedBlobs;
            let sourceBuffer;

            const recordedVideo = document.querySelector('video#recorded');
            const recordButton = document.querySelector('button#record');

            recordButton.addEventListener('click', () => {
                if (recordButton.textContent === 'GRABAR VÍDEO') {
                    startRecording();
                } else {
                    stopRecording();
                    recordButton.textContent = 'GRABAR VÍDEO';
                    playButton.disabled = false;
                    downloadButton.disabled = false;
                }
            });

            const playButton = document.querySelector('button#play');
                playButton.addEventListener('click', () => {
                const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
                recordedVideo.src = null;
                recordedVideo.srcObject = null;
                recordedVideo.src = window.URL.createObjectURL(superBuffer);
                recordedVideo.controls = true;
                recordedVideo.play();
            });

            const downloadButton = document.querySelector('button#download');
            downloadButton.addEventListener('click', () => {
                const blob = new Blob(recordedBlobs, {type: 'video/webm'});
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');

                let formData = new FormData();
                formData.append('video', blob);
                formData.append('usuario_id', me.usuario_id);

                axios.post('/video/estado/crear', formData).then(function (response) {
                    me.cerrarModalVideoEstado();

                    swal.fire({
                        type: 'success',
                        title: 'Vídeo estado cargado correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'video.webm';
                    document.body.appendChild(a);
                    a.click();
                    setTimeout(() => {
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    }, 100);

                }).catch(function (error) {
                    console.error(error);
                });
            });

            function handleSourceOpen(event) {
            sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"');
            }

            function handleDataAvailable(event) {
            if (event.data && event.data.size > 0) {
                recordedBlobs.push(event.data);
            }
            }

            function startRecording() {
            recordedBlobs = [];
            let options = {mimeType: 'video/webm;codecs=vp9'};
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                options = {mimeType: 'video/webm;codecs=vp8'};
                if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                options = {mimeType: 'video/webm'};
                if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                    options = {mimeType: ''};
                }
                }
            }

            try {
                mediaRecorder = new MediaRecorder(window.stream, options);
            } catch (e) {
                return;
            }

            console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
            recordButton.textContent = 'PARAR GRABACIÓN';
            playButton.disabled = true;
            downloadButton.disabled = true;
            mediaRecorder.ondataavailable = handleDataAvailable;
            mediaRecorder.start(10); // collect 10ms of data
            console.log('MediaRecorder started', mediaRecorder);
            }

            function stopRecording() {
                mediaRecorder.stop();
            }

            function handleSuccess(stream) {
                recordButton.disabled = false;
                window.stream = stream;

                const gumVideo = document.querySelector('video#gum');
                gumVideo.srcObject = stream;
            }

            async function init(constraints) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    handleSuccess(stream);
                } catch (e) {
                   return;
                }
            }

            document.querySelector('button#start').addEventListener('click', async () => {
                const constraints = {
                    video: {
                    width: 1280, height: 720
                    }
                };
                await init(constraints);
            });
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