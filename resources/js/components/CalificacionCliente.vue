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
                    <h2 class="big margin_0" v-text="'Califica al cliente'"></h2>
                    <h2 class="muellerhoff topmargin_5 bottommargin_50 highlight" v-text="'¿Estuviste con él?'"></h2>

                    <form class="form">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" aria-required="true" v-model="calificacion.nombre" class="form-control text-center" placeholder="Alias" v-validate.continues="'required'" name="alias" data-vv-scope="calificacion_cliente">
                            </div>
                        </div>                      
                        <div class="row">
                            <div class="form-group col-md-6">
                                <select v-model="calificacion.higiene" class="form-control" v-validate.continues="'required|included:1,2,3'" data-vv-as="Higiene" data-vv-scope="calificacion_cliente" @change="cambiarEstado()">
                                    <option value="0">¿Cómo evaluarías la higiene?</option>
                                    <option v-for="(item, index) in opciones" :key="index" :value="index + 1" v-text="item"></option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <select v-model="calificacion.respeto" class="form-control" v-validate.continues="'required|included:1,2,3'" data-vv-as="Atención" data-vv-scope="calificacion_cliente" @change="cambiarEstado()">
                                    <option value="0">¿Fue respetuoso?</option>
                                    <option v-for="(item, index) in opciones" :key="index" :value="index + 1" v-text="item"></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <select v-model="calificacion.dinero" class="form-control" v-validate.continues="'required|included:1,2,3'" data-vv-as="Fotos reales" data-vv-scope="calificacion_cliente" @change="cambiarEstado()">
                                    <option value="0">¿Cómo paga?</option>
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
                                    data-vv-as="Nota" data-vv-scope="calificacion_cliente"
                                    @change="cambiarEstado()"
                                />
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
                    nombre: '',
                    higiene: 0,
                    respeto: 0,
                    dinero: 0,
                    nota: 0
                },
                estado: 0
            }
        },
        methods: {
            calificar(){
                this.$validator.validateAll('calificacion_cliente').then(valido => {
                    if (valido) {
                        let me = this;

                        axios.post('/cliente/calificar',{
                            'calificacion': JSON.stringify(me.calificacion)
                        }).then(function (response) {
                            me.calificacion.nombre = "";
                            me.calificacion.atencion = 0;
                            me.calificacion.higiene = 0;
                            me.calificacion.fotos = 0;
                            me.calificacion.nota = 0;
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
            }
        }
    }
</script>

<style>
    .btn-block {
        width: 100%;
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