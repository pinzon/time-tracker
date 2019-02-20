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
    // console.log('mounted')
    this.interval = setInterval(this.updateTimer, 1000);
    this.stopwatch = this.hhmmss(this.seconds);
  },

  beforeDestroy() {
    // console.log('destroyed')
    clearInterval(this.interval);
  },

  watch: {},

  methods: {
    updateTimer: function() {
      if (this.active && this.seconds > 0) {
        this.$emit("update:seconds", this.seconds - 1);
      }
      this.stopwatch = this.hhmmss(this.seconds);
    },

    hhmmss: function(secs) {
        var minutes = Math.floor(secs / 60);
        secs = secs % 60;
        var hours = Math.floor(minutes / 60);
        minutes = minutes % 60;
        return `${this.pad(hours)}:${this.pad(minutes)}:${this.pad(secs)}`;
    },

    pad: function (num) {
      return ("0"+num).slice(-2);
    }
  }
};
</script>

<style>
</style>

