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
                                        @click="activateDomain(null, 1)">Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item"
                                        @click="activateDomain(null, 0)">Деактивировать
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item" @click="banDomain(null, 1)">
                                    Забанить
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item" @click="banDomain(null, 0)">
                                    Разбанить
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item" @click="freezeDomain(null, 1)">
                                    Заморозить
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item" @click="freezeDomain(null, 0)">
                                    Разморозить
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item" @click="onDeleteDomains(null)">
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
                            <button type="button" @click="showAddDomainModal=true"
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить домен
                            </button>
                        </div>
                        <div class="col-md-auto">
                            <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions"
                                           @change="page = 1; getDomains()"></b-form-select>
                        </div>
                    </div>
                </div>

                <b-table striped bordered outlined hover fixed :items="items" :fields="fields">

                    <template v-slot:cell(checkbox_field)="data">
                        <b-form-checkbox v-model="data.item.checked"></b-form-checkbox>
                    </template>

                    <template v-slot:cell(is_banned)="data">
                        <div v-show="data.item.is_banned==1" class="text-success">Да</div>
                        <div v-show="data.item.is_banned==0" class="text-danger">Нет</div>
                    </template>

                    <template v-slot:cell(status)="data">
                        <div v-show="data.item.status==1" class="text-success">Да</div>
                        <div v-show="data.item.status==0" class="text-danger">Нет</div>
                    </template>

                    <template v-slot:cell(is_frozen)="data">
                        <div v-show="data.item.is_frozen==1" class="text-success">Да</div>
                        <div v-show="data.item.is_frozen==0" class="text-danger">Нет</div>
                    </template>

                    <template v-slot:cell(statistics)="data">
                        <b-button :id="`popover-1-${data.item.id}`" variant="primary">Инфо</b-button>
                        <b-popover :target="`popover-1-${data.item.id}`" triggers="hover focus">
                            <template v-slot:title>
                                <table class="table b-table table-striped table-hover table-bordered border b-table-fixed">
                                    <tr role="row">
                                        <td>Общее количество отправленных SMS</td>
                                        <td>{{data.item.all_send_count}}</td>
                                    </tr >
                                    <tr role="row">
                                        <td>Количество отправленных за день</td>
                                        <td>{{data.item.cur_day_count}}</td>
                                    </tr>
                                    <tr role="row">
                                        <td>Количество отправленных за неделю</td>
                                        <td>{{data.item.cur_week_count}}</td>
                                    </tr>
                                    <tr role="row">
                                        <td>Количество отправленных за месяц</td>
                                        <td>{{data.item.cur_month_count}}</td>
                                    </tr>
                                    <tr role="row">
                                        <td>Текущее количество отправленных до лимита</td>
                                        <td>{{data.item.spam_limit - data.item.all_send_count}}</td>
                                    </tr>
                                    <tr role="row">
                                        <td>лимит</td>
                                        <td>{{data.item.spam_limit}}</td>
                                    </tr>
                                    <tr role="row">
                                        <td>Количество часов заморозки</td>
                                        <td>{{data.item.freeze_hours}}</td>
                                    </tr>
                                </table>
                            </template>
                        </b-popover>
                    </template>

                    <template v-slot:cell(frozen_on)="data">
                        <div v-show="data.item.is_frozen==1">{{data.item.frozen_on}}</div>
                    </template>


                    <template v-slot:cell(operations)="data">

                        <b-dropdown dropup no-flip text="Действия" class="mb-2 mr-2" variant="primary" ref="dropdown0">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-secondary">
                                    <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                    <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6></div>
                                </div>
                            </div>
                            <button type="button" tabindex="0" class="dropdown-item" @click="activateDomain(data.item.id, 1)">
                                Активировать
                            </button>
                            <button type="button" tabindex="1" class="dropdown-item" @click="activateDomain(data.item.id, 0)">
                                Деактивировать
                            </button>
                            <button type="button" tabindex="2" class="dropdown-item" @click="banDomain(data.item.id, 1)">
                                Забанить
                            </button>
                            <button type="button" tabindex="0" class="dropdown-item" @click="banDomain(data.item.id, 0)">
                                Разбанить
                            </button>
                            <button type="button" tabindex="1" class="dropdown-item" @click="freezeDomain(data.item.id, 1)">
                                Заморозить
                            </button>
                            <button type="button" tabindex="2" class="dropdown-item" @click="freezeDomain(data.item.id, 0)">
                                Разморозить
                            </button>
                            <button type="button" tabindex="1" class="dropdown-item text-primary"
                                    @click="onEditDomain(data.item)">Редактировать
                            </button>
                            <button type="button" tabindex="2" class="dropdown-item text-danger" @click="onDeleteDomains(data.item.id)">
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
                                        @click="activateDomain(null, 1)">Активировать
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item"
                                        @click="activateDomain(null, 0)">Деактивировать
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item" @click="banDomain(null, 1)">
                                    Забанить
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item" @click="banDomain(null, 0)">
                                    Разбанить
                                </button>
                                <button type="button" tabindex="1" class="dropdown-item" @click="freezeDomain(null, 1)">
                                    Заморозить
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item" @click="freezeDomain(null, 0)">
                                    Разморозить
                                </button>
                                <button type="button" tabindex="2" class="dropdown-item" @click="onDeleteDomains(null)">
                                    Удалить
                                </button>
                            </b-dropdown>
                        </div>
                        <div class="col-md-auto">
                            <button type="button" @click="showAddDomainModal=true" v-b-modal.modal-add-domain
                                    class="btn-shadow d-inline-flex align-items-center btn btn-success">
                                <font-awesome-icon class="mr-2" icon="plus"/>
                                Добавить домен
                            </button>
                        </div>
                        <div class="col">

                        </div>

                        <div class="col-md-auto">
                            <v-pagination v-model="page" @input="getDomains()" :length="pagesCount"
                                          :total-visible="10"></v-pagination>
                        </div>
                    </div>
                </div>
            </div>

        </b-card>

        <add-domain-modal v-model="showAddDomainModal" @add-success="getDomains()"></add-domain-modal>
        <edit-domain-modal v-model="showEditDomainModal" :form="domainToEdit"
                           @edit-success="getDomains()"></edit-domain-modal>


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
    import AddDomainModal from "./modals/AddDomainModal";
    import EditDomainModal from "./modals/EditDomainModal";

    export default {
        components: {
            PageTitle,
            VueElementLoading,
            vSelect,
            'font-awesome-icon': FontAwesomeIcon,
            AddDomainModal,
            EditDomainModal
        },
        data: () => ({
            heading: 'Настройки',
            subheading: 'Редиректы и домены',
            icon: 'pe-7s-home icon-gradient bg-warm-flame',
            fields: [
                {key: 'checkbox_field', label: ''},
                {key: 'id', label: 'ID'},
                {key: 'domain', label: 'Название домена'},
                {key: 'is_banned', label: 'Забанен'},
                {key: 'status', label: 'Активный'},
                {key: 'is_frozen', label: 'Заморожен'},
                {key: 'frozen_on', label: 'Дата разморозки'},
                {key: 'spam_limit', label: 'Лимит по рассылкам'},
                {key: 'current_send_count', label: 'Кол. тек. отпр. SMS до лимита'},
                {key: 'statistics', label: 'Статистика'},
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
            showAddDomainModal: false,
            showEditDomainModal: false,
            domainToEdit: {
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
            getDomains() {
                let vm = this;
                this.allSelected = false;
                this.isLoading = true;
                let new_items = [];
                let url = '/api/settings/domains/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
                axios.get(url).then(response => {
                    console.log(response);
                    if (!response.data.errorCode) {
                        new_items = response.data.data.items;
                        this.pagesCount = Math.ceil(response.data.data.stat.itemsCount / this.itemsPerPage);
                        vm.itemsTotalCount = response.data.data.stat.itemsCount;
                        for (let i in new_items) {
                            new_items[i].checked = false;
                            let dateTime = new_items[i].frozen_on.split(' ');
                            new_items[i].frozen_on = dateTime[0]
                            dateTime = new_items[i].created_at.split(' ');
                            new_items[i].created_at = dateTime[0]
                        }

                        vm.items = new_items;
                    }
                    vm.isLoading = false;
                }).catch(responce => {
                    vm.isLoading = false;
                });
            },
            onEditDomain(domain) {
                console.log(domain)
                this.domainToEdit.id = domain.id;
                this.domainToEdit.domain = domain.domain;
                this.domainToEdit.freeze_hours = domain.freeze_hours;
                this.domainToEdit.spam_limit = domain.spam_limit;
                console.log('edit', this.domainToEdit);
                this.showEditDomainModal = true;
            },
            banDomain(id = null, status = null) {
                if (status === 1)
                    this.updateDomain(id, 3);
                else
                    this.updateDomain(id, 4);
            },
            freezeDomain(id = null, status = null) {
                if (status === 1)
                    this.updateDomain(id, 5);
                else
                    this.updateDomain(id, 6);
            },

            activateDomain(id = null, status = null) {
                if (status === 1)
                    this.updateDomain(id, 1);
                else
                    this.updateDomain(id, 2);
            },

            updateDomain(id = null, action = null) {
                this.hideDropDown(id);
                this.isLoading = true;
                let vm = this;
                let url;
                let data = {
                    value: action
                };

                url = '/api/settings/domains/' + action;

                if (id) {
                    data.ids = [id]
                } else {

                    data.ids = this.items.filter(v => v.checked).map(v => v.id);
                }

                axios.patch(url, data).then(response => {
                    if (!response.data.errorCode) {
                        this.getDomains();
                        this.$toast('Домен обновлен успешно');
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
            deleteDomain(id = null) {
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

                console.log(data)



                for(id of data.ids){
                    url = '/api/settings/domains/' + id;
                    axios.delete(url, {data}).then(response => {
                        if (!response.data.errorCode) {
                            this.page = 1;
                            this.getDomains();
                            this.$toast('Домен удален', 'danger');

                        } else
                            this.isLoading = false;
                    }).catch(responce => {
                        this.isLoading = false;
                    });
                }


            },
            onDeleteDomains(id = null) {
                let title = !id ? 'Вы уверены в том что хотите удалить выделенные домены?' : 'Вы уверены в том что хотите удалить домен?';
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
                            this.deleteDomain(id);
                    })
                    .catch(err => {

                    })
            },

            showMsgBoxTwo() {

            },
            onDeleteCancel() {

            },
            onDeleteOK() {

            }


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
            this.getDomains();
        }
    }
</script>
