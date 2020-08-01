<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>

    <b-card title="" class="main-card mb-4">
      <b-card class="main-card"
              header="Фильтр"
              header-bg-variant="primary"
              header-text-variant="white"
              style="max-width: 1024px;"
              footer-bg-variant="light"
              footer-border-variant="secondary"
              align="left"
              :disabled="isLoading"
      >

        <div class="container-fluid">
          <div class="row">
            <div class="col">
              <b-form-group
                      class="mb-0"
                      label="ID голосового сообщения"
                      :disabled="isLoading"
                      :state="!$v.filter.obj_id.$dirty || (!$v.filter.obj_id.$invalid && !filter.obj_id.trim()) ? null : !$v.filter.obj_id.$invalid"
                      invalid-feedback="Введите целое число больше нулья"
              >
                <b-form-input
                        v-model="$v.filter.obj_id.$model"
                        :state="!$v.filter.obj_id.$dirty || (!$v.filter.obj_id.$invalid && !filter.obj_id.trim()) ? null : !$v.filter.obj_id.$invalid"
                        size="sm"
                        placeholder="Введите целое число больше нулья"

                ></b-form-input>
              </b-form-group>
            </div>
            <div class="col">
              <b-form-group
                      class="mb-0"
                      label="Тематика"
                      :disabled="isLoading"
              >
                <b-form-select v-model="filter.thematics_id" :options="thematicsOptions" size="sm"></b-form-select>
              </b-form-group>
            </div>
          </div>
        </div>
        <template v-slot:footer>
          <div align="right" style="width: 100%" >
            <b-button class="btn btn-shadow btn-hover-shine btn-transition btn-secondary" :disabled="isLoading" @click="resetFilter()" >Сбросить фильтр</b-button> &nbsp; &nbsp;
            <vue-ladda data-style="zoom-out" button-class="btn btn-primary btn-shadow btn-hover-shine btn-transition" :disabled="isLoading" :loading="filterButton.loading" :progress="filterButton.progress" @click="doFilter()">Применить</vue-ladda>
          </div>
        </template>
      </b-card>

      <div style="padding-top: 10px">
        <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>
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
              <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions" @change="page = 1; getVoiceList()"></b-form-select>
            </div>
          </div>
        </div>


        <b-table striped bordered outlined hover fixed :items="items" :fields="fields">
          <template v-slot:cell(file_name)="row">
            {{ fileName(row.item.file_path) }}
          </template>

          <template v-slot:cell(media)="row">
            <div style="width: 100%;">
              <vuetify-audio :file="row.item.file_path"  downloadable></vuetify-audio>
            </div>
          </template>

          <template v-slot:cell(thematics_name)="data">
            {{data.item.advertising_campaign.thematics.name}}
          </template>

          <template v-slot:cell(advertising_campaign_name)="data">
            {{data.item.advertising_campaign.name}}
          </template>

          <template v-slot:cell(user_name)="data">
            {{data.item.advertising_campaign.user.name}}
          </template>

          <template v-slot:cell(created_at)="data">
            {{$getDateTime(data.item.created_at, true)}}
          </template>


          <template v-slot:table-colgroup="scope">
            <col style="width: 40px">
            <col style="width: 250px">
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
            <div class="col">
            </div>
            <div class="col-md-auto" align="right">
              <v-pagination v-model="page" @input="getVoiceList()" :length="pagesCount" :total-visible="10"></v-pagination>
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
  import { faStar, faPlus, faPhotoVideo } from '@fortawesome/free-solid-svg-icons'
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
  library.add( faStar, faPlus, faPhotoVideo );
  import { validationMixin } from "vuelidate";
  import { required, requiredIf, helpers, minLength, ipAddress, numeric, between,minValue } from "vuelidate/lib/validators";

  import VuetifyAudio from 'vuetify-audio'


  import VueLadda from '../../../assets/components/ladda-loading/src/vue-ladda'

  const duration = 4000;

  export default {
    components: {
      PageTitle,
      VueElementLoading,
      vSelect,
      'font-awesome-icon': FontAwesomeIcon,
      VueLadda,
      VuetifyAudio
    },
    data: () => ({
      heading: 'База сообщений',
      subheading: 'Голосовые сообщения',
      icon: 'pe-7s-home icon-gradient bg-warm-flame',
      fields: [
        {key:'id', label:'ID'},
        {key:'media', label:'Голосовое сообщение'},
        {key:'file_name', label:'Название файла'},
        {key:'thematics_name', label:'Тематика'},
        {key:'advertising_campaign_name', label:'Рекламная компания'},
        {key:'sent_count', label:'Кол. отправленных'},
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
      isLoading: false,
      page: 1,
      pagesCount :1,
      itemsTotalCount : 0,
      filterButton: {
        loading: false,
        progress: 0
      },
      withFilter: false,
      filter: {
        obj_id: '',
        thematics_id : 0
      },
      thematicsOptions : [
        {text: 'Все',  value: 0}
      ]

    }),
    validations: {
      filter: {
        obj_id: {
          numeric,
          minValue: minValue(1)
        },
        thematics_id: {
          required
        }
      }
    },

    computed: {
    },
    methods: {
      getThematics()
      {
        let vm = this;
        let new_items = [];
        let url = '/api/settings/thematics/?page=1&itemsPerPage=1000';
        axios.get(url).then( response => {
          if (!response.data.errorCode )
          {
            new_items = [];
            new_items.push({text: 'Все',  value: 0});
            for(let i in response.data.data.items)
              new_items.push({
                text: response.data.data.items[i].name,
                value: response.data.data.items[i].id
              });
            vm.thematicsOptions = new_items;
          }
        }).catch( responce => {
        });
      },

      getVoiceList()
      {
        let vm = this;
        this.isLoading = true;
        let new_items = [];
        let url = '/api/sms-mms-messages/voice/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
        let options = {};
        if (this.withFilter)
          options.params = {filter: JSON.stringify(this.filter)};

        axios.get(url, options).then( response => {
          if (!response.data.errorCode )
          {
            new_items = response.data.data.items;
            this.pagesCount = Math.ceil(response.data.data.stat.itemsCount / this.itemsPerPage);
            vm.itemsTotalCount = response.data.data.stat.itemsCount;
            vm.items = new_items;
          }
          vm.isLoading = false;
        }).catch( responce => {
          vm.isLoading = false;
        });
      },
      resetFilter(){
        this.withFilter = false;
        this.filter.destination_type = -1;
        this.filter.text = '';
        this.filter.obj_id = '';
        this.filter.thematics_id = 0;
        this.$v.$reset();
        this.getVoiceList();
      },
      doFilter()
      {
        this.$v.filter.$touch();
        if (this.$v.filter.$anyError) {
          return;
        }

        this.withFilter = true;
        this.filterButton.loading = true;
        updateButtonProgress(duration, this.filterButton);
        let vm = this;
        setTimeout(function () { vm.filterButton.loading = false;}, duration);
        this.getVoiceList();
      },
      fileName(file)
      {
        return file.match(/.+\/([^\.]+\.\w{1,4})$/i)[1];
      }
    },
    watch: {
      itemsPerPage : function(val)
      {
        this.$cookies.set('voice_messages_list_per_page', val, '31d');
      },
      isLoading: function(val)
      {
        if (this.withFilter)
          this.filterButton.loading = val;
      }
    },
    mounted()
    {
      let itemsPerPage = this.$cookies.get('voice_messages_list_per_page');
      if (itemsPerPage && parseInt(itemsPerPage)>0)
        this.itemsPerPage = itemsPerPage;
      this.getVoiceList();
      this.getThematics();
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
