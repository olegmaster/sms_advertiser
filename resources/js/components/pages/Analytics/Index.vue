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
      heading: 'Аналитика',
      subheading: 'Аналитика',
      icon: 'pe-7s-graph2 icon-gradient bg-warm-flame',
      text: `
        Тут будут графики аналитики
      `
    }),
  }
</script>
