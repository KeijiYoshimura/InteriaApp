<template>
  <v-app>
    <v-row>
      <v-col cols="12" sm="10" offset-sm="1">
        <v-card>
          <v-container fluid>
            <v-row>
              <v-col
                v-for="interior in interiors"
                v-bind:key="interior.id"
                class="d-flex child-flex"
                cols="3"
              >
                <v-card flat tile class="d-flex">
                  <v-card-title>{{interior.id}}</v-card-title>
                  <v-img
                    :src="interior.image | replace('public','/storage')"
                    aspect-ratio="1"
                    class="grey lighten-2"
                    v-on:click="goEdit(interior.id)"
                  >
                    <template v-slot:aplaceholder>
                      <v-row class="fill-height ma-0" align="center" justify="center">
                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                      </v-row>
                    </template>
                  </v-img>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-card>
      </v-col>
    </v-row>

    <!-- <v-row>
      <v-col cols="12" sm="10" offset-sm="1">
        <v-card>
          <v-container fluid>
            <v-row>
              <v-col
                v-for="interior in interiors"
                v-bind:key="interior.id"
                class="d-flex child-flex"
                cols="6"
              >
                <v-card>
                  <v-img :src="interior.image | replace('public','/storage')" :aspect-ratio="4/3" />
                  <v-card-title>Date</v-card-title>
                  <v-card-text>{{ interior.created_at | moment }}</v-card-text>
                  <v-card-title>Category</v-card-title>
                  <v-card-text>{{interior.style + "/" + interior.category + "/" + interior.detail}}</v-card-text>
                  <v-card-title>Description</v-card-title>
                  <v-card-text>{{interior.description}}</v-card-text>
                  <v-card-actions>
                    <v-btn color="primary" text v-on:click="goDetail(interior.id)">Detail</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text v-on:click="goEdit(interior.id)">Edit</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text v-on:click="onDelete(interior)">Delete</v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-card>
      </v-col>
    </v-row>-->
  </v-app>
</template>
<script>
import Interior from "../elements/Interior";
import {
  getMyInteriors,
  getInteriors,
  deleteInterior,
} from "../../lib/api-service";

export default {
  name: "MyInterior",
  components: { Interior },
  data: function () {
    return {
      interiors: [],
    };
  },
  mounted() {
    this.loadMyInteriors();
  },
  methods: {
    async loadMyInteriors() {
      try {
        this.interiors = await getMyInteriors();
      } catch (e) {
        this.interiors = [];
        console.log(e);
      }
    },
    async deleteInterior(interiorId) {
      const idx = this.interiors.findIndex((i) => i.id === interiorId);
      if (idx < 0) {
        return;
      }
      try {
        await deleteInterior(interiorId);
        this.interior = this.interiors.splice(idx, 1);
      } catch (e) {
        console.log(e);
      }
    },
    goDetail(interiorId) {
      location.href = `/detail/${interiorId}`;
    },
    goEdit(interiorId) {
      location.href = `/edit/${interiorId}`;
    },
    onDelete(interiorId) {
      if (confirm(`本当に削除しますか？？`)) {
        this.deleteInterior(interiorId);
      }
    },
  },
  filters: {
    replace: function (str) {
      return str.replace("public", "/storage");
    },
  },
};
</script>
<style>
</style>