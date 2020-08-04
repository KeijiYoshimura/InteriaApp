<template>
  <div class="detail-page">
    <div class="interior-container">
      <div class="interior-image">
        <img :src="interior.image | replace('public','/storage')" />
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
    </div>
  </div>
</template>
<script>
import { getInterior } from "../../lib/api-service";
export default {
  name: "Detail",
  methods: {
    async loadInterior() {
      try {
        this.interior = await getInterior(this.interiorId);
      } catch (e) {
        this.interior = [];
        console.log(e);
      }
    },
  },
  computed: {
    interiorId() {
      return this.interior.id;
    },
    interior() {
      return window.data.interior;
    },
  },
  filters: {
    replace: function (str) {
      return str.replace("public", "/storage");
    },
  },
};
</script>
<style>
</style>