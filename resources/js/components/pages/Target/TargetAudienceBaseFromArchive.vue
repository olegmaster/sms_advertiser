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
      heading: 'Таргетинг',
      subheading: 'База целевых аудиторий из архива',
      icon: 'pe-7s-users icon-gradient bg-warm-flame',
      text: `
        База целевых аудиторий точно из архива!
      `
    }),
  }
</script>
