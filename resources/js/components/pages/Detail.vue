<template>
  <v-app>
    <v-content>
      <v-container>
        <v-row>
          <v-col cols="12" md="5" style="max-height: 600px">
            <v-card>
              <v-img :src="interior.image | replace('public','/storage')" :aspect-ratio="4/3" />
              <v-responsive>
                <v-card-title>Date</v-card-title>
                <v-card-text>{{ interior.created_at | moment }}</v-card-text>
                <v-card-title>Category</v-card-title>
                <v-card-text>{{interior.style + "/" + interior.category + "/" + interior.detail}}</v-card-text>
                <v-card-title>Description</v-card-title>
                <v-card-text>{{interior.id + "/" + interior.description}}</v-card-text>
              </v-responsive>
            </v-card>
          </v-col>
          <v-col cols="12" md="7" style="max-height: 600px">
            <Chat v-bind:interior="interior"/>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>
<script>
import { getInterior } from "../../lib/api-service";
import Chat from "../elements/Chat";
import moment from "moment";

export default {
  name: "Detail",
  components: { Chat },
  computed: {
    interiorId() {
      return this.interior.id;
    },
    interior() {
      return window.data.interior;
    },
  },
  methods: {
    async loadInterior() {
      try {
        this.interior = await getInterior(this.interiorId);
      } catch (e) {
        this.interior = [];
        console.log(e);
      }
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
};
</script>
<style>
</style>