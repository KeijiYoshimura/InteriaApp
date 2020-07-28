<template>
  <div id="page-new">
    <InteriorForm v-on:submit="onSubmit" />
  </div>
</template>
<script>
import InteriorForm from "../elements/InteriorForm";
import { postInterior } from "../../lib/api-service";

export default {
  name: "NewInterior",
  components: { InteriorForm },
  // data: function() {
  //   return {
  //     interiors: []
  //   };
  // },
  methods: {
    onSubmit(interior) {
      postInterior(interior)
        .then(() => {
          location.href = "/";
        })
        .catch(err => console.log(err));
    }
  }
};
</script>
<style>
</style>