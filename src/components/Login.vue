<template>
  <div class="vue-template">
    <form>
      <h3>Login</h3>
        <p>Test Credentials: <br>Usuario: admin <br>Pass: admin123 </p>
      <div class="form-group">
        <label>Usuario</label>
        <input
          type="text"
          class="form-control form-control-lg"
          v-model="username"
        />
      </div>

      <div class="form-group">
        <label>Contraseña</label>
        <input
          type="password"
          class="form-control form-control-lg"
          v-model="password"
        />
      </div>

      <button
        @click="login()"
        type="submit"
        class="btn btn-dark btn-lg btn-block"
      >
        <router-link to="/dashboard"> Ingresar </router-link>
      </button>

      <p class="forgot-password text-right mt-2 mb-4">
        <router-link to="/forgot-password"
          >¿Olvid&oacute; su contraseña?</router-link
        >
      </p>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: "",
      password: "",
    };
  },
  beforeRouteLeave(to, from, next) {
    next();
  },
  methods: {
    login: function () {
        if (this.username && this.password) {
          if (this.username=="admin"&&this.password=="admin123") {
                alert("Credenciales correctas");
              } else {
                alert("Credenciales incorrectas");
              }
        } else {
          alert("Please enter username & password");
        }
    },
  },
};
</script>