<template>

    <div>

        <b-modal hide-backdrop content-class="shadow" ok-title="Создать" cancel-title="Отмена" id="add-thematics"
                 title="Создать тематику" onsubmit="alert()">

            <div class="d-block text-center">
                <p>{{thematic_validation}}</p>
                <p v-if="!thematic_validation">Название тематики</p>
                <b-form-input v-model="new_thematics_name"/>
            </div>
            <template v-slot:modal-footer>
                <div class="w-100">
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
        <div>
            <b-card class="main-card mb-3 text-center">
                <b-button class="mr-2" v-b-modal.add-thematics variant="primary">Добавить тематику</b-button>
            </b-card>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <b-dropdown dropup no-flip text="Операции с выбранными" class="mb-2 mr-2" variant="primary">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-secondary">
                                    <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                    <div class="menu-header-content"><h6 class="menu-header-title">Операции</h6></div>
                                </div>
                            </div>
                            <button type="button" tabindex="0" class="dropdown-item" v-on:click="edit('activate')">Активировать</button>
                            <button type="button" tabindex="1" class="dropdown-item">Деактивировать</button>
                            <button type="button" tabindex="2" class="dropdown-item">Удалить</button>
                        </b-dropdown>
                    </div>
                    <div class="col-md-auto">
                    </div>
                    <div class="col-md-auto">
                        <button type="button" class="btn-shadow d-inline-flex align-items-center btn btn-success">
                            <font-awesome-icon class="mr-2" icon="plus"/>
                            Добавить тематику
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <ThematicTable
            v-bind:thematics="thematics"
            v-bind:totalRows="totalRows"
            v-bind:busy-state="tableIsBusy"
        />


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
            tableIsBusy: true,
            thematic_validation: ''
        }),
        mounted() {
            this.thematics = this.fetchThematics();
            this.$root.$on('bv::modal::show', (bvEvent, modalId) => {
                this.thematic_validation = ''
                this.new_thematics_name = ''
            })
        },
        methods: {
            addThematics() {
                axios.post('/api/settings/thematics', {
                    name: this.new_thematics_name,
                }).then(function (response) {
                    if (response.data.status === 'ok') {
                        this.new_thematics_name = '';
                        console.log(response);
                        this.thematics.push(response.data.data)

                        this.totalRows += 1;
                    }
                    this.thematic_validation = response.data.message
                }.bind(this)).catch(function (error) {
                    this.thematic_validation = error.name
                    console.log(error);

                }.bind(this))
            },
            fetchThematics() {
                return axios.get('/api/settings/thematics/').then(result => {

                    let gotten_thematics = result.data.data

                    for (let i in gotten_thematics)
                        gotten_thematics[i].checked = false;

                    this.thematics = gotten_thematics;

                    console.log(this.thematics)

                    this.totalRows = this.thematics.length
                    this.tableIsBusy = false
                });
            },
            edit(type){

                if(type === 'activate'){
                    console.log(type)
                    for (let i in this.thematics){
                        if(this.thematics[i].checked && this.thematics[i].status === 0){
                            this.updateItem(this.thematics[i].id, {
                                'status': 1
                            })
                        }
                    }
                }
                if(type === 'deactivate'){

                    for (let i in this.thematics){
                        if(this.thematics.checked ){
                            this.updateItem(this.thematics[i].id, {
                                'status': 0
                            })
                        }
                    }
                }
            },
            updateItem(id, data){
                return axios.put('/api/settings/thematics/' + id, data).then(result => {
                    if(result.data.status === 'success') {
                        for (let i in this.thematics){
                            if(this.thematics[i].id === id){
                                this.thematics[i].status = 1
                            }
                        }
                    }
                });
            }
        }
    }
</script>
