<template>
    <section id="publicateEscort" class="ds section_padding_70 parallax fondo">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8 text-center">
                    <div class="form-group row alert alert-danger" role="alert" v-show="errors.all().length > 0 && estado == 1">
                        <ul>
                            <li class="text-left"  v-for="error in errors.all()" v-bind:key="error">{{ error }}</li>
                        </ul>
                    </div>
                    <br>
                    <form class="form">  
                        <h2 class="big margin_0" v-text="'Califica a ' + usuario.nombre"></h2>
                        <h2 class="muellerhoff topmargin_5 bottommargin_50 highlight">¿Te atendiste con ella?</h2>
    
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" v-model="calificacion.nombre_cliente" class="form-control" placeholder="Ingresa tu Alias" v-validate.continues="'required|alpha_spaces|min:2'" data-vv-scope="calificacion_usuario" @change="cambiarEstado()">
                            </div>
                        </div>                
                        <div class="row">
                            <div class="form-group col-md-6">
                                <select v-model="calificacion.fotos" class="form-control" v-validate.continues="'required|included:1,2,3'" data-vv-as="Fotos reales" data-vv-scope="calificacion_usuario" @change="cambiarEstado()">
                                    <option value="0">¿Las fotos son reales?</option>
                                    <option v-for="(item, index) in opciones" :key="index" :value="index + 1" v-text="item"></option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <select v-model="calificacion.atencion" class="form-control" v-validate.continues="'required|included:1,2,3'" data-vv-as="Atención" data-vv-scope="calificacion_usuario" @change="cambiarEstado()">
                                    <option value="0">¿Cómo fue tu atención?</option>
                                    <option v-for="(item, index) in opciones" :key="index" :value="index + 1" v-text="item"></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <select v-model="calificacion.higiene" class="form-control" v-validate.continues="'required|included:1,2,3'" data-vv-as="Higiene" data-vv-scope="calificacion_usuario" @change="cambiarEstado()">
                                    <option value="0">¿Cómo evaluarías la higiene?</option>
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
                                    :readonly="false"
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
                                    <input type="checkbox" id="rostro" class="custom-control-input" v-model="calificacion.rostro" value="1">
                                    <label class="custom-control-label" for="rostro">Rostro</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="cuerpo" class="custom-control-input" v-model="calificacion.cuerpo" value="1">
                                    <label class="custom-control-label" for="cuerpo">Cuerpo</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="trato" class="custom-control-input" v-model="calificacion.trato" value="1">
                                    <label class="custom-control-label" for="trato">Trato</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="besos" class="custom-control-input" v-model="calificacion.besos" value="1">
                                    <label class="custom-control-label" for="besos">Besos</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="cama" class="custom-control-input" v-model="calificacion.cama" value="1">
                                    <label class="custom-control-label" for="cama">Desempeño en la cama</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sexo_oral" class="custom-control-input" v-model="calificacion.sexo_oral" value="1">
                                    <label class="custom-control-label" for="sexo_oral">Sexo oral</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 m-b-20">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sexo_anal" class="custom-control-input" v-model="calificacion.sexo_anal" value="1">
                                    <label class="custom-control-label" for="sexo_anal">Sexo Anal</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="marcar" v-model="marcar" @click="marcar_desmarcar(1)">
                                    <label class="custom-control-label" for="marcar">Todas las anteriores</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="desmarcar" v-model="desmarcar" @click="marcar_desmarcar(0)">
                                    <label class="custom-control-label" for="desmarcar">Ninguna de las anteriores</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="button" name="registro" @click="calificar()" class="theme_button color1 bottommargin_0 btn-block"><i class="fa fa-paper-plane"></i> Enviar</button>
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
                    sexo_anal: 0
                },
                estado: 0,
                marcar: 0,
                desmarcar: 0
            }
        },
        methods: {
            calificar(){
                this.$validator.validateAll('calificacion_usuario').then(valido => {
                    if (valido) {
                        let me = this;

                        axios.post('/usuario/calificar',{
                            'calificacion': JSON.stringify(me.calificacion),
                            'usuario_id': this.usuario.id
                        }).then(function (response) {
                            me.calificacion.nombre_cliente = '';
                            me.calificacion.atencion = 0;
                            me.calificacion.higiene = 0;
                            me.calificacion.fotos = 0;
                            me.calificacion.nota = 0;
                            me.calificacion.rostro = 0;
                            me.calificacion.cuerpo = 0;
                            me.calificacion.trato = 0;
                            me.calificacion.besos = 0;
                            me.calificacion.cama = 0;
                            me.calificacion.sexo_oral = 0;
                            me.calificacion.sexo_anal = 0;

                            swal.fire(
                                'Calificación enviada con éxito',
                                '!Muchas gracias por tu opinión!',
                                'success'
                            );
                            me.estado = 0;

                        }).catch(function (error) {
                            console.log(error.response.data);
                        });
                    }
                })
            },
            cambiarEstado(){
                this.estado = 1;
            },
            marcar_desmarcar(accion){
                this.calificacion.rostro = accion;
                this.calificacion.cuerpo = accion;
                this.calificacion.trato = accion;
                this.calificacion.besos = accion;
                this.calificacion.cama = accion;
                this.calificacion.sexo_oral = accion;
                this.calificacion.sexo_anal = accion;  
                this.marcar = 0;
                this.desmarcar = 0;
            }
        }
    }
</script>

<style>
    .btn-block {
        width: 100%;
    }

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