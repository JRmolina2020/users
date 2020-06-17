<template>
  <div class="container">
    <div class="login-box">
      <div class="login-logo">
        <b>DELTA</b>
        LTE
      </div>

      <div class="login-box-body">
        <p class="login-box-msg">Inicio de sección</p>
        <form method="POST" @submit.prevent="login" autocomplete="off">
          <div class="box-body">
            <div class="form-group">
              <label for>Email</label>
              <input
                type="email"
                v-validate="'required|max:40|min:4'"
                class="form-control input-sm"
                :class="{
                                    'is-invalid':
                                        submitted && errors.has('email')
                                }"
                placeholder="Email"
                v-model="form.email"
                onfocus
                name="email"
              />
              <div
                v-if="submitted && errors.has('email')"
                class="invalid-feedback"
              >{{ errors.first("email") }}</div>
            </div>
            <div class="form-group">
              <label for>Contraseña</label>
              <input
                type="password"
                v-validate="'required|max:15|min:4'"
                class="form-control input-sm"
                :class="{
                                    'is-invalid':
                                        submitted && errors.has('password')
                                }"
                placeholder="Password"
                v-model="form.password"
                onfocus
                name="password"
              />
              <div
                v-if="submitted && errors.has('password')"
                class="invalid-feedback"
              >{{ errors.first("password") }}</div>
            </div>
            <button
              v-if="!status"
              :disabled="errors.any()"
              type="submit"
              class="btn bg-purple btn-flat"
            >Ingresar</button>
          </div>
        </form>
      </div>
      <div class="callout callout-info">
        <h5>DELTA LTD</h5>
        <p>Gestión de Inventario y Facturación.</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  $_veeValidate: {
    validator: "new"
  },

  name: "login",
  data() {
    return {
      url: "login",
      submitted: true,
      status: false,
      form: {
        email: null,
        password: null
      }
    };
  },
  methods: {
    login() {
      this.$validator.validate().then(valid => {
        if (valid) {
          axios
            .post(this.url, {
              email: this.form.email,
              password: this.form.password
            })
            .then(response => {
              window.location.replace("/usuarios");
              this.status = true;
            })
            .catch(error => {
              this.form.password = null;
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Verifique las credenciales de ingreso"
              });
            });
        }
      });
    }
  }
};
</script>
