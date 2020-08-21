<template>
  <v-app>
    <InteriorSearchForm
      v-bind:keyword="searchConditions.keyword"
      v-bind:onlyFavorite="searchConditions.onlyFavorite"
      v-on:changeOnlyFavorite="setOnlyFavorite"
      v-on:changeKeyword="setKeyword"
    />
    <v-row>
    <v-col cols="12" sm="10" offset-sm="1">
    <!-- <v-card> -->
      <v-container fluid>
        <v-row>
          <v-col
            v-for="interior in filteredInteriors"
            v-bind:key="interior.id"
            class="d-flex child-flex"
            cols="4"
          >
            <v-card flat tile class="d-flex">
              <v-img
                :src="interior.image | replace('public','storage')"
                aspect-ratio="1"
                class="grey lighten-2"
                v-on:click="goDetail(interior.id)"
              >
                <template v-slot:aplaceholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                  </v-row>
                </template>
              </v-img>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    <!-- </v-card> -->
    </v-col>
    </v-row>
  </v-app>
</template>
<script>
import Interior from "../elements/Interior";
import InteriorSearchForm from "../elements/InteriorSearchForm";
import { getInteriors } from "../../lib/api-service";

export default {
  name: "Top",
  components: { Interior, InteriorSearchForm },
  data: function () {
    return {
      searchConditions: {
        keyword: "",
        onlyFavorite: false,
      },
      interiors: [],
      tag: "",
    };
  },
  mounted() {
    this.loadInteriors();
    console.log(this.interiors[0]);
  },
  methods: {
    async loadInteriors() {
      try {
        this.interiors = await getInteriors();
      } catch (e) {
        this.interiors = [];
        console.log(e);
      }
    },
    setOnlyFavorite(value) {
      this.searchConditions.onlyFavorite = value;
    },
    setKeyword(value) {
      this.searchConditions.keyword = value;
    },
    goDetail(interiorId) {
      location.href = `/detail/${interiorId}`;
    },
    goEdit(interior) {
      location.href = `/edit/${interior.id}`;
    },
    output() {
      console.log(this.interiors["style"]);
    },
  },
  filters: {
    replace: function (str) {
      return str.replace("public", "storage");
    },
  },
  computed: {
    // tag() {
    //   this.tag =
    //     this.interiors[style] +
    //     this.interiors[category] +
    //     this.interiors[detail];
    // },
    filteredInteriors() {
      const keyword = this.searchConditions.keyword;
      //const onlyFavorite = this.searchConditions.onlyFavorite;
      return (
        this.interiors
          //.filter((b) => !onlyFavorite || b.is_favorite === true)
          .filter((i) => i.tag.includes(keyword))
      );
    },
  },
};
</script>
<style>
</style>