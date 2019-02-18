<template>
     <i v-if="state" class="fa fa-check-square-o" aria-hidden="true" @click="click()"></i>
    <i v-else class="fa fa-square-o" aria-hidden="true" @click="click()"></i>
</template>

<script>
export default {
    props: [
        'state', //bool
    ],
    click: async function () {
           this.$emit('click');
    },
}
</script>

