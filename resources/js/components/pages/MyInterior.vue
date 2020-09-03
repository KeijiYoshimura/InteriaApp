<template>
  <v-row>
    <v-col cols="12" sm="10" offset="1">
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
                        <h2>{{ me.name }}</h2>
                      </v-list-item-title>
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
                      <v-list-item-icon v-on:click="goEdit(interior.id)">
                        <v-icon color="purple">mdi-grease-pencil</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>編集</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-icon v-on:click="deleteInterior(interior.id)">
                        <v-icon color="red">mdi-delete</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>削除</v-list-item-title>
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
</template>
<script>
import moment from "moment";
import {
  getMyInteriors,
  getInteriors,
  deleteInterior,
  getAuthUser,
} from "../../lib/api-service";

export default {
  name: "MyInterior",
  components: { moment },
  data: function () {
    return {
      interiors: [],
      me: {},
      followingCount: 0,
      followersCount: 0,
      interiorsCount: 0,
    };
  },
  mounted() {
    this.loadMyInteriors();
    this.loadAuthUser();
  },
  methods: {
    async loadAuthUser() {
      try {
        this.me = await getAuthUser();
        this.getCount(this.me);
      } catch (e) {
        this.me = [];
        console.log(e);
      }
    },
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
    getCount(me) {
      console.log(me);
      const url = "/users/" + me.id + "/counts";
      axios.get(url).then((response) => {
        console.log("success1");
        this.followingCount = response.data.count_followings;
        this.followersCount = response.data.count_followers;
        this.interiorsCount = response.data.count_interiors;
        return response.data.count_followings;
      });
    },
    goDetail(interiorId) {
      location.href = `/detail/${interiorId}`;
    },
    goEdit(interiorId) {
      location.href = `/edit/${interiorId}`;
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