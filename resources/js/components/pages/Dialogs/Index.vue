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
      heading: 'Диалоги SMS и MMS',
      subheading: 'Диалоги SMS и MMS',
      icon: 'pe-7s-chat icon-gradient bg-warm-flame',
      text: `
        тут надо будет нарисовать Диалоги SMS и MMS
      `
    }),
  }
</script>
