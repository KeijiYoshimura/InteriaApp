<template>
  <form action class="interior-form">
    <table>
      <tbody>
        <input v-on:change="fileSelected" type="file" name="image" />
        <tr>
          <th>
            <label for="interiorform-category">Category</label>
          </th>
          <td>
            <!-- <input v-model="category" id="interiorform-category" type="text" name="category" /> -->
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
            <!-- <input v-model="style" id="interiorform-style" type="text" name="style" /> -->
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
        </tr>
        <div class="btn-wraper">
          <button type="button" class="btn btn-outline-dark" v-on:click="onSubmit">Submit</button>
          <!-- <button type="button" class="btn btn-outline-danger" v-on:click="clear">Reset</button> -->
        </div>
      </tbody>
    </table>
  </form>
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
          category: "",
          style: "",
          detail: "",
          description: "",
        };
      },
    },
  },
  data: function () {
    return {
      image: "",
      category: "",
      style: "",
      detail: "",
      description: "",
    };
  },
  methods: {
    onSubmit() {
      let data = new FormData();
      data.append("image", this.image);
      data.append("category", this.category);
      data.append("style", this.style);
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
          location.href = "/new";
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
    fileSelected(event) {
      //console.log(event);
      this.image = event.target.files[0];
    },
    adjustHeight() {
      const textarea = this.$refs.adjust_textarea;
      const resetHeight = new Promise(function (resolve) {
        resolve((textarea.style.height = "auto"));
      });
      resetHeight.then(function () {
        textarea.style.height = textarea.scrollHeight + "px";
      });
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
.interior-form table {
  margin: 0 auto;
  width: 80%;
}

.interior-form input,
textarea {
  width: 70%;
  font-size: 100%;
  border: none;
  border-bottom: 2px solid lightgray;
  text-align: center;
}
</style>