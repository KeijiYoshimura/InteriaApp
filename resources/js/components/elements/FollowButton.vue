<template>
  <div v-if="this.isLoggedIn">
    <v-list-item-icon @click="changeFollow(user.id)">
      <template v-if="this.isFollowed">
        <v-icon color="primary">mdi-check-circle</v-icon>
      </template>
      <template v-else>
        <v-icon>mdi-radiobox-blank</v-icon>
      </template>
    </v-list-item-icon>
  </div>
  <v-list-item-icon v-else>
    <v-icon>mdi-circle-off-outline</v-icon>
  </v-list-item-icon>
</template>
<script>
import { getAuthUser } from "../../lib/api-service";
export default {
  name: "FollowButton",
  props: {
    user: {},
  },
  data: function () {
    return {
      me: {},
      isLoggedIn: false,
      isFollowed: false,
      countResult: Number,
    };
  },
  created() {
    this.loadAuthUser();
  },
  methods: {
    async loadAuthUser() {
      try {
        this.me = await getAuthUser();
        this.checkUser(this.me.id);
      } catch (e) {
        this.me = [];
        console.log(e);
      }
    },
    checkUser(meId) {
      if (meId !== this.user.id) {
        this.isLoggedIn = !this.isLoggedIn;
      }
      this.checkFollowed(this.user.id);
    },
    checkFollowed(userId) {
      const url = "/users/" + userId + "/checkFollow";
      axios
        .get(url)
        .then((response) => {
          if (response.data > 0) {
            this.isFollowed = !this.isFollowed;
          }
        })
        .catch((err) => console.log(err));
    },
    getCount(userId) {
      const url = "/users/" + userId + "/counts";
      axios.get(url).then((response) => {
        this.countResult = response.data.count_followers;
        this.$emit("changeFollowers", this.countResult);
      });
    },
    changeFollow(userId) {
      if (this.isFollowed === true) {
        const url = "/users/" + userId + "/unfollow";
        axios
          .delete(url)
          .then((response) => {
            console.log("unfollowed");
            this.isFollowed = !this.isFollowed;
            this.getCount(userId);
          })
          .catch((err) => console.log(err));
      } else {
        const url = "/users/" + userId + "/follow";
        axios
          .post(url)
          .then((response) => {
            console.log("followed");
            this.isFollowed = !this.isFollowed;
            this.getCount(userId);
          })
          .catch((err) => console.log(err));
      }
    },
  },
};
</script>
<style>
</style>