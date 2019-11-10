<template>
    <section id="publicateEscort" class="ds ms parallax page_contact section_padding_top_100 section_padding_bottom_75 columns_padding_25 columns_margin_bottom_30">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 class="section_header">Publicate ahora ya</h2>
                    <p class="small-text highlight lusitana">Sin espereras</p>
                </div>
            </div>
            <div class="row">
                <div class="contact-form col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6 text-center">
                    <div class="form-group row alert alert-danger" role="alert" v-show="errors.all().length > 0">
                        <ul><li class="text-left"  v-for="error in errors.all()" v-bind:key="error">{{ error }}</li></ul>
                    </div>

                    <form class="row columns_padding_10 columns_margin_bottom_10">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="usuario">Usuario <span class="required">*</span></label>
                                <input type="text" aria-required="true" size="30" v-model="usuario" class="form-control text-center with_icon" placeholder="Usuario" v-validate.continues="'required'" name="usuario" data-vv-scope="registro_usuario">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contraseña">Contraseña <span class="required">*</span></label>
                                <input type="password" aria-required="true" size="30" v-model="clave" class="form-control text-center with_icon" placeholder="Contraseña" v-validate.continues="'required'" name="contraseña" data-vv-scope="registro_usuario">
                                <i class="fa fa-key" aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <select v-model="sexo" class="form-control text-center" v-validate.continues="'required|included:1,2'" data-vv-as="sexo" data-vv-scope="registro_usuario">
                                    <option value="0">Selecciona una opción</option>
                                    <option value="1">Mujer</option>
                                    <option value="2">Hombre</option>
                                </select>
                            </div>
                        </div>
 
                        <div class="col-sm-12 text-center">

                            <div class="contact-form-submit topmargin_20">
                                <button type="button" id="contact_form_submit" name="contact_submit" @click="registro()" class="theme_button color2">Registrarme</button>
                                <button type="reset" id="contact_form_reset" name="contact_reset" @click="limpiarDatos()" class="theme_button inverse">Limpiar</button>
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
        data() {
            return {
                usuario: '',
                clave: '',
                sexo: 0
            }
        },    
        methods:{
            limpiarDatos(){
                //this.$validator.reset();
                this.usuario = '';
                this.clave = '';
                this.sexo = 0;
            },
            registro(){
                this.$validator.validateAll('registro_usuario').then(valido => {
                    if (valido) {
                        let me = this;
                        me.errors.clear();
                        axios.post('/register',{
                            'usuario': me.usuario,
                            'clave': me.clave,
                            'sexo': me.sexo,
                            'tipo_usuario': 2
                        }).then(function (response) {
                            window.location.href = "/home";
                        }).catch(function (error) {
                            console.log(error);
                            if (error.response.status === 422){
                                me.errors.add({
                                    field: 'registro',
                                    msg: 'El usuario ya esta en uso, intenta con otro por favor.'
                                })
                            } else {
                                console.error(error);
                            }                      
                        });
                    }
                })
            },
        }
    }
</script>
