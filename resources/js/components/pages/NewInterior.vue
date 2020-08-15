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
  mounted() {
    console.log("aaa");
    this.onSubmit("adgg");
  },
  methods: {
    onSubmit(data) {
      console.log(data.image);

      axios
        .post("/api/interiors", data)
        .then((response) => {
          location.href = "/";
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style>
</style>