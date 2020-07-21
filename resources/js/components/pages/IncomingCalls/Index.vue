<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>
    <span>
      {{text}}
    </span>

  </div>
</template>

<script>

  import PageTitle from "../../../Layout/Components/PageTitle.vue";

  export default {
    components: {
      PageTitle,
    },
    data: () => ({
      heading: 'Входящие вызовы',
      subheading: 'Входящие вызовы',
      icon: 'pe-7s-call icon-gradient bg-warm-flame',
      text: `
        тут надо будет нарисовать Входящие вызовы
      `
    }),
  }
</script>
