<template>
  <div class="form-group">
    <input
      type="text"
      class="form-control input-sm"
      v-model="filters.data.value"
      :placeholder="titleinput"
    />
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState(["filters"])
  },
  props: {
    titleinput: String,
    required: true
  }
};
</script>
