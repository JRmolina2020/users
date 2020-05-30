<template>
  <div>
    <Add ref="form_user"></Add>
    <br />
    <List-User v-on:show="show"></List-User>
  </div>
</template>
<script>
import ListUser from "./list";
import Add from "./add";
export default {
  name: "users",
  components: {
    ListUser,
    Add
  },
  methods: {
    show(row) {
      this.$refs.form_user.show(row);
    }
  }
};
</script>