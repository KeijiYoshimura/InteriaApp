<template>
  <div v-if="this.isLoggedIn">
    <v-list-item-icon @click="changeFavo(interior.id)">
      <template v-if="this.isFavorite">
        <v-icon color="red">mdi-heart</v-icon>
      </template>
      <template v-else>
        <v-icon>mdi-heart-outline</v-icon>
      </template>
    </v-list-item-icon>
  </div>
  <v-list-item-icon v-else>
    <v-icon>mdi-heart-off-outline</v-icon>
  </v-list-item-icon>
</template>
<script>
import { getAuthUser } from "../../lib/api-service";
export default {
  name: "FavoriteButton",
  props: {
    interior: {},
  },
  data: function () {
    return {
      me: {},
      isLoggedIn: false,
      isFavorite: false,
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
      if (meId !== this.interior.user.id) {
        this.isLoggedIn = !this.isLoggedIn;
      }
      this.checkFavo(this.interior.id);
    },
    checkFavo(interiorId) {
      const url = "/users/" + interiorId + "/checkFavo";
      axios
        .get(url)
        .then((response) => {
          if (response.data > 0) {
            this.isFavorite = !this.isFavorite;
          }
        })
        .catch((err) => console.log(err));
    },
    getCountFavo(interiorId) {
      const url = "/counts/" + interiorId;
      axios.get(url).then((response) => {
        this.countResult = response.data;
        this.$emit("changeFavorites", this.countResult);
      });
    },
    changeFavo(interiorId) {
      if (this.isFavorite === true) {
        const url = "/users/" + interiorId + "/unfavo";
        axios
          .delete(url)
          .then((response) => {
            this.isFavorite = !this.isFavorite;
            this.getCountFavo(interiorId);
          })
          .catch((err) => console.log(err));
      } else {
        console.log(interiorId);
        const url = "/users/" + interiorId + "/favo";
        axios
          .post(url)
          .then((response) => {
            this.isFavorite = !this.isFavorite;
            this.getCountFavo(interiorId);
          })
          .catch((err) => console.log(err));
      }
    },
  },
};
</script>
<style>
</style>