<template>
  <!-- <v-app>
    <div class="top-page">
      <Interior
        v-for="interior in interiors"
        v-bind:key="interior.id"
        v-bind:interior="interior"
        v-on:detail="goDetail"
        v-on:edit="goEdit"
      />
    </div>
  </v-app>-->
  <v-app>
    <!-- <v-row>
      <v-col cols="12" sm="10" offset-sm="1"> -->
        <v-card>
          <v-container fluid>
            <v-row>
              <v-col
                v-for="interior in interiors"
                v-bind:key="interior.id"
                class="d-flex child-flex"
                cols="4"
              >
                <v-card flat tile class="d-flex">
                  <v-img
                    :src="interior.image | replace('public','storage')"
                    aspect-ratio="1"
                    class="grey lighten-2"
                    v-on:click="goDetail(interior.id)"
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
      <!-- </v-col>
    </v-row> -->
  </v-app>
</template>
<script>
import Interior from "../elements/Interior";
import { getInteriors } from "../../lib/api-service";

export default {
  name: "Top",
  components: { Interior },
  data: function () {
    return {
      interiors: [],
    };
  },
  mounted() {
    this.loadInteriors();
  },
  methods: {
    async loadInteriors() {
      try {
        this.interiors = await getInteriors();
      } catch (e) {
        this.interiors = [];
        console.log(e);
      }
    },
    goDetail(interiorId) {
      location.href = `/detail/${interiorId}`;
    },
    goEdit(interior) {
      location.href = `/edit/${interior.id}`;
    },
  },
  filters: {
    replace: function (str) {
      return str.replace("public", "storage");
    },
  },
};
</script>
<style>
</style>