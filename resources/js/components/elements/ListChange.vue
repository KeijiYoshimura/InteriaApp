<template>
  <!-- <div class="list-change-container">
  <label>-->
  <!-- <v-checkbox v-model="_yetRead" :label="`UnCheked`"></v-checkbox> -->
  <v-checkbox v-model="_yetRead"></v-checkbox>
  <!-- <input v-model="_yetRead" id="list-change-yetRead" type="checkbox" name="yetRead" />UnCheked
    </label>
  </div>-->
  <!-- <v-btn color="primary" text v-on:click="sendMessage()">
    <v-icon large dark right>mdi-arrow-up-circle</v-icon>
  </v-btn>-->
  <!-- <v-if>
    <h2>UnCheked</h2>
  </v-if>
  <v-else>
    <h2>Checked</h2>
  </v-else>-->
</template>

<script>
export default {
  name: "ListChange",
  props: {
    yetRead: Boolean,
  },
  computed: {
    _yetRead: {
      get() {
        return this.$props.yetRead;
      },
      set(yetRead) {
        this.$emit("changeYetRead", yetRead);
      },
    },
  },
};
</script>

<style>
/* .btn {
  font-size: 1.5em;
}

.list-change-container {
  text-align: center;
}

.list-change-container label {
  display: block;
  font-size: 1.5em;
}

#list-change-yetRead {
  transform: scale(2);
} */
</style>