<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>

    <b-card title="" class="main-card mb-4">
      <div>
          <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>

          <div class="container-fluid">
              <div class="row">
                  <div class="col">
                      <b-button size="sm" class="mr-2 mb-2 btn-shadow btn-hover-shine btn-transition" variant="primary" @click="selectAll()">
                          Выбрать все
                      </b-button>
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

            <template v-slot:table-colgroup="scope">
              <col :style="{ width: '25px'}">
            </template>

          </b-table>

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
                          <button type="button" tabindex="0" class="dropdown-item">Активировать</button>
                          <button type="button" tabindex="1" class="dropdown-item">Деактивировать</button>
                          <button type="button" tabindex="2" class="dropdown-item">Проверить</button>
                      </b-dropdown>
                  </div>
                  <div class="col-md-auto">
                      <v-pagination v-model="page" @input="getProxies()" :length="pagesCount" :total-visible="10"></v-pagination>
                  </div>
                  <div class="col-md-auto">
                      <button type="button" class="btn-shadow d-inline-flex align-items-center btn btn-success">
                          <font-awesome-icon class="mr-2" icon="plus"/>
                          Добавить прокси
                      </button>
                  </div>
              </div>
          </div>
      </div>

    </b-card>

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

  export default {
    components: {
        PageTitle,
        VueElementLoading,
        vSelect,
        'font-awesome-icon': FontAwesomeIcon,
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
        pagesCount :1
    }),
    mounted()
    {
        let itemsPerPage = this.$cookies.get('proxies_list_per_page');
        if (itemsPerPage && parseInt(itemsPerPage)>0)
            this.itemsPerPage = itemsPerPage;
        this.getProxies();
    },
    methods: {
        getProxies()
        {
            let vm = this;
            this.isLoading = true;
            let new_items = [];
            let url = '/api/settings/proxies/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
            axios.get(url).then( response => {
              if (response.data.status === 'ok')
              {
                  new_items = response.data.data.items;
                  this.pagesCount = Math.ceil(response.data.data.stat.itemsCount / this.itemsPerPage);
                  for (let i in  new_items )
                    new_items[i].checked = false;
                vm.items = new_items;
              }
              vm.isLoading = false;
            }).catch( responce => {
              vm.isLoading = false;
            });
          },
          selectAll()
          {
            this.allSelected = !this.allSelected;
            for (let i in  this.items )
            this.items[i].checked = this.allSelected;
          }
    },
    watch: {
        itemsPerPage : function(val)
        {
            this.$cookies.set('proxies_list_per_page', val, '31d');
        }
    }
  }
</script>
