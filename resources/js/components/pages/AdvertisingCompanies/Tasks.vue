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
      heading: 'Рекламные компании',
      subheading: 'Список заданий',
      icon: 'pe-7s-server icon-gradient bg-warm-flame',
      text: `
        Рекламные компании, список заданий
      `
    }),
  }
</script>
