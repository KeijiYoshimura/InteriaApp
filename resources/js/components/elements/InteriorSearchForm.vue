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
  <!-- <div class="interiors-search-container">
    <div class="interiors-search-container-keyword-container">
      <span class="icon-search"></span>
      <input
        id="interiors-search-container-keyword"
        type="text"
        name="keyword"
        v-model="innerKeyword"
      />
    </div>
    <div class="interiors-search-container-fav-container">
      <input
        id="interiors-search-container-fav"
        type="checkbox"
        name="fav"
        v-model="innerOnlyFavorite"
      />
      <label for="interiors-search-container-fav">：お気に入りだけ表示する。</label>
    </div>
  </div>-->
</template>

<script>
export default {
  name: "interiorSearchForm",
  props: {
    keyword: String,
    // onlyFavorite: Boolean,
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
    // innerOnlyFavorite: {
    //   get() {
    //     return this.$props.onlyFavorite;
    //   },
    //   set(value) {
    //     this.$emit("changeOnlyFavorite", value);
    //   },
    // },
  },
};
</script>

<style scoped>
.v-text-field {
  font-size: 1.6em;
  text-align: center;
}

.centered-input input {
  text-align: center;
}

.interiors-search-container {
  width: 100%;
  text-align: center;
}

.interiors-search-container-keyword-container {
  padding: 0.61em;
}

.interiors-search-container-keyword-container input[type="text"] {
  text-align: center;
  font-size: 1.6em;
  border: 0;
  border-bottom: 1px solid black;
  padding-top: 0.3em;
  padding-bottom: 0.3em;
  padding-left: 0.61em;
  padding-right: 0.61em;
  margin: 0;
  outline: none;
  width: 61%;
  max-width: 680px;
}

.interiors-search-container-keyword-container .icon-search {
  background-image: url("/image/search.svg");
  background-size: cover;
  display: inline-block;
  width: 1.6em;
  height: 1.6em;
  margin-left: 0.61em;
}
</style>
