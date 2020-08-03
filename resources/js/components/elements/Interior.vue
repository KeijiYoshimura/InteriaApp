<template>
  <v-app>
    <div class="interior-container">
      <div class="interior-image" v-on:click="$emit('detail', interior)">
        <v-img
          :src="interior.image | replace('public','storage')"
          aspect-ratio="1"
          height="250"
          width="250"
        />
      </div>
      <!-- <v-img
        :src="interior.image | replace('public','storage')"
        :lazy-src="`https://picsum.photos/10/6?image=${interior * 5 + 10}`"
        aspect-ratio="1"
        class="grey lighten-2"
      /> -->
        <!-- <template v-slot:placeholder>
          <v-row class="fill-height ma-0" align="center" justify="center">
            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
          </v-row>
        </template>
      </v-img> -->
      <!-- <div class="interior-category">
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
      </div> -->
    </div>
  </v-app>
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