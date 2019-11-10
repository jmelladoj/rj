<template>
    <li class="dropdown login-dropdown">
        <a class="topline-button" id="login" data-target="#" href="./" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
            <i class="fa fa-user"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="login">
            <form class="form">
                <div class="alert alert-danger" role="alert" v-show="errors.all().length > 0">
                    <ul>
                        <li v-for="error in errors.all()" v-bind:key="error">{{ error }}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label for="usuario" class="sr-only">Usuario</label>
                    <input type="text" name="usuario" class="form-control" v-model="usuario" placeholder="Ingresa tu usuario" v-validate.continues="'required'">
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Contraseña</label>
                    <input type="password" name="password" class="form-control" v-model="password" placeholder="Ingresa tu contraseña" v-validate.continues="'required'">
                </div>
                <button name="login" type="button" class="theme_button color1" @click="login" v-b-tooltip.hover title="Haz click en el boton para iniciar sesión">
                    Ingresar
                </button>
                <div class="checkbox-inline">
                    <input type="checkbox" name="remember" v-model="remember" value="1">
                    <label for="remember" class="bottommargin_0"> Recuérdame</label>
                </div>
            </form>
        </div>                                        
    </li>
</template>

<script>
    export default {
        data (){
            return {
                usuario: '',
                password : '',
                remember : 0,
            }
        },
        methods : {
            login(){              
                let me = this;

                this.$validator.validate().then(valido => {
                    if (valido) {
                        me.errors.clear();
                        axios.post('/login',{
                            'usuario': me.usuario,
                            'password': me.password,
                            'remember': me.remember
                        }).then(function (response) {
                            window.location.href = "/home";
                        }).catch(function (error) {
                            if (error.response.status === 422){
                                me.errors.add({
                                    field: 'login',
                                    msg: 'Las credenciales introducidas son incorrectas.'
                                })
                            } else {
                                console.error(error);
                            }                      
                        });
                    }
                })
            }
        }
    }
</script>

<style>
    .plomo {
        color: #a0a0a0;
    }

    .alert{
        padding: 10px;
    };
</style>