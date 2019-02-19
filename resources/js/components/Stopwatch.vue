<template>
    <span> 00 : 00 : 00 </span>
</template>

<script>
export default {
  props: [
      'active',
      'endsAt',
      'lastUpdate'
  ],

  mounted() {
    console.log("Component mounted.");
  },

  methods: {
  }
};
</script>

<style>
</style>

