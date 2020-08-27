<template>
  <v-list-item-icon @click="changeFollow(user.id)">
    <template v-if="this.isLoggedIn">
      <template v-if="this.isFollowed">
        <v-icon color="primary">mdi-check-circle</v-icon>
        <!-- <v-btn class="ma-2" color="primary" dark>
          <v-icon dark right>mdi-checkbox-blank-circle</v-icon>
        </v-btn> -->
      </template>
      <template v-else>
        <v-icon>mdi-radiobox-blank</v-icon>
        <!-- <v-btn class="ma-2" color="danger" dark>
          UNFOLLOW
          <v-icon dark right>mdi-checkbox-marked-circle</v-icon>
        </v-btn> -->
      </template>
    </template>
    <template v-else></template>
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
    };
  },
  created() {
    //console.log(this.user);
    this.loadAuthUser();
  },
  methods: {
    async loadAuthUser() {
      try {
        this.me = await getAuthUser();
        //console.log("1です");
        this.checkUser(this.me.id);
      } catch (e) {
        this.me = [];
        console.log(e);
      }
    },
    checkUser(meId) {
      //console.log(this.me);
      //console.log(this.user);
      //console.log(this.isLoggedIn);
      //console.log("2です");
      //console.log(meId);
      //console.log(meId !== this.user.id);
      if (meId !== this.user.id) {
        this.isLoggedIn = !this.isLoggedIn;
      }
      //console.log(this.isLoggedIn);
      this.checkFollowed(this.user.id);
      //return meId !== this.user.id;
    },
    checkFollowed(userId) {
      //console.log("3です");
      const url = "/users/" + userId + "/check";
      axios
        .get(url)
        .then((response) => {
          // console.log(response.data > 0);
          // return response.data > 0;

          if (response.data > 0) {
            this.isFollowed = !this.isFollowed;
          }

          //console.log(this.isFollowed);

          //this.isFollowed = !this.isFollowed;
        })
        .catch((err) => console.log(err));
    },
    changeFollow(userId) {
      console.log("4");
      if (this.isFollowed === true) {
        const url = "/users/" + userId + "/unfollow";
        axios
          .delete(url)
          .then((response) => {
            //if(response.data !== null)
            //console.log("unfollowed");
            this.isFollowed = !this.isFollowed;
          })
          .catch((err) => console.log(err));
      } else {
        const url = "/users/" + userId + "/follow";
        axios
          .post(url)
          .then((response) => {
            //if(response.data !== null){}
            //console.log("followed");
            this.isFollowed = !this.isFollowed;
          })
          .catch((err) => console.log(err));
      }
    },
  },
  computed: {
    //   checkUser(meId) {
    //   console.log(this.me);
    //   //console.log(this.user);
    //   console.log("2です");
    //   console.log(meId);
    //   //console.log(meId !== this.user.id);
    //   //return meId !== this.user.id;
    // },
  },
};
</script>
<style>
</style>