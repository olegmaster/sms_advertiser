<template>

    <div>
        <b-modal id="add-thematics" title="Bootstrap-Vue">
            <p class="my-4">Hello from modal!</p>
        </b-modal>
        <page-title :heading=heading :subheading=subheading :icon=icon></page-title>


        <ThematicTable/>
        <div >
            <b-card class="main-card mb-3 text-center">
                <b-button class="mr-2" v-b-modal.add-thematics variant="primary">Добавить тематику</b-button>
            </b-card>
        </div>

    </div>
</template>

<script>

    import PageTitle from "../../../../Layout/Components/PageTitle.vue";
    import ThematicTable from "./ThematicTable";
    import Tabs from 'vue-tabs-with-active-line';

    const TABS = [{
        title: 'Basic',
        value: 'tab1',
    }];

    export default {
        components: {
            PageTitle,
            ThematicTable,
            Tabs
        },
        data: () => ({
            heading: 'Настройка',
            subheading: 'Тематика',
            icon: 'pe-7s-home icon-gradient bg-warm-flame',
            text: `Тематика`,
            tabs: TABS,
        }),
        methods: {
            handleClick(newTab) {
                this.currentTab = newTab;
            },
        }
    }
</script>
