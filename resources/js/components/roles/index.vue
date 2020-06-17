<template>
  <div>
    <Add ref="form_role"></Add>
    <List-Role v-on:show="show"></List-Role>
  </div>
</template>
<script>
import ListRole from "./list";
import Add from "./add";
export default {
  name: "users",
  components: {
    ListRole,
    Add
  },
  methods: {
    show(row) {
      this.$refs.form_role.show(row);
    }
  }
};
</script>