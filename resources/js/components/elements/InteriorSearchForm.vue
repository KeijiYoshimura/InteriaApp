<template>
  <v-form>
    <v-container>
      <v-row>
        <v-col cols="12" sm="4" offset-sm="4">
          <v-text-field
            prepend-icon="mdi-magnify"
            clearable
            height="30px"
            name="keyword"
            v-model="innerKeyword"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
export default {
  name: "interiorSearchForm",
  props: {
    keyword: String,
  },
  methods: {},
  computed: {
    innerKeyword: {
      get() {
        return this.$props.keyword;
      },
      set(value) {
        this.$emit("changeKeyword", value);
      },
    },
  },
};
</script>

<style scoped>
</style>
