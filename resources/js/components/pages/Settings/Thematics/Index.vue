<template>
    <div>
        <page-title :heading=heading :subheading=subheading :icon=icon></page-title>

        <b-card title="" class="main-card mb-4">
            <div>
                <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-auto">
                            <b-button size="sm" class="mr-2 mb-2 btn-shadow btn-hover-shine btn-transition"
                                      variant="primary" @click="selectAll()">
                                Выбрать все
                            </b-button>
                            <b-dropdown dropup no-flip text="Действия над выбранными" class="mb-2 mr-2"
                                        variant="primary" ref="dropdown0" :disabled="checkedItemsCount==0">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-secondary">
                                        <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                        <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" tabindex="0" class="dropdown-item"
                                        @click="activateThematics(null, 1)">Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item"
                                        @click="activateThematics(null, 0)">Деактивировать
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item text-danger" @click="onDeleteThematics(null)">
                                    Удалить
                                </button>
                            </b-dropdown>
                        </div>
                        <div class="col" align="left">
                            <div>
                                <h5>Количество записей: {{itemsTotalCount}}</h5>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button type="button" @click="showaddThematicsModal=true"
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить тематику
                            </button>
                        </div>
                        <div class="col-md-auto">
                            <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions"
                                           @change="page = 1; getThematics()"></b-form-select>
                        </div>
                    </div>
                </div>
                <b-table striped bordered outlined hover :items="items" :fields="fields">

                    <template v-slot:cell(checkbox_field)="data">
                        <b-form-checkbox v-model="data.item.checked"></b-form-checkbox>
                    </template>

                    <template v-slot:cell(status)="data">
                        <div v-show="data.item.status==1" class="text-success">Да</div>
                        <div v-show="data.item.status==0" class="text-danger">Нет</div>
                    </template>

                    <template v-slot:cell(operations)="data">

                        <b-dropdown dropup no-flip text="Действия" class="mb-2 mr-2" variant="primary" ref="dropdown0">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-secondary">
                                    <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                    <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6></div>
                                </div>
                            </div>
                            <button type="button" tabindex="0" class="dropdown-item" @click="activateThematics(data.item.id, 1)">
                                Активировать
                            </button>
                            <button type="button" tabindex="1" class="dropdown-item" @click="activateThematics(data.item.id, 0)">
                                Деактивировать
                            </button>
                            <button type="button" tabindex="1" class="dropdown-item text-primary"
                                    @click="onEditThematics(data.item)">Редактировать
                            </button>
                            <button type="button" tabindex="2" class="dropdown-item text-danger" @click="onDeleteThematics(data.item.id)">
                                Удалить
                            </button>
                        </b-dropdown>

                    </template>


                    <template v-slot:table-colgroup="scope">
                        <col :style="{ width: '25px'}">
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col :style="{ width: '120px'}">
                    </template>

                </b-table>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-auto">
                            <b-dropdown dropup no-flip text="Действия над выбранными" class="mb-2 mr-2"
                                        variant="primary" ref="dropdown0" :disabled="checkedItemsCount==0">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-secondary">
                                        <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                        <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" tabindex="0" class="dropdown-item"
                                        @click="activateThematics(null, 1)">Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item"
                                        @click="activateThematics(null, 0)">Деактивировать
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item text-danger" @click="onDeleteThematics(null)">
                                    Удалить
                                </button>
                            </b-dropdown>
                        </div>
                        <div class="col-md-auto">
                            <button type="button" @click="showaddThematicsModal=true" v-b-modal.modal-add-domain
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить тематику
                            </button>
                        </div>
                        <div class="col">

                        </div>

                        <div class="col-md-auto">
                            <v-pagination v-model="page" @input="getThematics()" :length="pagesCount"
                                          :total-visible="10"></v-pagination>
                        </div>
                    </div>
                </div>
            </div>

        </b-card>

        <add-thematics-modal v-model="showaddThematicsModal" @add-success="getThematics()"></add-thematics-modal>
        <edit-thematics-modal v-model="showeditThematicsModal" :form="thematicsToEdit"
                           @edit-success="getThematics()"></edit-thematics-modal>


    </div>
</template>

