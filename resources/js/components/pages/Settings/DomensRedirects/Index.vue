<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>
    <span>
      {{text}}
    </span>

  </div>
</template>

<script>

  import PageTitle from "../../../../Layout/Components/PageTitle.vue";

  export default {
    components: {
      PageTitle,
    },
    data: () => ({
      heading: 'Настройки',
      subheading: 'Домены и редиректы',
      icon: 'pe-7s-home icon-gradient bg-warm-flame',
      text: `
        Домены и редиректы
      `
    }),
  }
</script>
