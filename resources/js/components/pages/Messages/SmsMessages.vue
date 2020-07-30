<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>

    <b-card title="" class="main-card mb-4">
      <div>
        <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>

        <b-card title="Фильтр" class="main-card mb-2">

          <p>With supporting text below as a natural lead-in to additional content.</p>
            <p class="mb-0">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.</p>
          <div class="d-block text-right card-footer">
            <b-button class="btn btn-shadow btn-hover-shine btn-transition btn-secondary" >Сбросить фильтр</b-button>
            <vue-ladda data-style="zoom-out" button-class="btn btn-primary btn-shadow btn-hover-shine btn-transition" :loading="filterButton.loading" :progress="filterButton.progress" @click="filter()">Применить</vue-ladda>
          </div>
        </b-card>


        <div class="container-fluid">
          <div class="row">
            <div class="col" align="left">
              <div>
                <h5>Количество записей: {{itemsTotalCount}}</h5>
              </div>
            </div>
            <div class="col-md-auto">
            </div>
            <div class="col-md-auto">
              <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions" @change="page = 1; getSmsList()"></b-form-select>
            </div>
          </div>
        </div>

        <b-table striped bordered outlined hover fixed :items="items" :fields="fields">

          <template v-slot:cell(thematics_name)="data">
            {{data.item.advertising_campaign.thematics.name}}
          </template>

          <template v-slot:cell(advertising_campaign_name)="data">
            {{data.item.advertising_campaign.name}}
          </template>

          <template v-slot:cell(user_name)="data">
            {{data.item.advertising_campaign.user.name}}
          </template>

          <template v-slot:table-colgroup="scope">
            <col style="width: 30px">
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
          </template>

        </b-table>

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-auto">
            </div>
            <div class="col-md-auto">
            </div>
            <div class="col">

            </div>

            <div class="col-md-auto">
              <v-pagination v-model="page" @input="getSmsList()" :length="pagesCount" :total-visible="10"></v-pagination>
            </div>
          </div>
        </div>
      </div>

    </b-card>


  </div>
</template>

<script>

  import PageTitle from "../../../Layout/Components/PageTitle.vue";
  import VueElementLoading from 'vue-element-loading'
  import vSelect from 'vue-select'
  import {library} from '@fortawesome/fontawesome-svg-core'
  import { faStar, faPlus } from '@fortawesome/free-solid-svg-icons'
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
  library.add( faStar, faPlus );

  import VueLadda from '../../../assets/components/ladda-loading/src/vue-ladda'

  const duration = 2000;

  export default {
    components: {
      PageTitle,
      VueElementLoading,
      vSelect,
      'font-awesome-icon': FontAwesomeIcon,
      VueLadda
    },
    data: () => ({
      heading: 'База сообщений',
      subheading: 'SMS сообщения',
      icon: 'pe-7s-home icon-gradient bg-warm-flame',
      fields: [
        {key:'id', label:'ID'},
        {key:'text', label:'Текст сообщения'},
        {key:'thematics_name', label:'Тематика'},
        {key:'advertising_campaign_name', label:'Рекламная компания'},
        {key:'sent_count', label:'Кол. отправленных'},
        {key:'clicks_count', label:'Кол. переходов'},
        {key:'used_simcards_count', label:'Кол. исп. симкарт'},
        {key:'created_at', label:'Дата создания'},
        {key:'user_name', label:'Владелец'},
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
      filterButton: {
        loading: false,
        progress: 0
      }
    }),
    computed: {
      checkedItemsCount() {
        return this.items.filter(v=>v.checked).length;
      }
    },
    methods: {
      getSmsList()
      {
        let vm = this;
        this.allSelected = false;
        this.isLoading = true;
        let new_items = [];
        let url = '/api/sms-mms-messages/sms/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
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
      filter()
      {
        this.filterButton.loading = true;
        updateButtonProgress(duration, this.filterButton);
        let vm = this;
        setTimeout(function () { vm.filterButton.loading = false;}, duration);
      }
    },

    watch: {
      itemsPerPage : function(val)
      {
        this.$cookies.set('sms_messages_list_per_page', val, '31d');
      }
    },
    mounted()
    {
      let itemsPerPage = this.$cookies.get('sms_messages_list_per_page');
      if (itemsPerPage && parseInt(itemsPerPage)>0)
        this.itemsPerPage = itemsPerPage;
      this.getSmsList();
    }
  }

  function updateButtonProgress(duration, button) {
    var start = null;

    function update(timestamp) {
      var delta, progress;
      if (!start) start = timestamp;
      delta = timestamp - start;
      progress = delta / duration;
      if (progress >= 1 || progress < 0) return;
      button.progress = progress;
      window.requestAnimationFrame(update);
    }

    window.requestAnimationFrame(update);
  }
</script>
