<template>
  <div id="follow_button" @click="isFollow(user.id)">
    <p v-if="boolean">
      <v-iccon>mdi-check-circle</v-iccon>
    </p>
    <p v-else>
      <v-iccon>mdi-radiobox-blank</v-iccon>
    </p>
  </div>
</template>
<script>
export default {
  name: "FollowButton",
  props: {
    user: {},
  },
  data: function () {
    return {
      boolean: false,
      userFollow: [],
    };
  },
  mounted() {
    this.getBoolean();
  },
  methods: {
    async getBoolean() {
      try {
        this.boolean = await isExist();
      } catch (e) {
        this.boolean = false;
        console.log(e);
      }
    },
    isFollow(userId) {
      const url = "/users/" + userId + "/follow";
      axios
        .post()
        .then((response) => {
          //location.href = "/";
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style>
</style>