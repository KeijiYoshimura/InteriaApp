<template>
  <v-app>
    <v-row>
      <v-col cols="12" sm="10" offset-sm="1" class="pt-10">
        <v-container fluid>
          <v-row>
            <v-col cols="12" md="7">
              <v-row>
                <v-col>
                  <v-card>
                    <v-img :src="imageData" v-if="imageData" :aspect-ratio="4/3" height="580px" />
                  </v-card>
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12" md="5">
              <v-row>
                <v-col>
                  <v-card height="580px">
                    <v-toolbar dark dense>
                      <v-toolbar-title>Post Form</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-btn icon color="black" text v-on:click="onSubmit">
                        <v-icon color="primary">mdi-arrow-up-circle</v-icon>
                      </v-btn>
                      <v-btn icon color="black" text v-on:click="clear">
                        <v-icon color="red">mdi-delete</v-icon>
                      </v-btn>
                    </v-toolbar>
                    <v-file-input
                      v-model="image"
                      label="Select File"
                      v-on:change="fileSelected"
                      name="image"
                      class="px-10 mt-5"
                    ></v-file-input>
                    <v-combobox
                      v-model="SelectStyle"
                      :items="styles"
                      v-init:SelectStyle="interior.style"
                      label="Select Style"
                      clearable
                      class="px-10 mt-5"
                    ></v-combobox>
                    <v-combobox
                      v-model="SelectCategory"
                      :items="categories"
                      v-init:SelectCategory="interior.category"
                      label="Select Category"
                      clearable
                      class="px-10 mt-5"
                    ></v-combobox>
                    <v-text-field
                      v-model="detail"
                      v-init:detail="interior.detail"
                      label="Detail"
                      clearable
                      class="px-10 mt-5"
                    ></v-text-field>
                    <v-textarea
                      v-model="description"
                      v-init:description="interior.description"
                      label="Description"
                      clearable
                      rows="5"
                      class="px-10 mt-5"
                    ></v-textarea>
                  </v-card>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <v-container></v-container>
  </v-app>
</template>
<script>
import { postInterior } from "../../lib/api-service";

export default {
  name: "InteriorForm",
  props: {
    interior: {
      type: Object,
      default: () => {
        return {
          image: null,
          imageData: "",
          SelectStyle: null,
          SelectCategory: null,
          detail: "",
          tag: "",
          description: "",
        };
      },
    },
  },
  data: function () {
    return {
      image: null,
      imageData: "",
      SelectStyle: "",
      styles: [
        "アジアン",
        "アメリカン",
        "アンティーク",
        "インダストリアル",
        "ヴィンテージ",
        "カントリー",
        "クラシック",
        "コンテンポラリー",
        "ゴシック",
        "シンプル",
        "地中海",
        "トロピカル",
        "ナチュラル",
        "南欧",
        "北欧",
        "ミッドセンチュリー",
        "ミニマル",
        "モダン",
        "レトロ",
        "ロココ",
        "和風",
      ],
      SelectCategory: "",
      categories: [
        "絵画",
        "観葉植物",
        "キッチン",
        "ソファ",
        "チェア",
        "デスク",
        "デスク",
        "テレビ台",
        "時計",
        "ベッド",
        "マットレス",
        "ライト",
        "ラグ",
        "なし",
      ],
      detail: "",
      description: "",
    };
  },
  methods: {
    onSubmit() {
      let data = new FormData();
      this.tag =
        this.SelectStyle +
        "/" +
        this.SelectCategory +
        "/" +
        this.detail +
        "/" +
        this.description;
      console.log(this.tag);
      data.append("image", this.image);
      data.append("style", this.SelectStyle);
      data.append("category", this.SelectCategory);
      data.append("detail", this.detail);
      data.append("tag", this.tag);
      data.append("description", this.description);
      this.$emit("submit", data);
    },
    clear() {
      this.image = null;
      this.SelectStyle = "";
      this.SelectCategory = "";
      this.detail = "";
      this.description = "";
    },
    fileSelected(e) {
      const file = e;
      const reader = new FileReader();
      reader.onload = (e) => {
        this.imageData = e.target.result;
      };
      reader.readAsDataURL(file);
    },
  },
  computed: {
    createTag() {
      this.tag =
        this.SelectStyle + "/" + this.SelectCategory + "/" + this.detail;
    },
  },
  directives: {
    init: {
      bind(el, binding, vnode) {
        vnode.context[binding.arg] = binding.value;
      },
    },
  },
};
</script>
<style>
.v-text-area {
  display: block;
}
</style>