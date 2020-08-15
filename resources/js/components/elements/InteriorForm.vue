<template>
  <v-app>
    <!-- <input v-on:change="fileSelected" type="file" name="image" /> -->
    <!-- <tr>
            <th>
              <label for="interiorform-category">Category</label>
            </th>
            <td>
              <input
                v-model="category"
                type="text"
                list="category_list"
                v-init:category="interior.category"
              />
              <datalist id="category_list">
                <option value="デスク"></option>
                <option value="チェア"></option>
                <option value="ベッド"></option>
                <option value="マットレス"></option>
                <option value="ソファ"></option>
              </datalist>
            </td>
          </tr>
          <tr>
            <th>
              <label for="interiorform-style">Style</label>
            </th>
            <td>
              <input v-model="style" type="text" list="style_list" v-init:style="interior.style" />
              <datalist id="style_list">
                <option value="アメリカン"></option>
                <option value="北欧"></option>
                <option value="南欧"></option>
                <option value="アジアン"></option>
                <option value="ゴシック"></option>
                <option value="ロココ"></option>
                <option value="モダン"></option>
                <option value="アンティーク"></option>
                <option value="ヴィンテージ"></option>
                <option value="ロココ"></option>
                <option value="シンプル"></option>
              </datalist>
            </td>
          </tr>
          <tr>
            <th>
              <label for="interiorform-detail">Detail</label>
            </th>
            <td>
              <input
                v-model="detail"
                id="interiorform-detail"
                type="text"
                name="detail"
                v-init:detail="interior.detail"
              />
            </td>
          </tr>
          <tr>
            <th>
              <label for="interiorform-description">Description</label>
            </th>
            <td>
              <textarea
                ref="adjust_textarea"
                v-on:click="adjustHeight"
                v-model="description"
                id="interiorform-description"
                type="text"
                name="description"
                v-init:description="interior.description"
              ></textarea>
            </td>
    </tr>-->
    <v-container>
      <v-row>
        <v-col cols="12" md="5">
          <v-card>
            <v-img :src="imageData" v-if="imageData" :aspect-ratio="4/3" />
          </v-card>
        </v-col>
        <v-col cols="12" md="7">
          <v-file-input
            v-model="image"
            label="Select File"
            v-on:change="fileSelected"
            outlined
            dense
            name="image"
          ></v-file-input>
          <v-combobox
            v-model="SelectStyle"
            :items="styles"
            v-init:SelectStyle="interior.style"
            label="Select Style"
            outlined
            dense
            clearable
          ></v-combobox>
          <v-combobox
            v-model="SelectCategory"
            :items="categories"
            v-init:SelectCategory="interior.category"
            label="Select Category"
            outlined
            dense
            clearable
          ></v-combobox>
          <v-text-field
            v-model="detail"
            v-init:detail="interior.detail"
            label="Detail"
            outlined
            dense
            clearable
          ></v-text-field>
          <v-textarea
            v-model="description"
            v-init:description="interior.description"
            label="Description"
            outlined
            clearable
            rows="3"
            name="input-7-4"
          ></v-textarea>
          <v-card-actions mx-auto>
            <v-btn v-on:click="onSubmit" text outlined>POST</v-btn>
            <v-btn v-on:click="clear" text outlined>RESET</v-btn>
          </v-card-actions>
        </v-col>
      </v-row>
    </v-container>
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
      categories: ["デスク", "チェア", "ベッド", "マットレス", "ソファ"],
      detail: "",
      description: "",
    };
  },
  methods: {
    onSubmit() {
      let data = new FormData();
      data.append("image", this.image);
      data.append("style", this.SelectStyle);
      data.append("category", this.SelectCategory);
      data.append("detail", this.detail);
      data.append("description", this.description);

      // postInterior(data)
      //   .then(() => {
      //     location.href = "/";
      //   })
      //   .catch((err) => console.log(err));

      // axios
      //   .post("/api/interiors", data)
      //   .then((response) => {
      //     location.href = "/";
      //   })
      //   .catch((err) => console.log(err));

      // const interior = {
      //   category: this.category,
      //   style: this.style,
      //   detail: this.detail,
      //   description: this.description,
      // };
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
      //this.image = event.target.files[0];
      const file = e;
      const reader = new FileReader();
      reader.onload = (e) => {
        this.imageData = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    // adjustHeight() {
    //   const textarea = this.$refs.adjust_textarea;
    //   const resetHeight = new Promise(function (resolve) {
    //     resolve((textarea.style.height = "auto"));
    //   });
    //   resetHeight.then(function () {
    //     textarea.style.height = textarea.scrollHeight + "px";
    //   });
    // },
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
.v-text-area{
  display: block;
}
</style>