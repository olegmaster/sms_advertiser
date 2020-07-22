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
      heading: 'Избранное',
      subheading: 'Избранное',
      icon: 'pe-7s-call icon-gradient bg-warm-flame',
      text: `
        Избранное
      `
    }),
  }
</script>
