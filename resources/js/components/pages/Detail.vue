<template>
  <!-- <v-app> -->
  <v-container>
    <v-row>
      <v-col cols="12" md="5">
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
              <!-- <v-list-item-icon>
                <v-icon>mdi-clock</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ interior.created_at | moment }}</v-list-item-title>
              </v-list-item-content>-->
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
              <v-list-item-icon>
                <v-icon>mdi-message</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>
                  <pre>{{interior.description}}</pre>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <!-- <v-card-title>Date</v-card-title>
            <v-card-text>{{ interior.created_at | moment }}</v-card-text>
            <v-card-title>User Name</v-card-title>
            <v-card-text>{{ interior.user.name }}</v-card-text>
            <v-card-title>Category</v-card-title>
            <v-card-text>{{interior.tag}}</v-card-text>
            <v-card-title>Description</v-card-title>
            <v-card-text>
              <pre>{{interior.description}}</pre>
            </v-card-text>-->
          </v-responsive>
        </v-card>
      </v-col>
      <v-col cols="12" md="7">
        <Chat v-bind:interior="interior" v-on:delete="deleteMessage" />
      </v-col>
    </v-row>
  </v-container>
  <!-- </v-app> -->
</template>
<script>
import { getInterior } from "../../lib/api-service";
import Chat from "../elements/Chat";
import moment from "moment";

export default {
  name: "Detail",
  components: { Chat },
  data: function () {
    return {
      messages: [],
    };
  },
  computed: {
    data() {
      return window.data;
    },
    interior() {
      return window.data.interior;
    },
    interiorId() {
      return this.interior.id;
    },
    user() {
      return window.data.user;
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