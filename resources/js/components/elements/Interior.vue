<template>
  <div class="interior-container" v-on:click="$emit('detail', interior)">
    <div class="interior-category">
      <span>{{ interior.category }}</span>
    </div>
    <div class="interior-style">
      <span>{{ interior.style }}</span>
    </div>
    <div class="interior-detail">
      <span>{{ interior.detail }}</span>
    </div>
  </div>
</template>
<script>
export default {
  name: "Interior",
  props: {
    interior: Object
  }
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