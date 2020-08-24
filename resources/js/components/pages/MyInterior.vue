<template>
  <!-- <v-app> -->
  <!-- <v-row>
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
  </v-row>-->

  <v-row>
    <v-col cols="12" sm="10" offset-sm="1">
      <!-- <v-card> -->
      <v-container fluid>
        <v-row>
          <v-col
            v-for="interior in interiors"
            v-bind:key="interior.id"
            class="d-flex child-flex"
            cols="4"
          >
            <v-row>
              <v-col>
                <v-card>
                  <v-img :src="interior.image | replace('public','/storage')" :aspect-ratio="4/3" />
                  <v-responsive>
                    <v-list-item>
                      <v-list-item-icon>
                        <v-icon>mdi-clock</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{ interior.created_at | moment }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <!-- <v-list-item>
                      <v-list-item-icon>
                        <v-icon>mdi-account</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{ interior.user.name }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item> -->
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
                  <v-card-actions>
                    <v-btn color="green darken-2" text v-on:click="goDetail(interior.id)">
                      <v-icon dark right>mdi-arrow-right-circle</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="dark" text v-on:click="goEdit(interior.id)">
                      <v-icon dark right>mdi-grease-pencil</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="red" text v-on:click="deleteInterior(interior.id)">
                      <v-icon dark right>mdi-delete</v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>

              <!-- <v-col cols="12" sm="5" class="pr-0">
                <v-card>
                  <v-img :src="interior.image | replace('public','/storage')" :aspect-ratio="4/3" />
                </v-card>
              </v-col>
              <v-col cols="12" sm="7" class="pl-0">
                <v-card>
                  <v-card-title>Date</v-card-title>
                  <v-card-text>{{ interior.created_at | moment }}</v-card-text>
                  <v-card-title>Category</v-card-title>
                  <v-card-text>{{interior.tag}}</v-card-text>
                  <v-card-title>Description</v-card-title>
                  <v-card-text>{{interior.description}}</v-card-text>
                  <v-card-actions>
                    <v-btn color="green darken-2" text v-on:click="goDetail(interior.id)">
                      <v-icon large dark right>mdi-arrow-right-circle</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="dark" text v-on:click="goEdit(interior.id)">
                      <v-icon large dark right>mdi-grease-pencil</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="red" text v-on:click="deleteInterior(interior.id)">
                      <v-icon large dark right>mdi-delete</v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>-->
            </v-row>
          </v-col>
        </v-row>
      </v-container>
      <!-- </v-card> -->
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
                <v-card-text>{{interior.tag}}</v-card-text>
                <v-card-title>Description</v-card-title>
                <v-card-text>{{interior.description}}</v-card-text>
                <v-card-actions>
                  <v-btn color="primary" text v-on:click="goDetail(interior.id)">Detail</v-btn>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" text v-on:click="goEdit(interior.id)">Edit</v-btn>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" text v-on:click="deleteInterior(interior.id)">Delete</v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-col>
  </v-row>-->
  <!-- </v-app> -->
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