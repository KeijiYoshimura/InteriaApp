<template>
  <v-app>
    <!-- <v-content>
    <v-container>-->
    <v-card>
      <v-card-actions>
        <v-card-title>Chat Field</v-card-title>
        <v-spacer></v-spacer>
        <v-btn color="primary" text @click="send">Submit</v-btn>
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
      <v-container id="scroll-target" style="max-height: 450px" class="overflow-y-auto">
        <v-row v-scroll:#scroll-target="onScroll" style="height: 1000px">
          <v-col>
            <v-card v-for="message in messages" v-bind:key="message.id">
              <v-card-title>{{message.user.name}}</v-card-title>
              <v-card-text>{{message.created_at | moment}}</v-card-text>
              <v-card-text>{{message.body}}</v-card-text>
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

export default {
  name: "Chat",
  props: {
    interior: {},
  },
  data: function () {
    return {
      body: "",
      interior_id: this.interior.id,
      messages: [],
      offsetTop: 0,
    };
  },
  methods: {
    getMessages() {
      const url = "/ajax/chat/" + this.interior_id;
      axios.get(url).then((response) => {
        this.messages = response.data;
      });
    },
    send() {
      const url = "/ajax/chat";
      const params = {
        body: this.body,
        interior_id: this.interior_id,
      };
      axios.post(url, params).then((response) => {
        // 成功したらメッセージをクリア
        this.body = "";
      });
    },
    onScroll(e) {
      this.offsetTop = e.target.scrollTop;
    },
  },
  // computed: {
  //   interiorId() {
  //     return this.interior.id;
  //   },
  //   interior() {
  //     return window.data.interior;
  //   },
  // },
  mounted() {
    this.getMessages();

    Echo.channel("chat").listen("MessageCreated", (e) => {
      this.getMessages(); // メッセージを再読込
    });
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