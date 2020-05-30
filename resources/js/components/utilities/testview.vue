<template>
  <div>
    <button
      type="button"
      class="btn bg-default btn-flat btn-sm"
      data-toggle="modal"
      :data-target="'#model' + row.id"
    >
      <i class="fa fa-user-circle" aria-hidden="true"></i>
    </button>
    <div
      class="modal fade"
      :id="'model' + row.id"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            {{ row.email }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    row: {
      type: Object,
      required: true
    }
  }
};
</script>