<template>
  <div class="vue-template">
    <v-form @submit="guardar()">
      <h3>Ingreso de Datos</h3>

        <p v-if="errors.length">
    <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
    <ul>
      <li v-for="error in errors" :key="error">{{ error }}</li>
    </ul>
  </p>
      <div class="form-group">
        <label>Nombres</label>
        <input
          type="text"
          class="form-control form-control-lg"
          v-model="registro.nombres"
          required
        />
      </div>

      <div class="form-group">
        <label>Apellidos</label>
        <input
          type="text"
          class="form-control form-control-lg"
          v-model="registro.apellidos"
          required
        />
      </div>

      <div class="form-group">
        <label>Fecha de Nacimiento</label>
        <input
          type="date"
          class="form-control form-control-lg"
          v-model="registro.fechaNac"
          required
        />
      </div>

      <div class="form-group">
        <label>Direcci&oacute;n</label>
        <input
          type="text"
          class="form-control form-control-lg"
          v-model="registro.direccion"
          required
        />
      </div>

      <div class="form-group">
        <label>Email</label>
        <input
          type="email"
          class="form-control form-control-lg"
          v-model="registro.email"
          required
        />
      </div>
      <v-button
      @click="guardar()"
        type="submit"
        class="btn btn-dark btn-lg btn-block"
      >
        Guardar
      </v-button>

      <!-- <p class="forgot-password text-right">
                Already registered 
                <router-link :to="{name: 'login'}">sign in?</router-link>
            </p> -->
    </v-form>
  </div>
</template>

<script>
var url = "http://localhost/vueform/db/backend.php";
import axios from "axios";

export default {
  name: "Form",
  data() {
    return {
      registros: [],
      errors: [],
      registro: {
        nombres: null,
        apellidos: null,
        fechaNac: null,
        direccion: null,
        email: null,
      },
    };
  },
  methods: {
    guardar: function (e) {
      if (
        this.registro.nombres &&
        this.registro.apellidos &&
        this.registro.fechaNac &&
        this.registro.direccion &&
        this.registro.email
      ) {
        axios
          .post(url, {
            opcion: 2,
            nombres: this.registro.nombres,
            apellidos: this.registro.apellidos,
            fechaNac: this.registro.fechaNac,
            direccion: this.registro.direccion,
            email: this.registro.email,
          })
          .then(()=>{this.$swal("¡Registro Agregado!", "", "success");
        this.registro.nombres = "";
          this.registro.apellidos = "";
          this.registro.fechaNac = "";
          this.registro.direccion = "";
          this.registro.email = "";});
      }
      this.errors = [];

      if (!this.registro.nombres) {
        this.errors.push("El campo nombres es obligatorio.");
      }
      if (!this.registro.apellidos) {
        this.errors.push("El campo apellidos es obligatorio.");
      }
      if (!this.registro.fechaNac) {
        this.errors.push("La fecha de nacimiento es obligatoria.");
      }
      if (!this.registro.direccion) {
        this.errors.push("La dirección es obligatoria.");
      }
      if (!this.registro.email) {
        this.errors.push("El correo es obligatorio.");
      }

      e.preventDefault();
    },
  },
};
</script>