<template>
  <v-list-item-icon @click="changeWatch(message.id)">
    <template v-if="this.isWatch">
      <v-icon color="orange darken-2">mdi-eye-outline</v-icon>
    </template>
    <template v-else>
      <v-icon>mdi-eye-off-outline</v-icon>
    </template>
  </v-list-item-icon>
</template>
<script>
import { getAuthUser } from "../../lib/api-service";
export default {
  name: "WatchButton",
  props: {
    message: {},
  },
  data: function () {
    return {
      me: {},
      isWatch: false,
      countResult: Number,
    };
  },
  created() {
    this.checkWatch(this.message.id);
  },
  methods: {
    checkWatch(messageId) {
      const url = "/users/" + messageId + "/checkWatch";
      axios
        .get(url)
        .then((response) => {
          if (response.data > 0) {
            this.isWatch = !this.isWatch;
          }
        })
        .catch((err) => console.log(err));
    },
    changeWatch(messageId) {
      if (this.isWatch === true) {
        const url = "/users/" + messageId + "/unwatch";
        axios
          .delete(url)
          .then((response) => {
            this.isWatch = !this.isWatch;
            this.$emit("changeRead", this.message);
          })
          .catch((err) => console.log(err));
      } else {
        const url = "/users/" + messageId + "/watch";
        axios
          .post(url)
          .then((response) => {
            this.isWatch = !this.isWatch;
            this.$emit("changeRead", this.message);
          })
          .catch((err) => console.log(err));
      }
    },
  },
};
</script>
<style>
</style>