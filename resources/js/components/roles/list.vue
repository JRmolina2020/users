<template>
  <div>
    <div v-if="!status">
      <Loader></Loader>
    </div>
    <div v-else>
      <div class="input-group input-group-sm hidden-xs pull-right" style="width: 150px;">
        <Search-Item titleinput="Buscar Roles"></Search-Item>
      </div>
      <div class="table-responsive">
        <v-table
          :data="roles"
          :currentPage.sync="currentPage"
          :filters="filters"
          :pageSize="10"
          @totalPagesChanged="totalPages = $event"
          class="table table-condensed table-striped"
        >
          <thead slot="head">
            <tr>
              <th>Nombre</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody slot="body" slot-scope="{ displayData }">
            <tr v-for="(row, index) in displayData" :key="index">
              <td>{{ row.name }}</td>
              <td>
                <button
                  type="button"
                  @click="$emit('show', row)"
                  class="btn bg-warning btn-flat btn-sm"
                >
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </v-table>
      </div>
      <div class="box-footer clearfix">
        <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" />
      </div>
    </div>
  </div>
</template>
<script>
import SearchItem from "../utilities/search";
import Loader from "../utilities/loader";
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  components: {
    SearchItem,
    Loader
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 0
    };
  },
  computed: {
    ...mapState(["filters", "roles", "status", "urlroles"])
  },
  created() {
    this.getlist();
  },
  methods: {
    getlist() {
      this.$store.dispatch("Roleactions");
    }
  }
};
</script>
