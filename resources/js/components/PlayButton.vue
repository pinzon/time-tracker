<template>
  <i v-if="state" title="Pause" class="fas fa-pause" @click="click()"></i>
  <i v-else title="Play" class="fas fa-play" @click="click()"></i>
</template>

<script>
export default {
  props: [
    "state" //bool
  ],
  methods: {
    click: function() {
      this.$emit("click");
    }
  }
};
</script>

