<template>
    <section v-show="calificaciones.length > 0" class="ds model-page section_padding_70 section_padding_bottom_60 columns_padding_25">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8 text-center">
                    <form class="form">  
                        <h2 class="big margin_0" v-text="'Revisa sus calificaciones'"></h2>
                        <h2 class="muellerhoff topmargin_5 bottommargin_50 highlight">Selecciona alguna</h2>
    
                        <div class="row">
                            <div class="form-group col-md-12">
                                <select class="form-control" :change="ver_calificacion()" v-model="calificacion.id">
                                    <option value="0">Calificaciones</option>
                                    <option v-for="(item, index) in calificaciones" :key="index" :value="item.id" v-text="'Calificación de ' + item.nombre + ' - ' + item.fecha"></option>
                                </select>
                            </div>
                        </div>

                        <div v-show="calificacion.id != 0">   
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <select v-model="calificacion.fotos" class="form-control" disabled>
                                        <option value="0">¿Las fotos eran reales?</option>
                                        <option v-for="(item, index) in opciones" :key="index" :value="index + 1" v-text="item"></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <select v-model="calificacion.atencion" class="form-control" disabled>
                                        <option value="0">¿Cómo fue la atención?</option>
                                        <option v-for="(item, index) in opciones" :key="index" :value="index + 1" v-text="item"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <select v-model="calificacion.higiene" class="form-control" disabled>
                                        <option value="0">¿Cómo fue la higiene?</option>
                                        <option v-for="(item, index) in opciones" :key="index" :value="index + 1" v-text="item"></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 v-center">
                                    <label for="" class="label-control col-md-4">Nota final: </label>
                                    <vue-stars
                                        v-model="calificacion.nota"
                                        :active-color="'#ffdd00'"
                                        :inactive-color="'#999999'"
                                        :shadow-color="'#ffff00'"
                                        :hover-color="'#dddd00'"
                                        :max="7"
                                        :readonly="true"
                                        :char="'★'"
                                        class="col-md-8"
                                        v-validate.continues="'required|between:1,7'"
                                        data-vv-as="Nota" data-vv-scope="calificacion_usuario"
                                        @change="cambiarEstado()"
                                    />
                                </div>
                            </div>
                            <br>
                            <h2 class="muellerhoff topmargin_5 bottommargin_50 highlight">Puntos sobresalientes, selecciona hasta tres:</h2>
                            <div class="form-group row text-left">
                                <div class="col-md-4 col-sm-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="rostro" class="custom-control-input" v-model="calificacion.rostro" readonly>
                                        <label class="custom-control-label" for="rostro">Rostro</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="cuerpo" class="custom-control-input" v-model="calificacion.cuerpo" readonly>
                                        <label class="custom-control-label" for="cuerpo">Cuerpo</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="trato" class="custom-control-input" v-model="calificacion.trato" readonly>
                                        <label class="custom-control-label" for="trato">Trato</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="besos" class="custom-control-input" v-model="calificacion.besos" readonly>
                                        <label class="custom-control-label" for="besos">Besos</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="cama" class="custom-control-input" v-model="calificacion.cama" readonly>
                                        <label class="custom-control-label" for="cama">Desempeño en la cama</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="sexo_oral" class="custom-control-input" v-model="calificacion.sexo_oral" readonly>
                                        <label class="custom-control-label" for="sexo_oral">Sexo oral</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 m-b-20">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" v-model="calificacion.sexo_anal" readonly>
                                        <label class="custom-control-label" for="sexo_anal">Sexo Anal</label>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            'usuario'
        ],
        data() {
            return {
                opciones: [
                    'Bajo',
                    'Regular',
                    'Óptimo'
                ],
                calificacion: {
                    id: 0,
                    nombre_cliente: '',
                    atencion: 0,
                    higiene: 0,
                    fotos: 0,
                    nota: 0,
                    rostro: 0,
                    cuerpo: 0,
                    trato: 0,
                    besos: 0,
                    cama: 0,
                    sexo_oral: 0,
                    sexo_anal: 0,
                },
                calificaciones: []
            }
        },
        methods: {
            listarValoraciones (){
                let me=this;
                axios.get('/valoraciones/usuario/' + this.usuario.id).then(function (response) {
                    me.calificaciones = response.data.data;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            ver_calificacion(){
                let me = this;

                var calificacion = me.calificaciones.find(function(c) {
                    return c.id == me.calificacion.id;
                });

                if(calificacion){
                    me.calificacion.atencion = calificacion.atencion;
                    me.calificacion.higiene = calificacion.higiene;
                    me.calificacion.fotos = calificacion.fotos;
                    me.calificacion.nota = calificacion.nota;
                    me.calificacion.rostro = calificacion.rostro;
                    me.calificacion.cuerpo = calificacion.cuerpo;
                    me.calificacion.trato = calificacion.trato;
                    me.calificacion.besos = calificacion.besos;
                    me.calificacion.cama = calificacion.cama;
                    me.calificacion.sexo_oral = calificacion.sexo_oral;
                    me.calificacion.sexo_anal = calificacion.sexo_anal;
                }
            }
        },
        mounted() {
            this.listarValoraciones();
        }
    }
</script>

<style>
    .parallax {
        background-repeat: initial;
    }

    .v-center {
        display: inline-block;
        vertical-align: middle;
        float: none;
    }

    .vue-stars {
        font-size: 20px;
    }

    .swal2-popup {
        font-size: 1.2rem;
    }
</style>