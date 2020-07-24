<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>

    <b-card title="" class="main-card mb-4">
      <div>
          <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>

          <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-auto">
                      <b-button size="sm" class="mr-2 mb-2 btn-shadow btn-hover-shine btn-transition" variant="primary" @click="selectAll()">
                          Выбрать все
                      </b-button>
                      <b-dropdown dropup no-flip text="Действия над выбранными" class="mb-2 mr-2" variant="primary" ref="dropdown0" :disabled="checkedItemsCount==0" >
                          <div class="dropdown-menu-header">
                              <div class="dropdown-menu-header-inner bg-secondary">
                                  <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                  <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6></div>
                              </div>
                          </div>
                          <button type="button" tabindex="0" class="dropdown-item" @click="setProxiesStatus(null, 1)">Активировать</button>
                          <button type="button" tabindex="1" class="dropdown-item" @click="setProxiesStatus(null, 0)">Деактивировать</button>
                          <button type="button" tabindex="2" class="dropdown-item" @click="onDeleteProxies()">Удалить</button>
                          <button type="button" tabindex="2" class="dropdown-item">Проверить</button>
                      </b-dropdown>
                  </div>
                  <div class="col" align="left">
                      <div>
                        <h5>Количество записей: {{itemsTotalCount}}</h5>
                      </div>
                  </div>
                  <div class="col-md-auto">
                      <button type="button" @click="showAddProxiesModal=true" class="btn-shadow d-inline-flex align-items-center btn btn-success" >
                          <font-awesome-icon class="mr-2" icon="plus"/>
                          Добавить прокси
                      </button>
                  </div>
                  <div class="col-md-auto">
                      <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions" @change="page = 1; getProxies()"></b-form-select>
                  </div>
              </div>
          </div>

          <b-table striped bordered outlined hover fixed :items="items" :fields="fields">

            <template v-slot:cell(checkbox_field)="data">
                <b-form-checkbox v-model="data.item.checked"></b-form-checkbox>
            </template>

            <template v-slot:cell(operations)="data">

                <b-dropdown dropup no-flip text="Действия" class="mb-2 mr-2" variant="primary" block :ref="'dropdown_'+data.item.id">
                    <div class="dropdown-menu-header">
                        <div class="dropdown-menu-header-inner bg-secondary">
                            <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                            <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6></div>
                        </div>
                    </div>
                    <button type="button" tabindex="0" class="dropdown-item" v-show="data.item.status==0" @click="setProxiesStatus(data.item.id, 1)">Активировать</button>
                    <button type="button" tabindex="1" class="dropdown-item" v-show="data.item.status==1" @click="setProxiesStatus(data.item.id, 0)">Деактивировать</button>
                    <button type="button" tabindex="1" class="dropdown-item" @click="onDeleteProxies(data.item.id, 0)">Удалить</button>
                    <button type="button" tabindex="2" class="dropdown-item" v-show="data.item.check_state==0">Проверить</button>
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
                      <b-dropdown dropup no-flip text="Действия над выбранными" class="mb-2 mr-2" variant="primary" ref="dropdown1" :disabled="checkedItemsCount==0" >
                          <div class="dropdown-menu-header">
                              <div class="dropdown-menu-header-inner bg-secondary">
                                  <div class="menu-header-image opacity-5 dd-header-bg-2"></div>
                                  <div class="menu-header-content"><h6 class="menu-header-title">Действия</h6></div>
                              </div>
                          </div>
                          <button type="button" tabindex="0" class="dropdown-item" @click="setProxiesStatus(null, 1)">Активировать</button>
                          <button type="button" tabindex="1" class="dropdown-item" @click="setProxiesStatus(null, 0)">Деактивировать</button>
                          <button type="button" tabindex="2" class="dropdown-item" @click="onDeleteProxies()">Удалить</button>
                          <button type="button" tabindex="2" class="dropdown-item">Проверить</button>
                      </b-dropdown>
                  </div>
                  <div class="col-md-auto">
                      <button type="button" v-b-modal.modal-add-proxy class="btn-shadow d-inline-flex align-items-center btn btn-success">
                          <font-awesome-icon class="mr-2" icon="plus"/>
                          Добавить прокси
                      </button>
                  </div>
                  <div class="col">

                  </div>

                  <div class="col-md-auto">
                      <v-pagination v-model="page" @input="getProxies()" :length="pagesCount" :total-visible="10"></v-pagination>
                  </div>
              </div>
          </div>
      </div>

    </b-card>

    <b-modal id="modal-add-proxy" hide-backdrop  title="Добавить прокси" >
      <p class="my-4">Vertically centered modal!</p>
        <b-form-group label="Individual radios">
            <b-form-radio v-model="selected" name="some-radios" value="A">Option A</b-form-radio>
            <b-form-radio v-model="selected" name="some-radios" value="B">Option B</b-form-radio>
        </b-form-group>
    </b-modal>


  </div>
</template>

