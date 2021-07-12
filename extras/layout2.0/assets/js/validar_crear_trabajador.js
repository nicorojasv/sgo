const app = new Vue({
  el: '#app',
  data: {
    errors: [],
    nombres: null,
    rut: null,
    fecha_nacimiento: null,
    paterno: null,
    materno: null,
    direccion: null,
    email: null,
    movie: null
  },
  methods:{
    checkForm: function (e) {
      if (this.nombres && this.rut && this.fecha_nacimiento && this.paterno && this.materno && this.direccion && this.email) {
        return true;
      }
      this.errors = [];

      if (!this.nombres) {
        this.errors.push('El nombre es obligatorio.');
      }

      if (!this.rut) {
        this.errors.push('El rut es obligatorio.');
      }

      if (!this.fecha_nacimiento) {
        this.errors.push('La fecha de nacimiento es obligatoria.');
      }
      if (!this.paterno) {
        this.errors.push('Apellido paterno obligatorio.');
      }
      if (!this.materno) {
        this.errors.push('Apellido materno obligatorio.');
      }
      if (!this.direccion) {
        this.errors.push('La fecha de nacimiento es obligatoria.');
      }
      if (!this.email) {
        this.errors.push('Email es obligatorio.');
      }
      errores='';
      for (var i = 0; i < this.errors.length; i++) {
       // console.log(this.errors[i])
        errores += '<ul><li>'+this.errors[i]+'</li></ul>'
      }
      if (errores!= '') {

        toastr.options = {
          "preventDuplicates": true,
          "preventOpenDuplicates": true
          };
         toastr.error(errores,'Errores',{timeOut: 5000,preventDuplicates:true,preventOpenDuplicates:true});
      }


      e.preventDefault();
    }
  }
})