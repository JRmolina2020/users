<template>
  <div>
    <Modal-Resource v-on:clear="clear" title="Registro de roles">
      <section v-if="!form.id" slot="title">Registro de roles</section>
      <section v-else slot="title">Editar rol</section>
      <section slot="closebtn">
        <button
          @click="clearrolesitem"
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </section>
      <section slot="titlebutton">Registrar rol</section>
      <section slot="body">
        <form method="POST" @submit.prevent="add(form.id)" autocomplete="off">
          <div class="form-group">
            <label for>Nombre</label>
            <input
              type="text"
              v-validate="'required|max:30|min:3'"
              class="form-control"
              :class="{
                                'is-invalid': submitted && errors.has('nombre')
                            }"
              placeholder="Nombre del rol a registrar"
              v-model="form.name"
              name="nombre"
            />
            <div
              v-if="submitted && errors.has('nombre')"
              class="invalid-feedback"
            >{{ errors.first("nombre") }}</div>
          </div>
          <div v-if="form.id" class="row">
            <div v-for="(item, index) in permissions" :key="index" class="form-group">
              <div class="col">
                <div class="has-error">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" v-model="form.permissions" :value="item.id" />
                      {{ item.name }}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
      rolesitem: [],
      form: {
        id: null,
        name: null,
        permissions: []
      }
    };
  },
  computed: {
    ...mapState(["permissions", "status", "urlroles"])
  },
  created() {
    this.getlist();
  },
  methods: {
    getlist() {
      this.$store.dispatch("Permissionsactions");
    },
    add(id) {
      this.$validator.validate().then(valid => {
        if (valid) {
          if (id) {
            let url = `${this.urlroles}${id}`;
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
                this.$store.dispatch("Roleactions");
                this.clear();
              })
              .catch(error => {
                console.log(error.response);
              });
          } else {
            axios
              .post(this.urlroles, this.form)
              .then(response => {
                Swal.fire({
                  position: "center",
                  icon: "success",
                  title: `${response.data.message}`,
                  showConfirmButton: false,
                  timer: 1500
                });
                $("#model").modal("hide");
                console.log(this.form);
                this.$store.dispatch("Roleactions");
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
      row.permissions.forEach(element => {
        this.rolesitem.push(element.id);
      });
      this.form.permissions = this.rolesitem;
      $("#model").modal("show");
    },

    clearrolesitem() {
      this.rolesitem = [];
      $("#model").modal("hide");
    },
    clear() {
      this.form.id = null;
      this.form.name = null;
      this.$validator.reset();
      this.rolesitem = [];
      this.form.permissions = [];
    }
  }
};
</script>
