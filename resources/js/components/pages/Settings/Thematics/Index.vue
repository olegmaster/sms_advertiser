<template>

    <div>

        <b-modal hide-backdrop content-class="shadow" ok-title="Создать" cancel-title="Отмена" id="add-thematics"
                 title="Создать тематику" >

            <div class="d-block text-center">
                <b-alert v-if="validation_status === 'success'" show variant="success">{{thematic_validation}}</b-alert>
                <b-alert v-if="validation_status === 'error'" show variant="danger">{{thematic_validation}}</b-alert>

                <h5 v-if="!validation_status">Название тематики</h5>
                <b-form-input v-model="new_thematics_name" autofocus/>
            </div>
            <template v-slot:modal-footer>
                <div class="w-100">
                    <b-button v-if="validation_status === 'success'"
                        variant="primary"
                        size="sm"
                        class="float-right"
                        @click="closeCreateThematicsModal"
                    >
                        Закрыть
                    </b-button>
                    <b-button v-if="validation_status !== 'success'"
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
            <b-card title="" class="main-card mb-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <b-button size="sm" class="mr-2 mb-2 btn-shadow btn-hover-shine btn-transition"
                                      variant="primary" @click="selectAll()">
                                Выбрать все
                            </b-button>
                            <b-dropdown dropup no-flip text="Операции с выбранными" class="mb-2 mr-2" variant="primary">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-secondary">
                                        <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                        <div class="menu-header-content"><h6 class="menu-header-title">Операции</h6>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" tabindex="0" class="dropdown-item" v-on:click="edit('activate')">
                                    Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item"
                                        v-on:click="edit('deactivate')">Деактивировать
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item" v-on:click="deleteItems()">
                                    Удалить
                                </button>
                            </b-dropdown>
                        </div>
                        <div class="col-md-auto">
                            <b-row v-if="totalRows > perPage">
                                <b-col md="6" class="my-1">
                                    <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage"
                                                  v-on:change="unselect" class="my-0"/>
                                </b-col>
                            </b-row>
                        </div>
                        <div class="col-md-auto">
                            <button type="button" v-b-modal.add-thematics
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить тематику
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Main table element -->
                <b-table striped hover show-empty bordered
                         stacked="md"
                         :items="thematics"
                         :fields="fields"
                         :current-page="currentPage"
                         :per-page="perPage"
                         :filter="filter"
                         :sort-by.sync="sortBy"
                         :sort-desc.sync="sortDesc"
                         :sort-direction="sortDirection"
                         @filtered="onFiltered"
                         :busy="tableIsBusy"
                >
                    <template v-slot:cell(checkbox_field)="data">
                        <b-form-checkbox v-model="data.item.checked"></b-form-checkbox>
                    </template>
                    <template slot:table-busy>
                        <div class="text-center text-danger my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Загрузка...</strong>
                        </div>
                    </template>
                    <template slot="id" slot-scope="row">{{row.id}}</template>
                    <template slot="name" slot-scope="row"><b>{{row.name}}</b></template>
                    <template slot="created_at" slot-scope="row">{{row.created_at}}</template>
                    <template slot="status" slot-scope="row">Hello World</template>
                    <template slot="username" slot-scope="row">{{row.username}}</template>
                    <template slot="actions" slot-scope="row">
                        <b-button variant="success">Редактировать</b-button>
                        <b-button variant="danger">Удалить</b-button>
                    </template>

                </b-table>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-auto">
                            <b-button size="sm" class="mr-2 mb-2 btn-shadow btn-hover-shine btn-transition"
                                      variant="primary" @click="selectAll()">
                                Выбрать все
                            </b-button>
                            <b-dropdown dropup no-flip text="Операции с выбранными" class="mb-2 mr-2" variant="primary">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-secondary">
                                        <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                        <div class="menu-header-content"><h6 class="menu-header-title">Операции</h6>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" tabindex="0" class="dropdown-item" v-on:click="edit('activate')">
                                    Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item">Деактивировать</button>
                                <button type="button" tabindex="2" class="dropdown-item">Удалить</button>
                            </b-dropdown>

                        </div>

                        <div class="col-md-auto">
                            <button type="button" v-b-modal.add-thematics
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить тематику
                            </button>
                        </div>
                        <div class="col">

                        </div>
                        <div class="col-md-auto">
                            <b-row v-if="totalRows > perPage">
                                <b-col md="6" class="my-1">
                                    <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage"
                                                  v-on:change="unselect" class="my-0"/>
                                </b-col>
                            </b-row>
                        </div>

                    </div>
                </div>


            </b-card>
        </div>

    </div>
</template>

