/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.swal = require('sweetalert2');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import VeeValidate, { Validator } from 'vee-validate';
import es from 'vee-validate/dist/locale/es';
import BootstrapVue from 'bootstrap-vue';
import PictureInput from 'vue-picture-input';
import VueLazyload from 'vue-lazyload';
import { VueStars } from "vue-stars";

Vue.component("vue-stars", VueStars);

Vue.use(VueLazyload, {
    preLoad: 1.3,
    attempt: 1,
    listenEvents: [ 'scroll' ]
});

Vue.use(VeeValidate, { classes: true, fieldsBagName: 'veeFields' });
Validator.localize("es", es);

Vue.use(BootstrapVue);
Vue.component('picture-input', PictureInput);

const vertical = {
    getMessage(data) {
        return (data && data.message) || "La imagen debe contener un tamaño vertical y no horizontal y el ancho de la imagen es de mínimo 500px";
    },
    validate(files) {
        const validateImage = (file) => {
            const URL = window.URL || window.webkitURL;
                return new Promise(resolve => {
                    const image = new Image();
                    image.onerror = () => resolve({ valid: false });
                    image.onload = () => resolve({
                        valid: image.width < image.height && image.width > 499
                });
        
                image.src = URL.createObjectURL(file);
            });
        };
      const list = [];
      for (let i = 0; i < files.length; i++) {
        // if file is not an image, reject.
        if (! /\.(jpg|svg|jpeg|png|bmp|gif)$/i.test(files[i].name)) {
          return false;
        }
        list.push(files[i]);
      }
      return Promise.all(list.map(file => validateImage(file)));
    }
};



Vue.component('login', require('./components/Login.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('perfil-usuario', require('./components/Perfil-usuario.vue').default);
Vue.component('video-estado', require('./components/VideoEstado.vue').default);
Vue.component('estados-usuario', require('./components/Estados.vue').default);
Vue.component('avisos-usuario', require('./components/Avisos.vue').default);
Vue.component('videos-usuario', require('./components/Videos.vue').default);
Vue.component('registro-usuario', require('./components/RegistroUsuario.vue').default);
Vue.component('ciudades', require('./components/Ciudades.vue').default);
Vue.component('usuarios-vip', require('./components/ListarAgencia.vue').default);
Vue.component('usuarios-normal', require('./components/ListarNormal.vue').default);
Vue.component('usuarios-mejor-valorados', require('./components/ListarMejorValorados.vue').default);
Vue.component('usuarios-mejor-valorados-pag', require('./components/ListarMejorValoradosPag.vue').default);
Vue.component('usuarios-venta', require('./components/ListarVenta.vue').default);
Vue.component('usuarios-video', require('./components/ListarVideos.vue').default);
Vue.component('usuarios-video-estado', require('./components/ListarVideoEstados.vue').default);
Vue.component('registro-persona', require('./components/RegistroUsuarioPersona.vue').default);
Vue.component('avisos-usuario-inicio', require('./components/AvisosUsuario.vue').default);
Vue.component('publicaciones', require('./components/Publicaciones.vue').default);
Vue.component('publicaciones-pagina', require('./components/PublicacionesPagina.vue').default);
Vue.component('descanso-uno', require('./components/DescansoUno.vue').default);
Vue.component('descanso-dos', require('./components/DescansoDos.vue').default);
Vue.component('seccion-nosotros', require('./components/Nosotros.vue').default);
Vue.component('calificacion-usuario', require('./components/CalificacionUsuario.vue').default);
Vue.component('calificacion-cliente', require('./components/CalificacionCliente.vue').default);
Vue.component('calificaciones', require('./components/Calificaciones.vue').default);
Vue.component('inicio', require('./components/Inicio.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        ciudad : 0
    },
    created() {
        this.$validator.extend('vertical', vertical);
    }
});
