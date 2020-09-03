<template>
  <v-app>
    <v-row>
      <v-col cols="12" sm="10" offset-sm="1">
        <v-container fluid>
          <v-row>
            <v-col cols="12" md="5">
              <v-row>
                <v-col>
                  <v-card>
                    <v-img
                      :src="interior.image | replace('public','/storage')"
                      :aspect-ratio="4/3"
                    />
                    <v-responsive>
                      <v-card-actions>
                        <v-list-item>
                          <v-list-item-icon>
                            <v-icon>mdi-clock</v-icon>
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>{{ interior.created_at | moment }}</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-card-actions>
                      <v-card-actions>
                        <v-list-item>
                          <v-list-item-icon>
                            <v-icon>mdi-account</v-icon>
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>{{ user.name }}</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-icon text v-on:click="goDetail(user.id)">
                            <v-icon color="green darken-2">mdi-arrow-right-circle</v-icon>
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>ユーザーページ</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-card-actions>
                      <v-card-actions>
                        <v-list-item>
                          <FollowButton v-bind:user="user" v-on:changeFollowers="changeCount" />
                          <v-list-item-title>{{this.followersCount}}フォロワー</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                          <FavoriteButton
                            v-bind:interior="interior"
                            v-on:changeFavorites="changeFavoritesCount"
                          />
                          <v-list-item-content>
                            <v-list-item-title>{{this.favoritesCount}}いいね！</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-card-actions>
                      <v-card-actions>
                        <v-list-item>
                          <v-list-item-icon>
                            <v-icon>mdi-message</v-icon>
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>
                              <pre>{{interior.description}}</pre>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-card-actions>
                    </v-responsive>
                  </v-card>
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12" md="7">
              <v-row>
                <v-col>
                  <Chat v-bind:interior="interior" v-on:delete="deleteMessage" />
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
  </v-app>
</template>
<script>
import Chat from "../elements/Chat";
import FollowButton from "../elements/FollowButton";
import FavoriteButton from "../elements/FavoriteButton";
import moment from "moment";

export default {
  name: "Detail",
  components: { Chat, FollowButton, FavoriteButton },
  data: function () {
    return {
      followersCount: 0,
      favoritesCount: 0,
    };
  },
  mounted() {
    this.getCount(this.user.id);
    this.getCountFavo(this.interiorId);
  },
  methods: {
    deleteMessage(messageId) {
      console.log(messageId);
      const idx = this.messages.findIndex((m) => m.id === messageId);
      const url = "/ajax/chat";
      const params = {
        id: messageId,
      };
      axios.delete(url, params).then((response) => {
        this.message = this.messages.splice(idx, 1);
        console.log(response);
      });
    },
    goDetail(userId) {
      location.href = `/show/${userId}`;
    },
    getCount(userId) {
      const url = "/users/" + userId + "/counts";
      axios.get(url).then((response) => {
        this.followersCount = response.data.count_followers;
      });
    },
    getCountFavo(interiorId) {
      const url = "/counts/" + interiorId;
      axios.get(url).then((response) => {
        this.favoritesCount = response.data;
      });
    },
    changeCount(changeFollowers) {
      console.log(this.followersCount);
      this.followersCount = changeFollowers;
      console.log(this.followersCount);
    },
    changeFavoritesCount(changeFavorites) {
      this.favoritesCount = changeFavorites;
    },
  },
  computed: {
    data() {
      return window.data;
    },
    interior() {
      return window.data.interior;
    },
    interiorId() {
      return this.interior.id;
    },
    user() {
      return window.data.interior.user;
    },
  },
  filters: {
    moment: function (date) {
      return moment(date).format("YYYY/MM/DD HH:mm");
    },
  },
};
</script>
<style>
</style>