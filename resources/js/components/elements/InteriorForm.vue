<template>
  <form action class="interiorform">
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
    <div class="btn-wraper">
      <button type="button" class="btn btn-outline-dark" v-on:click="onSubmit">Submit</button>
      <!-- <button type="button" class="btn btn-outline-danger" v-on:click="clear">Reset</button> -->
    </div>
  </form>
</template>
<script>
export default {
  name: "InteriorForm",
  props: {
    interior: {
    type: Object,
    // default: () => {
    //   return {
    //     category: "",
    //     style: "",
    //     detail: "",
    //   };
    // },
  },
  },
  data: function () {
    return {
      category: "",
      style: "",
      detail: "",
    };
  },
  methods: {
    onSubmit() {
      const interior = {
        category: this.category,
        style: this.style,
        detail: this.detail,
      };
      this.$emit("submit", interior);
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
</style>