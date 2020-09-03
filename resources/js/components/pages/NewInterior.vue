<template>
  <div id="new-page">
    <InteriorForm v-on:submit="onSubmit" v-bind:interior="interior" />
  </div>
</template>
<script>
import InteriorForm from "../elements/InteriorForm";
import { postInterior } from "../../lib/api-service";

export default {
  name: "NewInterior",
  components: { InteriorForm },
  data: function () {
    return {
      interior: {
        image: null,
        imageData: "",
        SelectCategory: null,
        SelectStyle: null,
        detail: "",
        description: "",
      },
    };
  },
  methods: {
    onSubmit(data) {
      axios
        .post("/api/interiors", data)
        .then((response) => {
          location.href = "/top";
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style>
</style>