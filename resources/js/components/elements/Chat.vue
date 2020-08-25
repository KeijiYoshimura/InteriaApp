<template>
  <v-app>
    <!-- <v-content>
    <v-container>-->
    <v-card height="620px">
      <!--height="837px"-->
      <v-card-actions>
        <v-card-title>Chat Field</v-card-title>
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
      <v-container id="scroll-target" style="height: 430px" class="overflow-y-auto">
        <v-row v-scroll:#scroll-target="onScroll" style="height: 800px">
          <v-col>
            <v-card v-for="message in messages" v-bind:key="message.id">
              <v-card-title>{{message.user.name}}</v-card-title>
              <v-card-text>{{message.created_at | moment}}</v-card-text>
              <v-card-text class="pt-0">{{message.body}}</v-card-text>
              <!-- <v-btn color="primary" text v-on:click="deleteMessage(message.id)">Delete</v-btn> -->
              <!-- <v-btn color="primary" text v-on:click="updateMessage(message.id)">Edit</v-btn> -->
              <v-btn color="red" text v-on:click="deleteMessage(message.id)">
                <v-icon dark right>mdi-delete</v-icon>
              </v-btn>
              <!-- <div v-if="checkUser">
                <v-icon>mdi-delete</v-icon>
              </div>
              <div v-else>切り替え後に表示される要素</div>-->
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
    <!-- </v-container>
    </v-content>-->
  </v-app>
</template>
<script>
import moment from "moment";
import { getAuthUser } from "../../lib/api-service";

export default {
  name: "Chat",
  props: {
    interior: Object,
  },
  data: function () {
    return {
      body: "",
      interior_id: this.interior.id,
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
        console.log('success');
      } catch (e) {
        this.user = [];
        console.log(e);
      }
    },
    // checkUser() {
    //   return message.user_id ===
    // },
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
    onScroll(e) {
      this.offsetTop = e.target.scrollTop;
    },
  },
  mounted() {
    this.loadAuthUser();
    //console.log(this.user);

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