<template>
  <v-app>
    <v-card height="634px">
      <v-card-actions>
        <v-card-title>Chat Field</v-card-title>
        <v-spacer></v-spacer>
        <ListChange v-bind:yetRead="searchConditions.yetRead" v-on:changeYetRead="setYetRead" />
        <v-card-title class="pl-0">UnChecked</v-card-title>
        <v-spacer></v-spacer>
        <v-btn color="primary" text v-on:click="sendMessage()">
          <v-icon large dark right>mdi-arrow-up-circle</v-icon>
        </v-btn>
      </v-card-actions>
      <v-card-text class="py-0">
        <v-text-field
          class="pa-0"
          v-model="body"
          label="Post Message"
          outlined
          clearable
          name="input-7-4"
        ></v-text-field>
      </v-card-text>
      <!-- <v-row>
          <v-col>
            <v-card v-for="message in messages" v-bind:key="message.id">
              <v-card-title>{{message.user.name}}</v-card-title>
              <v-card-text>{{message.created_at | moment}}</v-card-text>
              <v-card-text>{{message.body}}</v-card-text>
            </v-card>
            <v-text-field
              v-model="message"
              label="Post Message"
              outlined
              clearable
              name="input-7-4"
            ></v-text-field>
            <v-btn v-on:click="send" text outlined>POST</v-btn>
      </v-col>-->
      <!-- <v-col>
            <v-textarea
              v-model="message"
              label="Post Message"
              outlined
              clearable
              rows="3"
              name="input-7-4"
            ></v-textarea>
            <v-btn v-on:click="send" text outlined>POST</v-btn>
      </v-col>-->
      <!-- </v-row> -->
      <!-- <v-row justify="center" align="center">
        <v-subheader>Chat Field</v-subheader>
        {{ offsetTop }}
      </v-row>-->
      <v-container id="scroll-target" style="height: 440px" class="overflow-y-auto">
        <v-row v-scroll:#scroll-target="onScroll" style="height: 800px">
          <v-col>
            <!-- <v-row>
            <v-col cols="12" sm="8" offset-sm="2">-->
            <v-card v-for="message in yetMessages" v-bind:key="message.id">
              <!-- <v-list-item>
                <v-list-item-icon>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-text large>{{message.user.name}}</v-list-item-text>
              </v-list-item>-->
              <v-card-actions class="py-0">
                <v-card-title>{{message.user.name}}</v-card-title>
                <v-spacer></v-spacer>
                <div v-on:click="toggleRead(message)">
                  <div v-if="message.is_read">
                    <v-icon color="primary" large>mdi-eye-settings-outline</v-icon>
                  </div>
                  <div v-else>
                    <v-icon large>mdi-eye-settings-outline</v-icon>
                  </div>
                </div>
                <v-spacer></v-spacer>
                <div v-if="checkUser(message.user_id)">
                  <div text v-on:click="deleteMessage(message.id)">
                    <v-icon color="red" large>mdi-delete</v-icon>
                  </div>
                </div>
                <div v-else>
                  <v-icon large>mdi-delete</v-icon>
                </div>
              </v-card-actions>
              <!-- <v-list-item>
                <v-list-item-icon>
                <div v-if="checkUser(message.user_id)">
                  <div text v-on:click="deleteMessage(message.id)">
                    <v-icon color="red" large>mdi-delete</v-icon>
                  </div>
                </div>
                </v-list-item-icon>
                <div v-on:click="toggleRead(message)">
                  <div v-if="message.is_read">
                    <v-icon color="primary" large>mdi-eye-settings-outline</v-icon>
                  </div>
                  <div v-else>
                    <v-icon large>mdi-eye-settings-outline</v-icon>
                  </div>
                </div>
              </v-list-item>-->
              <v-list-item>
                <v-list-item-text>{{message.created_at | moment}}</v-list-item-text>
              </v-list-item>
              <v-list-item>
                <v-list-item-text class="pt-0">{{message.body}}</v-list-item-text>
              </v-list-item>
              <!-- <v-card-actions class="py-0">
                <v-btn v-on:click="toggleRead(message)">
                  <template v-if="message.is_read">
                    <v-icon color="primary">mdi-eye-settings-outline</v-icon>
                  </template>
                  <template v-else>
                    <v-icon>mdi-eye-settings-outline</v-icon>
                  </template>
                </v-btn>
              </v-card-actions>-->
              <!-- <v-list-item>
                <v-list-item-icon v-on:click="toggleRead(message)">
                  <template v-if="message.is_read">
                    <v-icon color="primary" large>mdi-eye-settings-outline</v-icon>
                  </template>
                  <template v-else>
                    <v-icon large>mdi-eye-settings-outline</v-icon>
                  </template>
                </v-list-item-icon>
              </v-list-item>-->
            </v-card>
          </v-col>
        </v-row>
        <!-- </v-col>
        </v-row>-->
      </v-container>
    </v-card>
  </v-app>
</template>
<script>
import moment from "moment";
import ListChange from "../elements/ListChange";
import { getAuthUser, changeRead } from "../../lib/api-service";

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
      messages: [],
      user: {},
      // isUser: false,
      //offsetTop: 0,
    };
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
        console.log(response.data[0].user_id);
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
    // ondelete(messageId) {
    //   this.$emit("delete", messageId);
    // },
    deleteMessage(messageId) {
      //console.log(messageId);
      const idx = this.messages.findIndex((m) => m.id === messageId);
      const url = "/ajax/chat/" + messageId;
      //console.log(url);
      // const params = {
      //   message_id: messageId,
      //   body: this.body,
      // };
      axios.delete(url).then((response) => {
        //this.message = this.messages.splice(idx, 1);
        console.log(response);
        //this.messages = response.data;
      });
    },
    toggleRead(message) {
      const url = "/ajax/chat/" + message.id + "/read";
      axios.patch(url).then((response) => {
        console.log(response);
        console.log(message.is_read);
        message.is_read = !message.is_read;
        console.log(message.is_read);
      });
    },
    // async toggleRead(message) {
    //   console.log(message);
    //   message.is_read = !message.is_read;
    //   try {
    //     await changeRead(message.id);
    //   } catch (e) {
    //     console.log(e);
    //     message.is_read = !message.is_read;
    //   }
    // },
    setYetRead(yetRead) {
      //console.log(yetRead);
      console.log(this.searchConditions.yetRead);
      this.searchConditions.yetRead = yetRead;
      console.log(this.searchConditions.yetRead);
    },
    onScroll(e) {
      this.offsetTop = e.target.scrollTop;
    },
  },
  mounted() {
    this.loadAuthUser();
    //console.log(this.user);

    this.checkUser();

    this.getMessages();

    Echo.channel("chat").listen("MessageCreated", (e) => {
      console.log("success!");
      this.getMessages();
    });
    // Echo.channel("chat").listen("MessageDeleted", (e) => {
    //   console.log("bbb");
    //   this.getMessages();
    // });
  },
  computed: {
    yetMessages: function () {
      return this.messages.filter(
        (m) => !m.is_read || !this.searchConditions.yetRead
      );
      // .sort(function (a, b) {
      //   return a.time > b.time ? 1 : -1;
      // });
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