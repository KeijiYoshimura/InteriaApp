<template>
  <div class="my-interior-page">
    <Interior v-for="interior in interiors" v-bind:key="interior.id" v-bind:interior="interior" v-on:detail="goDetail" />
  </div>
</template>
<script>
import Interior from "../elements/Interior";
import { getMyInteriors } from "../../lib/api-service";

export default {
  name: "MyInterior",
  components: { Interior },
  data: function() {
    return {
      interiors: []
    };
  },
  mounted() {
    this.loadMyInteriors();
  },
  methods: {
    async loadMyInteriors() {
      try {
        this.interiors = await getMyInteriors();
      } catch (e) {
        this.interiors = [];
        console.log(e);
      }
    },
    goDetail(interior) {
      location.href = `/detail/${interior.id}`;
    },
  }
};
</script>
<style>
</style>