<template>
  <div>
    <button
      type="button"
      @click="$emit('clear')"
      class="btn btn-primary btn-flat"
      data-toggle="modal"
      data-target="#model"
    >
      <slot name="titlebutton"></slot>
    </button>
    <div class="modal fade" id="model">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <p class="modal-title">
              <slot name="title"></slot>
            </p>
          </div>
          <div class="modal-body">
            <slot name="body"></slot>
          </div>
          <slot name="buttonsmodal"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "modalresource"
};
</script>
