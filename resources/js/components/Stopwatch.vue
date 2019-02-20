<template>
  <span>{{ stopwatch }}</span>
</template>

<script>
export default {
  props: ["active", "seconds"],

  data: function() {
    return {
      stopwatch: this.seconds.toString(),
      interval: null
    };
  },

  mounted() {
    this.stopwatch = moment.utc(this.seconds*1000).format('HH:mm:ss');;
    this.interval = setInterval(this.updateTimer, 1000);
  },

  beforeDestroy() {
    clearInterval(this.interval);
  },

  methods: {
    updateTimer: function() {
      if (this.active && this.seconds > 0 ) {
        this.$emit("update:seconds", this.seconds  - 1);
      }

      // this.stopwatch = this.seconds.toString();
      this.stopwatch = moment.utc(this.seconds*1000).format('HH:mm:ss');
    }
  }
};
</script>

<style>
</style>

