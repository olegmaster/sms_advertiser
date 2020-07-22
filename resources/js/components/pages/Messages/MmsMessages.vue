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
      heading: 'База сообщений',
      subheading: 'MMS сообщения',
      icon: 'pe-7s-server icon-gradient bg-warm-flame',
      text: `
        MMS сообщения
      `
    }),
  }
</script>
