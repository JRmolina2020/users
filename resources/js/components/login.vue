<template>
  <div class="container">
    <br />
    <br />
    <div class="col-md-6 principal">
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
        </div>

        <button :disabled="errors.any()" type="submit" class="btn bg-purple btn-flat">Ingresar</button>
      </form>
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
