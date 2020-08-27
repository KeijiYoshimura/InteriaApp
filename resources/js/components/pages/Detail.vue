<template>
  <v-container>
    <v-row>
      <v-col cols="12" lg="5">
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
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-account</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ interior.user.name }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <FollowButton v-bind:user="user" />
              <v-list-item-content>
                <v-list-item-title>フォロー</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-icon text v-on:click="goDetail(user.id)">
                <v-icon color="green darken-2">mdi-arrow-right-circle</v-icon>
               </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>詳細ページ</v-list-item-title>
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
      <v-col cols="12" lg="7">
        <Chat v-bind:interior="interior" v-on:delete="deleteMessage" />
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { getInterior } from "../../lib/api-service";
import Chat from "../elements/Chat";
import FollowButton from "../elements/FollowButton";
import moment from "moment";

export default {
  name: "Detail",
  components: { Chat, FollowButton },
  data: function () {
    return {
      messages: [],
    };
  },
  computed: {
    data() {
      return window.data.interior2;
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
  mounted() {
    console.log(window.data);
    //this.getMessages();
  },
  methods: {
    getMessages() {
      const url = "/ajax/chat/" + this.interior_id;
      axios.get(url).then((response) => {
        this.messages = response.data;
      });
    },
    // async loadInterior() {
    //   try {
    //     this.interior = await getInterior(); //interiorを取得していないからinteriorIdが使えない
    //   } catch (e) {
    //     this.interior = [];
    //     console.log(e);
    //   }
    // },
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
        //this.messages = response.data;
      });
    },
    // toggleFollowMessage() {
    //   if (isFollowed == false) {
    //     return "FOLLOW";
    //   } else {
    //     return "FOLLOWED";
    //   }
    // },
    goDetail(userId) {
      location.href = `/show/${userId}`;
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
.py-4 {
  background-color: #eeeeee;
  height: 100vh;
}

#app {
  background-color: #eeeeee;
}
</style>