<template>
    <div>
        <div v-if="!status">
            <Loader></Loader>
        </div>
        <div v-else>
            <Search-Item titleinput="Buscar Usuarios"></Search-Item>
            <div class="table-responsive">
                <v-table
                    :data="users"
                    :currentPage.sync="currentPage"
                    :filters="filters"
                    :pageSize="100"
                    @totalPagesChanged="totalPages = $event"
                    class="table table-condensed table-striped"
                >
                    <thead slot="head">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Imagen</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Password</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody slot="body" slot-scope="{ displayData }">
                        <tr v-for="(row, index) in displayData" :key="index">
                            <td>{{ row.name }}</td>
                            <td>{{ row.surname }}</td>
                            <td v-if="row.image == 'null'">
                                <img
                                    class="img-fluid mx-auto d-block"
                                    src="https://cdn.icon-icons.com/icons2/1879/PNG/512/iconfinder-3-avatar-2754579_120516.png"
                                    height="40"
                                    width="40"
                                    alt="no existe"
                                />
                            </td>
                            <td v-else>
                                <img
                                    :src="`storage/${row.image}`"
                                    width="40"
                                    height="40"
                                    class="img-fluid mx-auto d-block"
                                />
                            </td>
                            <td>
                                <Test-View
                                    v-bind:row="row"
                                    title="email"
                                ></Test-View>
                            </td>
                            <td>
                                <button
                                    type="button"
                                    @click="thestatus(row)"
                                    v-bind:class="{
                                        'btn   btn-flat  btn-sm': true,
                                        ' btn-success': row.status,
                                        'btn-danger': row.status == 0
                                    }"
                                >
                                    <i
                                        :class="
                                            row.status
                                                ? 'fa fa-check-circle'
                                                : 'fa fa-power-off'
                                        "
                                        aria-hidden="true"
                                    ></i>
                                </button>
                            </td>
                            <td>
                                <Modal-Password v-bind:row="row">
                                </Modal-Password>
                            </td>
                            <td>
                                <button
                                    type="button"
                                    @click="$emit('show', row)"
                                    class="btn bg-warning btn-flat btn-sm"
                                >
                                    <i
                                        class="fa fa-pencil-square-o"
                                        aria-hidden="true"
                                    ></i>
                                </button>
                                <button
                                    type="button"
                                    @click="remove(row)"
                                    class="btn bg-maroon btn-flat btn-sm"
                                >
                                    <i
                                        class="fa fa-trash-o"
                                        aria-hidden="true"
                                    ></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </div>
            <div class="box-footer clearfix">
                <smart-pagination
                    :currentPage.sync="currentPage"
                    :totalPages="totalPages"
                />
            </div>
        </div>
    </div>
</template>
<script>
import SearchItem from "../utilities/search";
import TestView from "../utilities/testview";
import Loader from "../utilities/loader";
import ModalPassword from "./modalpassword";

import { mapState, mapMutations, mapActions } from "vuex";

export default {
    components: {
        SearchItem,
        TestView,
        Loader,
        ModalPassword
    },
    data() {
        return {
            url: "users/",
            rodo: "",
            currentPage: 1,
            totalPages: 0
        };
    },
    computed: {
        ...mapState(["filters", "users", "status"])
    },
    created() {
        this.getlist();
    },
    methods: {
        getlist() {
            this.$store.dispatch("Useractions");
        },

        async remove(row) {
            let url = this.url + row.id;
            let response = await axios.delete(url);
            try {
                this.getlist();
                Swal.fire({
                    title: `El usuario ${row.name} ${response.data.message}`,
                    icon: "success"
                });
            } catch (error) {
                console.log(error);
            }
        },
        async thestatus(row) {
            if (row.status == 1) {
                let url = this.url + "locked/" + row.id;
                let response = await axios.put(url);
                try {
                    Swal.fire({
                        title: `El usuario ${row.name} ${response.data.message}`,
                        icon: "success"
                    });
                } catch (error) {
                    console.log(error);
                }
            } else {
                let url = this.url + "available/" + row.id;
                let response = await axios.put(url);
                try {
                    Swal.fire({
                        title: `El usuario ${row.name} ${response.data.message}`,
                        icon: "success"
                    });
                } catch (error) {
                    console.log(error);
                }
            }
            this.getlist();
        }
    }
};
</script>
