<template>
  <v-app>
    <v-card height="670px">
      <v-toolbar dark>
        <v-toolbar-title>Chat Form</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn color="black" text v-on:click="changeShow(interior.id)">
          <template v-if="this.isUnWatch">
            <v-icon color="orange darken-2" large>mdi-eye-outline</v-icon>
          </template>
          <template v-else>
            <v-icon color="white" large>mdi-eye-off-outline</v-icon>
          </template>
        </v-btn>
        <v-btn color="black" text v-on:click="sendMessage()">
          <v-icon large color="primary">mdi-arrow-up-circle</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text class="pt-10 pb-0 pl-10 pr-16">
        <v-text-field class="pa-0" v-model="body" label="Post Message" clearable name="input-7-4"></v-text-field>
      </v-card-text>
      <v-container id="scroll-target" style="height: 520px" class="overflow-y-auto">
        <v-row v-scroll:#scroll-target="onScroll" style="height: 800px">
          <v-col>
            <v-col v-for="message in messages" v-bind:key="message.id" cols="12" class="mt-0">
              <v-row>
                <v-col cols="4">
                  <v-responsive>
                    <v-list-item>
                      <div v-if="interior.user_id === message.user_id">
                        <v-list-item-icon class="mr-1">
                          <v-icon color="primary">mdi-account</v-icon>
                        </v-list-item-icon>
                      </div>
                      <div v-else>
                        <v-list-item-icon class="mr-1">
                          <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>
                      </div>
                      <v-list-item-content>
                        <v-list-item-title>{{ message.user.name }}</v-list-item-title>
                      </v-list-item-content>
                      <v-list-item-icon text v-on:click="goDetail(message.user_id)">
                        <v-icon color="green darken-2">mdi-arrow-right-circle</v-icon>
                      </v-list-item-icon>
                    </v-list-item>
                  </v-responsive>
                </v-col>
                <v-col cols="5">
                  <v-responsive>
                    <v-list-item>
                      <v-list-item-icon class="mr-1">
                        <v-icon>mdi-clock</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{ message.created_at | moment }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-responsive>
                </v-col>
                <v-col cols="3">
                  <v-responsive>
                    <v-list-item>
                      <WatchButton v-bind:message="message" />
                      <div v-if="checkUser(message.user_id)">
                        <v-list-item-icon text v-on:click="deleteMessage(message.id)">
                          <v-icon color="red">mdi-delete</v-icon>
                        </v-list-item-icon>
                      </div>
                      <div v-else>
                        <v-list-item-icon>
                          <v-icon>mdi-delete</v-icon>
                        </v-list-item-icon>
                      </div>
                    </v-list-item>
                  </v-responsive>
                </v-col>
                <v-col cols="12" class="pt-0">
                  <v-responsive>
                    <v-list-item>
                      <v-list-item-icon class="mr-1">
                        <v-icon>mdi-message</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{ message.body }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-responsive>
                </v-col>
              </v-row>
            </v-col>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </v-app>
</template>
<script>
import moment from "moment";
import ListChange from "../elements/ListChange";
import WatchButton from "../elements/WatchButton";
import {
  getAuthUser,
  changeRead,
  getWatchMessages,
} from "../../lib/api-service";

export default {
  name: "Chat",
  components: {
    ListChange,
    moment,
  },
  props: {
    interior: Object,
  },
  data: function () {
    return {
      body: "",
      interior_id: this.interior.id,
      is_read: false,
      searchConditions: {
        yetRead: false,
      },
      isUnWatch: false,
      messages: [],
      user: {},
      // class="pl-15"
    };
  },
  mounted() {
    this.loadAuthUser();
    this.checkUser();
    this.getMessages();
    console.log(this.interior);

    Echo.channel("chat").listen("MessageCreated", (e) => {
      console.log("success!");
      this.getMessages();
      if (this.isUnWatch === true) {
        this.isUnWatch = !this.isUnWatch;
      } else {
        console.log("stay");
      }
    });
  },
  methods: {
    async loadAuthUser() {
      try {
        this.user = await getAuthUser();
        console.log("success");
      } catch (e) {
        this.user = [];
        console.log(e);
      }
    },
    checkUser(userId) {
      return userId === this.user.id;
    },
    getMessages() {
      const url = "/ajax/chat/" + this.interior_id;
      axios.get(url).then((response) => {
        this.messages = response.data;
      });
    },
    getWatchMessages(interiorId) {
      const url = "/users/" + interiorId + "/watchMessages";
      axios.get(url).then((response) => {
        console.log(response.data);
        this.messages = response.data.data;
      });
    },
    sendMessage() {
      const url = "/ajax/chat";
      const params = {
        interior_id: this.interior_id,
        body: this.body,
        is_read: this.is_read,
      };
      axios.post(url, params).then((response) => {
        this.body = "";
      });
    },
    deleteMessage(messageId) {
      const idx = this.messages.findIndex((m) => m.id === messageId);
      const url = "/ajax/chat/" + messageId;
      axios.delete(url).then((response) => {});
    },
    changeShow(interiorId) {
      if (this.isUnWatch === false) {
        this.isUnWatch = !this.isUnWatch;
        console.log("show UnWatch");
        this.getWatchMessages(interiorId);
      } else {
        this.isUnWatch = !this.isUnWatch;
        this.messages = this.getMessages();
        console.log("show all");
      }
    },
    goDetail(userId) {
      location.href = `/show/${userId}`;
    },
    onScroll(e) {
      this.offsetTop = e.target.scrollTop;
    },
  },
  filters: {
    moment: function (date) {
      return moment(date).format("YYYY/MM/DD HH:mm");
    },
  },
};
</script>
<style scoped>
.v-text-field {
  display: block;
}
</style>