<script>

    import PageTitle from "../../../../Layout/Components/PageTitle.vue";
    import {faStar, faPlus} from '@fortawesome/free-solid-svg-icons'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

    export default {
        components: {
            PageTitle,
            'font-awesome-icon': FontAwesomeIcon,
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
            thematic_validation: '',
            validation_status: '',
            fields: [
                {key: 'checkbox_field', label: ''},
                {key: 'id', label: 'ID'},
                {
                    key: 'name',
                    label: 'Название тематики',
                    sortable: true,
                    'class': 'text-center font-weight-bold',
                },
                {key: 'created_at', label: 'Дата создания'},
                {
                    key: 'status', label: 'Активен', formatter: value => {
                        return value === 1 ? 'Да' : 'Нет'
                    }
                },
                {key: 'username', label: 'Автор'},
            ],
            currentPage: 1,
            perPage: 20,
            pageOptions: [5, 10, 15],
            sortBy: null,
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            modalInfo: {title: '', content: ''},
            allSelected: false,
        }),
        mounted() {
            this.thematics = this.fetchThematics();
            this.$root.$on('bv::modal::show', (bvEvent, modalId) => {
                this.thematic_validation = ''
                this.validation_status = ''
                this.new_thematics_name = ''
            })
        },
        methods: {
            addThematics() {
                axios.post('/api/settings/thematics', {
                    name: this.new_thematics_name,
                }).then(function (response) {
                    if (response.data.status === true) {
                        this.thematics.push(response.data.data)
                        this.totalRows += 1;
                        this.validation_status = 'success'
                        this.thematic_validation = response.data.message
                        setTimeout(() => {
                            this.$bvModal.hide('add-thematics');
                        }, 5000)
                    } else {
                        this.validation_status = 'error'
                    }
                    console.log(response);

                }.bind(this)).catch(function (error) {
                    if(error.response){
                        // laravel automatically returns errors json with errors
                        // in the case of validation failed in the object extending Illuminate\Foundation\Http\FormRequest
                        // we get the errors array from the response
                        const errors = error.response.data.errors
                        // we can have errors from different DB table fields
                        // here we get first error of the first field
                        this.thematic_validation = errors[Object.keys(errors)[0]][0]
                        // set validation status for the setting alert type of error or success or other
                        this.validation_status = 'error'
                    }

                }.bind(this))
            },
            fetchThematics() {
                return axios.get('/api/settings/thematics/').then(result => {

                    let gotten_thematics = result.data.data

                    for (let i in gotten_thematics){
                        gotten_thematics[i].checked = false;
                        let dateTime = gotten_thematics[i].created_at.split(' ');
                        gotten_thematics[i].created_at = dateTime[0]
                    }

                    this.thematics = gotten_thematics;

                    console.log(this.thematics)

                    this.totalRows = this.thematics.length
                    this.tableIsBusy = false
                });
            },
            edit(type) {
                if (type === 'activate') {
                    for (let i in this.thematics) {

                        if (this.thematics[i].checked && this.thematics[i].status === 0) {
                            this.tableIsBusy= true
                            this.updateItem(this.thematics[i].id, {
                                'status': 1
                            }).then(result => {
                                if (result.data.status === true) {
                                    this.thematics[i].status = 1;
                                }

                            });
                        }
                    }
                    this.tableIsBusy= false
                    this.allSelected= false
                }
                if (type === 'deactivate') {

                    for (let i in this.thematics) {

                        if (this.thematics[i].checked && this.thematics[i].status === 1) {
                            this.tableIsBusy= true
                            this.updateItem(this.thematics[i].id, {
                                'status': 0
                            }).then(result => {
                                if (result.data.status === true) {
                                    this.thematics[i].status = 0;
                                }

                            });
                        }
                    }
                    this.tableIsBusy= false
                    this.allSelected = false
                }
            },
            updateItem(id, data) {
                return axios.put('/api/settings/thematics/' + id, data);
            },
            deleteItems() {

                for (let i in this.thematics) {
                    if (this.thematics[i].checked) {
                        this.tableIsBusy= true
                        this.deleteItem(this.thematics[i].id).then(result => {
                            if(result.data.status === true)
                            {
                                this.thematics = this.thematics.filter(item => !item.checked)
                            }
                            this.tableIsBusy = false
                        });
                    }
                }
                this.allSelected = false;
            },
            deleteItem(id) {
                return axios.delete('/api/settings/thematics/' + id);
            },
            info(item, index, button) {
                this.modalInfo.title = `Row index: ${index}`
                this.modalInfo.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', 'modalInfo', button)
            },
            resetModal() {
                this.modalInfo.title = ''
                this.modalInfo.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            selectAll() {
                this.allSelected = !this.allSelected;
                let start = (this.currentPage - 1) * this.perPage;
                for (let i in this.thematics)
                    this.thematics[i].checked = false;
                for (let i = start; i < start + this.perPage; i++) {
                    this.thematics[i].checked = this.allSelected;
                }

                console.log(this.thematics)
            },
            unselect() {
                this.allSelected = false;
                for (let i in this.thematics)
                    this.thematics[i].checked = false;
                console.log(22)
            },
            closeCreateThematicsModal(){
                this.$bvModal.hide('add-thematics')
            }
        }
    }
</script>
