<template>
  <v-app>
    <v-row>
      <v-col cols="12" sm="10" offset-sm="1">
        <v-container fluid>
          <v-row>
            <v-col
              v-for="interior in interiors"
              v-bind:key="interior.id"
              class="d-flex child-flex"
              cols="12"
              sm="6"
              md="4"
            >
              <v-row>
                <v-col>
                  <v-card>
                    <v-img
                      :src="interior.image"
                      :aspect-ratio="4/3"
                      v-on:click="goDetail(interior.id)"
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
                          <v-list-item-title>{{ interior.user.name }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-list-item>
                        <FollowButton v-bind:user="interior.user" />
                        <v-list-item-content>
                          <v-list-item-title>フォロー</v-list-item-title>
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
import FollowButton from "../elements/FollowButton";
import moment from "moment";

export default {
  name: "FollowInteriors",
  components: { FollowButton },
  methods: {
    goDetail(interiorId) {
      location.href = `/detail/${interiorId}`;
    },
  },
  computed: {
    interiorId() {
      return this.interiors.id;
    },
    interiors() {
      return window.data.interiors.data;
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