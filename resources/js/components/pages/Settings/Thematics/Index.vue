<template>
    <div>
        <page-title :heading=heading :subheading=subheading :icon=icon></page-title>
        <span>

      {{text}}
    </span>
        <ThematicTable />

    </div>
</template>

<script>

    import PageTitle from "../../../../Layout/Components/PageTitle.vue";
    import ThematicTable from "./ThematicTable";

    export default {
        components: {
            PageTitle,
            ThematicTable
        },
        data: () => ({
            heading: 'Настройка',
            subheading: 'Тематика',
            icon: 'pe-7s-home icon-gradient bg-warm-flame',
            text: `
        Тематика
      `
        }),
    }
</script>
