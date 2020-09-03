<template>
  <div class="edit-page">
    <InteriorForm v-on:submit="onSubmit" v-bind:interior="interior" />
  </div>
</template>
<script>
import InteriorForm from "../elements/InteriorForm";

export default {
  name: "EditInterior",
  components: { InteriorForm },
  methods: {
    onSubmit(data) {
      console.log(data.image);
      axios
        .post("/api/interiors/" + this.interiorId , data)
        .then((response) => {
          location.href = "/top";
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