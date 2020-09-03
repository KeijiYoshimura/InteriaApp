<template>
  <v-app>
    <v-row>
      <v-col cols="10" offset-sm="1">
        <v-container fluid>
          <v-row>
            <v-col cols="10" offset="1">
              <v-row align-content="center">
                <v-col>
                  <v-card-actions>
                    <v-list-item class="pl-11">
                      <v-list-item-icon class="mr-2">
                        <v-icon large>mdi-account</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content class="pb-1">
                        <v-list-item-title>
                          <h2>{{ user.name }}</h2>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <FollowButton v-bind:user="user" v-on:changeFollowers="changeCount" />
                      <v-list-item-content>
                        <v-list-item-title>フォロー</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-icon class="pl-1">
                        <h2>{{this.followingCount}}</h2>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>フォロー中</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-icon class="pl-1">
                        <h2>{{this.followersCount}}</h2>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>フォロワー</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-icon class="pl-1">
                        <h2>{{this.interiorsCount}}</h2>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>投稿数</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-col>
            <v-col
              v-for="interior in user.interiors"
              v-bind:key="interior.id"
              class="d-flex child-flex"
              cols="12"
              sm="6"
              md="4"
            >
              <v-row>
                <v-col>
                  <v-card @click="goDetail(interior.id)">
                    <v-img
                      :src="interior.image"
                      :aspect-ratio="4/3"
                    />
                    <v-responsive>
                      <v-list-item>
                        <v-list-item-icon>
                          <v-icon>mdi-clock</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>{{ interior.created_at | moment }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>

                      <v-list-item>
                        <v-list-item-icon>
                          <v-icon>mdi-message</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>{{interior.description}}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-responsive>
                  </v-card>
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
import { getEachInteriors } from "../../lib/api-service";
import FollowButton from "../elements/FollowButton";
import moment from "moment";

export default {
  name: "User",
  components: { FollowButton },
  data: function () {
    return {
      interiors: [],
      followingCount: 0,
      followersCount: 0,
      interiorsCount: 0,
    };
  },
  mounted() {
    this.getCount(this.user);
  },
  methods: {
    async loadEachInteriors(userId) {
      try {
        this.interiors = await getEachInteriors(user.Id);
      } catch (e) {
        this.interiors = [];
        console.log(e);
      }
    },
    getCount(user) {
      const url = "/users/" + user.id + "/counts";
      axios.get(url).then((response) => {
        this.followingCount = response.data.count_followings;
        this.followersCount = response.data.count_followers;
        this.interiorsCount = response.data.count_interiors;
        return response.data.count_followings;
      });
    },
    changeCount(changeFollowers) {
      this.followersCount = changeFollowers;
    },
    goDetail(interiorId) {
      location.href = `/detail/${interiorId}`;
    },
  },
  computed: {
    userId() {
      return this.user.id;
    },
    user() {
      return window.data.user;
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