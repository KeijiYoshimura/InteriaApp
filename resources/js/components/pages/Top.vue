<template>
  <div class="top-page">
    <Interior v-for="interior in interiors" v-bind:key="interior.id" v-bind:interior="interior" v-on:detail="goDetail" v-on:edit="goEdit" />
  </div>
</template>
<script>
import Interior from "../elements/Interior";
import { getInteriors } from "../../lib/api-service";

export default {
  name: "Top",
  components: { Interior },
  data: function() {
    return {
      interiors: []
    };
  },
  mounted() {
    this.loadInteriors();
  },
  methods: {
    async loadInteriors() {
      try {
        this.interiors = await getInteriors();
      } catch (e) {
        this.interiors = [];
        console.log(e);
      }
    },
    goDetail(interior) {
      location.href = `/detail/${interior.id}`;
    },
    goEdit(interior) {
      location.href = `/edit/${interior.id}`;
    },
  }
};
</script>
<style>
</style>