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
                                <button type="button" tabindex="1" class="dropdown-item" @click="checkSimbank(null, 1)">
                                    Проверить
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item"
                                        @click="activateSimbank(null, 1)">Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item"
                                        @click="activateSimbank(null, 0)">Деактивировать
                                </button>
                            </b-dropdown>
                        </div>
                        <div class="col" align="left">
                            <div>
                                <h5>Количество записей: {{itemsTotalCount}}</h5>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button type="button" @click="showAddSimbankModal=true"
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить симбанк
                            </button>
                        </div>
                        <div class="col-md-auto">
                            <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions"
                                           @change="page = 1; getSimbanks()"></b-form-select>
                        </div>
                    </div>
                </div>

                <b-table  striped bordered outlined hover  :items="items" :fields="fields">

                    <template v-slot:cell(checkbox_field)="data">
                        <b-form-checkbox v-model="data.item.checked"></b-form-checkbox>
                    </template>

                    <template v-slot:cell(status)="data">
                        <div v-show="data.item.status==1" class="text-success">Да</div>
                        <div v-show="data.item.status==0" class="text-danger">Нет</div>
                    </template>


                    <template v-slot:cell(operations)="data">
                        <b-dropdown dropup no-flip text="Действия" class="mb-2 mr-2"
                                    variant="primary" ref="dropdown0">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-secondary">
                                    <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                    <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6>
                                    </div>
                                </div>
                            </div>
                            <button type="button" tabindex="2" class="dropdown-item" @click="checkSimbank(data.item.id, 1)">
                                Проверить
                            </button>
                            <button type="button" tabindex="0" class="dropdown-item" @click="activateSimbank(data.item.id, 1)">Активировать
                            </button>
                            <button type="button" tabindex="1" class="dropdown-item"
                                    @click="activateSimbank(data.item.id, 0)">Деактивировать
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
                                <button type="button" tabindex="1" class="dropdown-item" @click="checkSimbank(null, 1)">
                                    Проверить
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item"
                                        @click="activateSimbank(null, 1)">Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item"
                                        @click="activateSimbank(null, 0)">Деактивировать
                                </button>
                            </b-dropdown>
                        </div>
                        <div class="col-md-auto">
                            <button type="button" @click="showAddSimbankModal=true" v-b-modal.modal-add-domain
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить симбанк
                            </button>
                        </div>
                        <div class="col">

                        </div>

                        <div class="col-md-auto">
                            <v-pagination v-model="page" @input="getSimbanks()" :length="pagesCount"
                                          :total-visible="10"></v-pagination>
                        </div>
                    </div>
                </div>
            </div>

        </b-card>

        <add-simbank-modal v-model="showAddSimbankModal" @add-success="getSimbanks()"></add-simbank-modal>



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
    import AddSimbankModal from "./modals/AddSimbankModal";


    export default {
        components: {
            PageTitle,
            VueElementLoading,
            vSelect,
            'font-awesome-icon': FontAwesomeIcon,
            AddSimbankModal,
        },
        data: () => ({
            heading: 'Настройки',
            subheading: 'Симбанки',
            icon: 'pe-7s-home icon-gradient bg-warm-flame',
            fields: [
                {key: 'checkbox_field', label: ''},
                {key: 'id', label: 'ID'},
                {key: 'name', label: 'Название'},
                {key: 'adc_name', label: 'Рекламные компании'},
                {key: 'capacity', label: 'Вместимость'},
                {key: 'all_sent_sms_count', label: 'Кол. отправ. SMS'},
                {key: 'all_sent_mms_count', label: 'Кол. отправ. MMS'},
                {key: 'all_sent_voice_call_count', label: 'Кол. голос. отпр.'},
                {key: 'status', label: 'Активный'},
                {key: 'created_at', label: 'Дата добавления'},
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
            showAddSimbankModal: false,
            showEditSimbankModal: false,
            simbankToEdit: {
                id: null,
                domain: '',
                spam_limit: 32000,
                freeze_hours: 24,
            }
        }),
        computed: {
            checkedItemsCount() {
                return this.items.filter(v => v.checked).length;
            }
        },
        methods: {
            getSimbanks() {
                let vm = this;
                this.allSelected = false;
                this.isLoading = true;
                let new_items = [];
                let url = '/api/settings/simbanks/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
                axios.get(url).then(response => {
                    if (!response.data.errorCode) {
                        new_items = response.data.data.items;
                        this.pagesCount = Math.ceil(response.data.data.stat.itemsCount / this.itemsPerPage);
                        vm.itemsTotalCount = response.data.data.stat.itemsCount;
                        for (let i in new_items) {
                            new_items[i].checked = false;
                            let dateTime = new_items[i].created_at.split(' ');
                            new_items[i].created_at = dateTime[0]
                        }

                        vm.items = new_items;

                    }
                    vm.isLoading = false;
                }).catch(responce => {
                    vm.isLoading = false;
                });
            },
            onEditSimbank(simbank) {
                this.simbankToEdit.id = simbank.id;
                this.simbankToEdit.name = simbank.name;
                this.showEditSimbankModal = true;
            },
            activateSimbank(id = null, status = null) {
                if (status === 1)
                    this.updateSimbank(id, 1);
                else
                    this.updateSimbank(id, 2);
            },
            checkSimbank(id = null, status = null) {
                return false;
            },

            updateSimbank(id = null, action = null) {
                this.hideDropDown(id);
                this.isLoading = true;
                let vm = this;
                let url;
                let data = {
                    value: action
                };

                url = '/api/settings/simbanks/' + action;

                if (id) {
                    data.ids = [id]
                } else {

                    data.ids = this.items.filter(v => v.checked).map(v => v.id);
                }

                axios.patch(url, data).then(response => {
                    if (!response.data.errorCode) {
                        this.getSimbanks();
                        this.$toast('Симбанк обновлен успешно');
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
        },
        watch: {
            itemsPerPage: function (val) {
                this.$cookies.set('proxies_list_per_page', val, '31d');
            }
        },
        mounted() {
            let itemsPerPage = this.$cookies.get('proxies_list_per_page');
            if (itemsPerPage && parseInt(itemsPerPage) > 0)
                this.itemsPerPage = itemsPerPage;
            this.getSimbanks();
        }
    }
</script>