<script>

    import PageTitle from "../../../../Layout/Components/PageTitle.vue";
    import VueElementLoading from 'vue-element-loading'
    import vSelect from 'vue-select'
    import {library} from '@fortawesome/fontawesome-svg-core'
    import {faStar, faPlus} from '@fortawesome/free-solid-svg-icons'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

    library.add(faStar, faPlus);
    import AddThematicsModal from "./modals/AddThematicsModal";
    import EditThematicsModal from "./modals/EditThematicsModal";

    export default {
        components: {
            PageTitle,
            VueElementLoading,
            vSelect,
            'font-awesome-icon': FontAwesomeIcon,
            AddThematicsModal,
            EditThematicsModal
        },
        data: () => ({
            heading: 'Настройки',
            subheading: 'Тематики',
            icon: 'pe-7s-home icon-gradient bg-warm-flame',
            fields: [
                {key: 'checkbox_field', label: ''},
                {key: 'id', label: 'ID'},
                {key: 'name', label: 'Название тематики'},
                {key: 'created_at', label: 'Дата создания'},
                {key: 'status', label: 'Активен'},
                {key: 'username', label: 'Автор'},
                {key: 'operations', label: 'Операции'},
            ],
            itemsPerPageOptions: [
                {text: 'Показать по 10', value: '10'},
                {text: 'Показать по 25', value: '25'},
                {text: 'Показать по 50', value: '50'},
                {text: 'Показать по 100', value: '100'},
                {text: 'Показать по 150', value: '150'},
                {text: 'Показать по 250', value: '250'},
                {text: 'Показать по 500', value: '500'}
            ],
            items: [],
            itemsPerPage: 25,
            allSelected: false,
            isLoading: false,
            page: 1,
            pagesCount: 1,
            itemsTotalCount: 0,
            showaddThematicsModal: false,
            showeditThematicsModal: false,
            thematicsToEdit: {
                id: null,
                name: '',
            }
        }),
        computed: {
            checkedItemsCount() {
                return this.items.filter(v => v.checked).length;
            }
        },
        methods: {
            getThematics() {
                let vm = this;
                this.allSelected = false;
                this.isLoading = true;
                let new_items = [];
                let url = '/api/settings/thematics/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
                axios.get(url).then(response => {
                   // console.log(response);
                    if (!response.data.errorCode) {
                        new_items = response.data.data.items;
                        console.log(new_items)
                        this.pagesCount = Math.ceil(response.data.data.stat.itemsCount / this.itemsPerPage);
                        this.itemsTotalCount = response.data.data.stat.itemsCount;
                        for (let i in new_items) {
                            new_items[i].checked = false;
                            let dateTime = new_items[i].created_at.split(' ');
                            new_items[i].created_at = dateTime[0]
                            console.log(1)
                        }
                        vm.items = new_items;
                    }
                    vm.isLoading = false;
                }).catch(responce => {
                    vm.isLoading = false;
                });
            },
            onEditThematics(thematics) {
                this.thematicsToEdit.id = thematics.id;
                this.thematicsToEdit.name = thematics.name;
                this.showeditThematicsModal = true;
            },

            activateThematics(id = null, status = null) {
                if (status === 1)
                    this.updateThematics(id, 1);
                else
                    this.updateThematics(id, 2);
            },

            updateThematics(id = null, action = null) {
                this.hideDropDown(id);
                this.isLoading = true;
                let vm = this;
                let url;
                let data = {
                    value: action
                };

                url = '/api/settings/thematics/' + action;

                if (id) {
                    data.ids = [id]
                } else {
                    data.ids = this.items.filter(v => v.checked).map(v => v.id);
                }

                axios.patch(url, data).then(response => {
                    if (!response.data.errorCode) {
                        this.getThematics();
                        this.$toast('Тематика обновлена успешно');
                    } else
                        this.isLoading = false;
                }).catch(responce => {
                    this.isLoading = false;
                });
            },

            hideDropDown(id = null) {
                // if (id)
                //     this.$refs['dropdown_'+id].hide(true);
                // else {
                //     this.$refs['dropdown0'].hide(true);
                //     this.$refs['dropdown1'].hide(true);
                // }

            },

            selectAll() {
                this.allSelected = !this.allSelected;
                for (let i in this.items)
                    this.items[i].checked = this.allSelected;
            },
            deleteThematics(id = null) {
                this.hideDropDown(id);
                this.isLoading = true;
                let vm = this;
                let url;
                let data = {
                    value: 1
                };


                if (id) {
                    data.ids = [id]
                } else {
                    data.ids = this.items.filter(v => v.checked).map(v => v.id);
                }


                for(id of data.ids){
                    url = '/api/settings/thematics/' + id;
                    axios.delete(url, {data}).then(response => {
                        if (!response.data.errorCode) {
                            this.page = 1;
                            this.getThematics();


                        } else
                            this.isLoading = false;
                    }).catch(responce => {
                        this.isLoading = false;
                    });
                }
                setTimeout(this.$toast('Операция удаления прошла успешно', 'danger'), 3000);


            },
            onDeleteThematics(id = null) {
                let title = !id ? 'Вы уверены в том что хотите удалить выделенные тематики?' : 'Вы уверены в том что хотите удалить тематику?';
                this.$bvModal.msgBoxConfirm(title, {
                    title: 'Потвердите',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'Да',
                    cancelTitle: 'Нет',
                    headerClass: 'p-2 border-bottom-0',
                    footerClass: 'p-2 border-top-0',
                    centered: false,
                    hideBackdrop: true
                })
                    .then(value => {
                        if (value)
                            this.deleteThematics(id);
                    })
                    .catch(err => {

                    })
            },
        },
        watch: {
            itemsPerPage: function (val) {
                this.$cookies.set('thematics_list_per_page', val, '31d');
            }
        },
        mounted() {
            let itemsPerPage = this.$cookies.get('thematics_list_per_page');
            if (itemsPerPage && parseInt(itemsPerPage) > 0)
                this.itemsPerPage = itemsPerPage;
            this.getThematics();
        }
    }
</script>
