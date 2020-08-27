<template>
  <v-app>
    <!-- <v-row>
      <v-col cols="12" sm="10" offset-sm="1">
        <v-container fluid>
          <v-row>
            <v-col>
              <v-card>
                <v-card-text>{{user.name}}</v-card-text>
              </v-card>
              <FollowButton v-bind:user="user" />
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>-->

    <!-- <FollowButton v-bind:user="user"/> -->

    <v-row>
      <v-col cols="12" sm="10" offset-sm="1">
        <v-container fluid>
          <v-row>
            <v-col
              v-for="interior in user.interiors"
              v-bind:key="interior.id"
              class="d-flex child-flex"
              cols="4"
            >
              <v-row>
                <v-col>
                  <v-card @click="goDetail(interior.id)">
                    <v-img
                      :src="interior.image | replace('public','/storage')"
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
                          <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>{{ user.name }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
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
import { getUser, getEachInteriors } from "../../lib/api-service";
import FollowButton from "../elements/FollowButton";
import moment from "moment";

export default {
  name: "User",
  components: { FollowButton },
  data: function () {
    return {
      interiors: [],
    };
  },
  mounted() {
    //console.log(window.data);
  },
  methods: {
    async loadEachInteriors(userId) {
      try {
        //console.log(userId);
        this.interiors = await getEachInteriors(user.Id);
      } catch (e) {
        this.interiors = [];
        console.log(e);
      }
    },
    goDetail(interiorId) {
      location.href = `/detail/${interiorId}`;
    },
  },
  filters: {
    replace: function (str) {
      return str.replace("public", "/storage");
    },
    moment: function (date) {
      return moment(date).format("YYYY/MM/DD HH:mm");
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
};
</script>
<style>
</style>