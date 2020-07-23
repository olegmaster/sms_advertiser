<template>

    <div>

        <b-modal hide-backdrop content-class="shadow" ok-title="Создать" cancel-title="Отмена" id="add-thematics"
                 title="Создать тематику" onsubmit="alert()">

            <div class="d-block text-center">
                <p>Название тематики</p>
                <b-form-input v-model="new_thematics_name"/>
            </div>
            <template v-slot:modal-footer>
                <div class="w-100">
                    <p class="float-left">Modal Footer Content</p>
                    <b-button
                        variant="primary"
                        size="sm"
                        class="float-right"
                        @click="addThematics"
                    >
                        Создать
                    </b-button>
                </div>
            </template>
        </b-modal>
        <page-title :heading=heading :subheading=subheading :icon=icon></page-title>


        <ThematicTable v-bind:thematics="thematics" v-bind:totalRows="totalRows" />
        <div>
            <b-card class="main-card mb-3 text-center">
                <b-button class="mr-2" v-b-modal.add-thematics variant="primary">Добавить тематику</b-button>
            </b-card>
        </div>

    </div>
</template>

<script>

    import PageTitle from "../../../../Layout/Components/PageTitle.vue";
    import ThematicTable from "./ThematicTable";

    export default {
        components: {
            PageTitle,
            ThematicTable,
        },
        data: () => ({
            heading: 'Настройка',
            subheading: 'Тематика',
            icon: 'pe-7s-home icon-gradient bg-warm-flame',
            text: `Тематика`,
            new_thematics_name: '',
            thematics: [],
            totalRows: 0,
        }),
        mounted() {
            this.thematics = this.fetchThematics()
        },
        methods: {
            addThematics() {
                axios.post('/api/settings/thematics', {
                    name: this.new_thematics_name,
                }).then(function (response) {
                    this.new_thematics_name = '';
                    console.log(response);
                    this.thematics.push(response.data.data)
                    this.totalRows += 1;
                }.bind(this)).catch(function (error) {
                    console.log(error);
                })
            },
            fetchThematics() {
                return axios.get('/api/settings/thematics/').then(result => {
                    console.log(result.data.data)
                    this.thematics = result.data.data;
                    this.totalRows = this.thematics.length
                    console.log(this.totalRows);
                });
            },
        }
    }
</script>
