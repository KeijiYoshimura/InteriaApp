<template>
  <div class="Interior">
    <Interior v-for="interior in interiors" v-bind:key="interior.id" v-bind:interior="interior" />
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
    }
  }
};
</script>
<style>
</style>