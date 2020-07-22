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
      heading: 'Спам лист',
      subheading: 'Спам лист',
      icon: 'pe-7s-call icon-gradient bg-warm-flame',
      text: `
        Спам лист
      `
    }),
  }
</script>
