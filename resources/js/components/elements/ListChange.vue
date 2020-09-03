<template>
  <v-checkbox v-model="_yetRead"></v-checkbox>
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
</style>