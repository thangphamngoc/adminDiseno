<template>
  <div>
    <input placeholder="Enter Text Here" v-model="tempMessage"  />
  </div>
</template>

<script>
export default {
  name: "ComponentFirst",
  data () {
    return {
      tempMessage: "",
    };
  },
  watch: {
    tempMessage() {
      this.$emit("inputData", this.tempMessage);
    },
  },
};
</script>