<template>
  <h1>aaaa</h1>
  <!-- <div class="detail-page">
      <h1>aaa</h1>
    <div class="interior-container">
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
  </div>-->
</template>
<script>
// import Interior from "../elements/Interior";

export default {
  name: "Detail",
  components: { Interior },
  data: function () {
    return {};
  },
  mounted: function () {
    this.loadInterior();
  },
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
};
</script>
<style>
</style>