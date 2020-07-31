<template>
  <!-- <h1>aaa</h1> -->
  <div class="edit-page">
    <InteriorForm v-on:submit="onSubmit" v-bind:interior="interior" />
  </div>
</template>
<script>
import InteriorForm from "../elements/InteriorForm";
import { updateInterior } from "../../lib/api-service";
//import { component } from "vue/types/umd";

export default {
  name: "EditInterior",
  components: { InteriorForm },
  methods: {
    onSubmit(interior) {
      updateInterior(this.interiorId, interior)
        .then(() => {
          location.href = "/";
        })
        .catch((err) => console.log(err));
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