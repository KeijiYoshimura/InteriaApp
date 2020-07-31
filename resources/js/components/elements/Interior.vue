<template>
  <div class="interior-container">
    <div class="interior-image">
      <img :src="interior.image | replace('public','storage')" />
    </div>
    <div class="interior-category">
      <span>{{ interior.category }}</span>
    </div>
    <div class="interior-style">
      <span>{{ interior.style }}</span>
    </div>
    <div class="interior-detail">
      <span>{{ interior.detail }}</span>
    </div>
    <div class="interior-description">
      <pre>{{ interior.description }}</pre>
    </div>
    <div class="action">
      <button class="booklist-item-btn-edit" v-on:click="$emit('edit', interior)"></button>
    </div>
  </div>
</template>
<script>
export default {
  name: "Interior",
  props: {
    interior: Object,
  },
  filters: {
    replace: function (str) {
      return str.replace("public", "storage");
    },
  },
};
</script>
<style scoped>
.interior-container {
  padding: 0.5em 1em;
  border: groove 5px #000000;
  margin: 2em auto;
  width: 70%;
}
</style>