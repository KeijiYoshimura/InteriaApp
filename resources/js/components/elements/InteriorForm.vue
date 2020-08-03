<template>
  <v-app>
    <!-- <input v-on:change="fileSelected" type="file" name="image" />
          <tr>
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
      <v-icon>mdi-cog</v-icon>
      <v-file-input label="File input" v-on:change="fileSelected" outlined dense></v-file-input>
      <v-combobox
        v-model="SelectCategory"
        :items="categories"
        label="Select Category"
        outlined
        dense
      ></v-combobox>
      <v-combobox v-model="SelectStyle" :items="styles" label="Select Style" outlined dense></v-combobox>
      <v-text-field v-model="detail" label="Detail" outlined dense></v-text-field>
      <v-textarea v-model="description" solo name="input-7-4" label="Description"></v-textarea>
      <v-btn color="primary" v-on:click="onSubmit">Submit</v-btn>
      <v-btn color="error" v-on:click="clear">Reset</v-btn>
      <!-- <div class="btn-wraper">
              <button type="button" class="btn btn-outline-dark" v-on:click="onSubmit">Submit</button>
              <button type="button" class="btn btn-outline-danger" v-on:click="clear">Reset</button>
      </div>-->
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
          image: "",
          SelectCategory: null,
          SelectStyle: null,
          styles: ["アメリカン", "北欧"],
          detail: "",
          description: "",
        };
      },
    },
  },
  data: function () {
    return {
      image: "",
      SelectCategory: "",
      categories: ["デスク", "チェア", "ベッド", "マットレス", "ソファ"],
      SelectStyle: "",
      styles: ["アメリカン", "北欧"],
      detail: "",
      description: "",
    };
  },
  methods: {
    onSubmit() {
      let data = new FormData();
      data.append("image", this.image);
      data.append("category", this.SelectCategory);
      data.append("style", this.SelectStyle);
      data.append("detail", this.detail);
      data.append("description", this.description);

      // postInterior(data)
      //   .then(() => {
      //     location.href = "/";
      //   })
      //   .catch((err) => console.log(err));

      axios
        .post("/api/interiors", data)
        .then((response) => {
          location.href = "/";
          //console.log(response);
        })
        .catch((err) => console.log(err));

      // const interior = {
      //   category: this.category,
      //   style: this.style,
      //   detail: this.detail,
      //   description: this.description,
      // };
      // this.$emit("submit", interior);
    },
    clear() {
      this.image = "";
      this.category = "";
      this.style = "";
      this.detail = "";
      this.description = "";
    },
    fileSelected(event) {
      //console.log(event);
      this.image = event.target.files[0];
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
</style>