<script>

  import PageTitle from "../../../../Layout/Components/PageTitle.vue";
  import VueElementLoading from 'vue-element-loading'
  import vSelect from 'vue-select'
  import {library} from '@fortawesome/fontawesome-svg-core'
  import { faStar, faPlus } from '@fortawesome/free-solid-svg-icons'
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
  library.add( faStar, faPlus );
  import AddProxiesModal from "./modals/AddProxiesModal";
  export default {
    components: {
        PageTitle,
        VueElementLoading,
        vSelect,
        'font-awesome-icon': FontAwesomeIcon,
        AddProxiesModal
    },
    data: () => ({
        heading: 'Настройки',
        subheading: 'Прокси сервера',
        icon: 'pe-7s-home icon-gradient bg-warm-flame',
        fields: [
            {key:'checkbox_field', label:''},
            {key:'id', label:'ID'},
            {key:'type', label:'Тип'},
            {key:'ip', label:'IP'},
            {key:'port', label:'Порт'},
            {key:'password', label:'password'},
            {key:'status', label:'Активный'},
            {key:'busy_by_task_id', label:'Занят под задание'},
            {key:'is_banned', label:'Забанен'},
            {key:'operations', label:'Операции'},
        ],
        itemsPerPageOptions: [
            {text: 'Показать по 10',  value: '10'},
            {text: 'Показать по 25',  value: '25'},
            {text: 'Показать по 50',  value: '50'},
            {text: 'Показать по 100', value: '100'},
            {text: 'Показать по 150', value: '150'},
            {text: 'Показать по 250', value: '250'},
            {text: 'Показать по 500', value: '500'}
            ],
        items: [],
        itemsPerPage : 25,
        allSelected: false,
        isLoading: false,
        page: 1,
        pagesCount :1,
        itemsTotalCount : 0,
        showAddProxiesModal: false
    }),
    computed: {
          checkedItemsCount() {
              return this.items.filter(v=>v.checked).length;
          }
    },
    methods: {
        getProxies()
        {
            let vm = this;
            this.allSelected = false;
            this.isLoading = true;
            let new_items = [];
            let url = '/api/settings/proxies/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
            axios.get(url).then( response => {
              if (!response.data.errorCode )
              {
                  new_items = response.data.data.items;
                  this.pagesCount = Math.ceil(response.data.data.stat.itemsCount / this.itemsPerPage);
                  vm.itemsTotalCount = response.data.data.stat.itemsCount;
                  for (let i in  new_items )
                    new_items[i].checked = false;
                vm.items = new_items;
              }
              vm.isLoading = false;
            }).catch( responce => {
              vm.isLoading = false;
            });
        },

        setProxiesStatus(id = null, status = null)
        {
            this.hideDropDown(id);
            this.isLoading = true;
            let vm = this;
            let url;
            let data = {
                value:status
            };

            if (id)
            {
                url = '/api/settings/proxies/' + id + '/status/';
            }
            else
                {
                    url = '/api/settings/proxies/status/';
                    data.ids = this.items.filter(v=>v.checked).map(v=>v.id);
                }

            axios.patch(url,data).then( response => {
                if (!response.data.errorCode )
                {
                    this.getProxies();
                } else
                    this.isLoading = false;
            }).catch( responce => {
                this.isLoading = false;
            });
        },

        hideDropDown(id=null)
        {
            if (id)
                this.$refs['dropdown_'+id].hide(true);
            else {
                this.$refs['dropdown0'].hide(true);
                this.$refs['dropdown1'].hide(true);
            }

        },

        selectAll()
        {
            this.allSelected = !this.allSelected;
            for (let i in  this.items )
                this.items[i].checked = this.allSelected;
        },
        deleteProxies(id = null)
        {
            this.hideDropDown(id);
            this.isLoading = true;
            let vm = this;
            let url;
            let data = {
                value:1
            };

            if (id)
            {
                url = '/api/settings/proxies/' + id + '/';
            }
            else
            {
                url = '/api/settings/proxies/';
                data.ids = this.items.filter(v=>v.checked).map(v=>v.id);
            }

            axios.delete(url,{data}).then( response => {
                if (!response.data.errorCode )
                {
                    this.page = 1;
                    this.getProxies();
                } else
                    this.isLoading = false;
            }).catch( responce => {
                this.isLoading = false;
            });
        },
        onDeleteProxies(id = null)
        {
            let title = !id ? 'Вы уверены в том что хотите удалить выделенные прокси?' : 'Вы уверены в том что хотите удалить прокси?';
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
                hideBackdrop : true
            })
                .then(value => {
                    if ( value )
                        this.deleteProxies(id);
                })
                .catch(err => {

                })
        },
        showMsgBoxTwo() {

        },
        onDeleteCancel()
        {

        },
        onDeleteOK()
        {

        }


    },
    watch: {
        itemsPerPage : function(val)
        {
            this.$cookies.set('proxies_list_per_page', val, '31d');
        }
    },
    mounted()
    {
      let itemsPerPage = this.$cookies.get('proxies_list_per_page');
      if (itemsPerPage && parseInt(itemsPerPage)>0)
          this.itemsPerPage = itemsPerPage;
      this.getProxies();
    }
  }
</script>
