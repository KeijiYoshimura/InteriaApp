<template>
  <v-app>
    <v-row>
      <v-col cols="12" sm="10" offset-sm="1">
        <v-container fluid>
          <v-row>
            <v-col v-for="user in users" v-bind:key="user.id" class="d-flex child-flex" cols="4">
              <v-card flat tile class="d-flex">
                <v-card-text>{{user.name}}</v-card-text>
                <v-card-actions>
                  <v-btn color="green darken-2" text v-on:click="goDetail(user.id)">
                    <v-icon large dark right>mdi-arrow-right-circle</v-icon>
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
  </v-app>
  <!-- <h1>aaaa</h1> -->
</template>
<script>
import { getUsers } from "../../lib/api-service";

export default {
  name: "Users",
  components: {},
  data: function () {
    return {
      users: [],
    };
  },
  mounted() {
    this.loadUsers();
    console.log(this.users);
  },
  methods: {
    async loadUsers() {
      try {
        this.users = await getUsers();
      } catch (e) {
        this.users = [];
        console.log(e);
      }
    },
    goDetail(userId) {
      location.href = `/show/${userId}`;
    },
  },
};
</script>
<style>
</style>