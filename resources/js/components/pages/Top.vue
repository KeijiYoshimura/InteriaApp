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
                  :src="interior.image"
                  :aspect-ratio="4/3"
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
      </v-col>
    </v-row>
  </v-app>
</template>
<script>
import InteriorSearchForm from "../elements/InteriorSearchForm";
import { getInteriors } from "../../lib/api-service";

export default {
  name: "Top",
  components: { InteriorSearchForm },
  data: function () {
    return {
      searchConditions: {
        keyword: "",
        onlyFavorite: false,
      },
      interiors: [],
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
  },
  computed: {
    filteredInteriors() {
      const keyword = this.searchConditions.keyword;
      return this.interiors.filter((i) => i.tag.includes(keyword));
    },
  },
};
</script>
<style>
</style>