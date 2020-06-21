<template>
  <div>
    <Modal-Resource v-on:clear="clear" title="Registro de usuarios">
      <section v-if="!form.id" slot="title">Registro de usuarios</section>
      <section v-else slot="title">Editar usuarios</section>
      <section slot="closebtn">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </section>
      <section slot="titlebutton">Registrar usuarios</section>
      <section slot="body">
        <form
          method="POST"
          @submit.prevent="add(form.id)"
          autocomplete="off"
          enctype="multipart/form-data"
        >
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for>Nombre</label>
                <input
                  type="text"
                  v-validate="'required|max:30|min:3'"
                  class="form-control"
                  :class="{
                                'is-invalid': submitted && errors.has('nombre')
                            }"
                  placeholder="Nombre"
                  v-model="form.name"
                  name="nombre"
                />
                <div
                  v-if="submitted && errors.has('nombre')"
                  class="invalid-feedback"
                >{{ errors.first("nombre") }}</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for>Apellido</label>
                <input
                  type="text"
                  v-validate="'required|max:30|min:3'"
                  class="form-control"
                  :class="{
                                'is-invalid':
                                    submitted && errors.has('apellido')
                            }"
                  placeholder="Apellido"
                  v-model="form.surname"
                  name="apellido"
                />
                <div
                  v-if="submitted && errors.has('apellido')"
                  class="invalid-feedback"
                >{{ errors.first("apellido") }}</div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for>Email</label>
                <input
                  type="email"
                  v-validate="'required|max:30|min:3'"
                  class="form-control"
                  :class="{
                                'is-invalid': submitted && errors.has('email')
                            }"
                  placeholder="Email"
                  v-model="form.email"
                  name="email"
                />
                <div
                  v-if="submitted && errors.has('email')"
                  class="invalid-feedback"
                >{{ errors.first("email") }}</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div>
                <div class="form-group">
                  <label>Rol</label>
                  <select
                    v-model="form.rol"
                    v-validate="'required'"
                    class="form-control"
                    name="rol"
                    :class="{
                                'is-invalid': submitted && errors.has('rol')
                            }"
                  >
                    <option
                      v-for="(item, index) in roles"
                      :value="item.id"
                      :key="index"
                    >{{item.name}}</option>
                  </select>
                  <div
                    v-if="submitted && errors.has('rol')"
                    class="invalid-feedback"
                  >{{ errors.first("rol") }}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="row" v-if="!form.id">
            <div class="col-lg-6">
              <div class="form-group">
                <label for>Password</label>
                <input
                  type="password"
                  v-validate="'required|max:30|min:3'"
                  class="form-control"
                  :class="{
                                'is-invalid':
                                    submitted && errors.has('password')
                            }"
                  placeholder="password"
                  v-model="form.password"
                  name="password"
                />
                <div
                  v-if="submitted && errors.has('password')"
                  class="invalid-feedback"
                >{{ errors.first("password") }}</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>Perfil</label>
                <input
                  name="imagen"
                  id="imagen"
                  v-validate="'ext:jpeg,jpg,png,PNG,JPG|required'"
                  @change="getImage"
                  accept="image/*"
                  class="form-control"
                  type="file"
                  :class="{
                                'is-invalid': submitted && errors.has('imagen')
                            }"
                />
                <small class="form-text text-muted">Imagen del usuario</small>
                <div
                  v-if="submitted && errors.has('imagen')"
                  class="invalid-feedback"
                >{{ errors.first("imagen") }}</div>
              </div>
            </div>
          </div>
          <div velse></div>

          <button
            :hidden="errors.any()"
            type="submit"
            v-bind:class="{
                            'btn btn-primary btn flat': !this.form.id,
                            'btn btn-danger btn flat': this.form.id
                        }"
          >
            <i
              v-bind:class="{
                                'fa fa-floppy-o': !this.form.id,
                                'fa fa-pencil': this.form.id
                            }"
              aria-hidden="true"
            ></i>
          </button>
        </form>
      </section>
    </Modal-Resource>
  </div>
</template>
<script>
import ModalResource from "../utilities/modal.vue";
import Multiselect from "vue-multiselect";
import { mapState } from "vuex";
export default {
  $_veeValidate: {
    validator: "new"
  },
  name: "add",
  components: {
    ModalResource,
    Multiselect
  },
  data() {
    return {
      submitted: true,
      form: {
        id: null,
        name: "",
        surname: "",
        email: "",
        password: "",
        image: null,
        rol: []
      }
    };
  },

  computed: {
    ...mapState(["urlusers", "roles"])
  },
  created() {
    this.getlist();
  },

  methods: {
    getlist() {
      this.$store.dispatch("Roleactions");
    },

    add(id) {
      this.$validator.validate().then(valid => {
        if (valid) {
          if (id) {
            let url = `${this.urlusers}${id}`;
            axios
              .put(url, this.form)
              .then(response => {
                this.$store.dispatch("Useractions");
                Swal.fire({
                  position: "center",
                  icon: "success",
                  title: `${response.data.message}`,
                  showConfirmButton: false,
                  timer: 1500
                });
                $("#model").modal("hide");
                this.$store.dispatch("Useractions");
                this.clear();
              })
              .catch(error => {
                console.log(error.response);
              });
          } else {
            var data = new FormData();
            data.append("name", this.form.name);
            data.append("surname", this.form.surname);
            data.append("email", this.form.email);
            data.append("password", this.form.password);
            data.append("rol", this.form.rol);
            data.append("image", this.form.image);
            axios
              .post(this.urlusers, data)
              .then(response => {
                Swal.fire({
                  position: "center",
                  icon: "success",
                  title: `${response.data.message}`,
                  showConfirmButton: false,
                  timer: 1500
                });
                $("#model").modal("hide");
                this.$store.dispatch("Useractions");
                this.clear();
              })
              .catch(error => {
                console.log(error.response);
              });
          }
        }
      });
    },

    show(row) {
      this.form.id = row.id;
      this.form.name = row.name;
      this.form.surname = row.surname;
      this.form.email = row.email;
      this.form.rol = row.roles[0].id;
      $("#model").modal("show");
    },
    clear() {
      this.form.id = null;
      this.form.name = null;
      this.form.surname = null;
      this.form.email = null;
      this.form.password = null;
      this.form.rol = null;
      this.$validator.reset();
    },

    getImage(event) {
      this.form.image = event.target.files[0];
    }
  }
};
</script>
