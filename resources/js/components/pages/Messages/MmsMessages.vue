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
                      label="Тип MMS"
                      class="mb-0"
                      :disabled="isLoading"
              >
                <b-form-radio-group
                        v-model="filter.destination_type"
                        :options="radioOptions1"
                        name="radios-stacked"
                        size="sm"
                ></b-form-radio-group>
              </b-form-group>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b-form-group
                      class="mb-0"
                      label="Текст MMS сообщения"
                      :disabled="isLoading"
                      :state="!$v.filter.text.$dirty || (!$v.filter.text.$invalid && !filter.text.trim()) ? null : !$v.filter.text.$invalid"
                      invalid-feedback="Введите текст не менее 3х символов"
              >
                <b-form-input
                        v-model="$v.filter.text.$model"
                        :state="!$v.filter.text.$dirty || (!$v.filter.text.$invalid && !filter.text.trim()) ? null : !$v.filter.text.$invalid"
                        id="ip"
                        placeholder="Введите любой текст"
                        size="sm"

                ></b-form-input>
              </b-form-group>
            </div>
            <div class="col">
              <b-form-group
                      class="mb-0"
                      label="ID MMS сообщения"
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
              <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions" @change="page = 1; getSmsList()"></b-form-select>
            </div>
          </div>
        </div>


        <b-table striped bordered outlined hover fixed :items="items" :fields="fields">

          <template v-slot:cell(text)="data">
            <div v-b-popover.hover.right="data.item.text" title="Полный текст сообщения">
              <i class="icon icon-lg pe-7s-info text-primary"/> &nbsp; {{data.item.text.split(' ').splice(0, 5).join(' ')}} <strong>...</strong>
            </div>

          </template>

          <template v-slot:cell(media)="row">
            <button type="button" @click="row.toggleDetails" class="btn btn-success btn-shadow btn-hover-shine btn-transition d-inline-flex align-items-center " size="sm" >
              <font-awesome-icon class="" icon="photo-video"/>
              Показать картинки
            </button>
          </template>

          <template v-slot:row-details="row">
            <b-card>
              <slick ref="slick" :options="slickOptions">
                <div v-for="(mms, index) in row.item.media_files_group.mms_media_files ">
                  <div class="slider-item"><a :href="mms.file_path" target="_blank"><img :src="mms.file_path" style="border: 1px solid lightgray; width: 100%; height: auto; object-fit: contain"></a></div>
                </div>
                <div v-if="!row.item.media_files_group.mms_media_files.length">
                  <div class="slider-item">Нет картинок</div>
                </div>
              </slick>
            </b-card>
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
            <div class="col">
            </div>
            <div class="col-md-auto" align="right">
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
  import { faStar, faPlus, faPhotoVideo } from '@fortawesome/free-solid-svg-icons'
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
  library.add( faStar, faPlus, faPhotoVideo );
  import { validationMixin } from "vuelidate";
  import { required, requiredIf, helpers, minLength, ipAddress, numeric, between,minValue } from "vuelidate/lib/validators";
  import Slick from 'vue-slick';


  import VueLadda from '../../../assets/components/ladda-loading/src/vue-ladda'

  const duration = 4000;

  export default {
    components: {
      PageTitle,
      VueElementLoading,
      vSelect,
      'font-awesome-icon': FontAwesomeIcon,
      VueLadda,
      Slick
    },
    data: () => ({
      heading: 'База сообщений',
      subheading: 'MMS сообщения',
      icon: 'pe-7s-home icon-gradient bg-warm-flame',
      fields: [
        {key:'id', label:'ID'},
        {key:'text', label:'Текст сообщения'},
        {key:'media', label:'Медиа'},
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
        destination_type: -1,
        text: '',
        obj_id: '',
        thematics_id : 0
      },
      radioOptions1 :[
        { text: 'Все', value: -1 },
        { text: 'Рекламные MMS', value: 1 },
        { text: 'MMS тон 1', value: 2 },
        { text: 'MMS отправляемые после прослушивания голосового сообщения', value: 3 }
      ],
      thematicsOptions : [
        {text: 'Все',  value: 0}
      ],
      slickOptions: {
        className: "center",
        centerMode: false,
        infinite: true,
        centerPadding: "60px",
        slidesToShow: 3,
        speed: 500,
        dots: true,
      },

    }),
    validations: {
      filter: {
        destination_type: {
          required
        },
        text: {
          minLength: minLength(3)
        },
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

      getSmsList()
      {
        let vm = this;
        this.isLoading = true;
        let new_items = [];
        let url = '/api/sms-mms-messages/mms/?page=' + this.page + '&itemsPerPage=' + this.itemsPerPage;
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
        this.getSmsList();
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
        this.getSmsList();
      },
      next() {
        this.$refs.slick.next();
      },

      prev() {
        this.$refs.slick.prev();
      },

      reInit() {
        this.$nextTick(() => {
          this.$refs.slick.reSlick();
        });
      },

    },
    watch: {
      itemsPerPage : function(val)
      {
        this.$cookies.set('sms_messages_list_per_page', val, '31d');
      },
      isLoading: function(val)
      {
        if (this.withFilter)
          this.filterButton.loading = val;
      }
    },
    mounted()
    {
      let itemsPerPage = this.$cookies.get('sms_messages_list_per_page');
      if (itemsPerPage && parseInt(itemsPerPage)>0)
        this.itemsPerPage = itemsPerPage;
      this.getSmsList();
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
