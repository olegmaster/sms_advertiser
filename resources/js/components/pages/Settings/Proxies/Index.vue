<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>

    <b-card title="" class="main-card mb-4">
      <div>
          <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>
          <b-button class="mr-2 mb-2 btn-shadow btn-hover-shine btn-transition" variant="primary" @click="selectAll()">
              Выбрать все
          </b-button>

          Показать по
          <v-select :options="options" v-model="selectedOption"></v-select>
          {{selectedOption}}



          <b-table striped bordered outlined hover fixed :items="items" :fields="fields">

            <template v-slot:cell(checkbox_field)="data">
              <b-form-checkbox v-model="data.item.checked"></b-form-checkbox>
            </template>
            <template v-slot:table-colgroup="scope">
              <col :style="{ width: '25px'}">
            </template>

          </b-table>
      </div>

    </b-card>

  </div>
</template>

<script>

  import PageTitle from "../../../../Layout/Components/PageTitle.vue";
  import VueElementLoading from 'vue-element-loading'
  import vSelect from 'vue-select'

  export default {
    components: {
      PageTitle,
      VueElementLoading,
      vSelect
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
      items: [],
      allSelected: false,
      isLoading: false,
      options : [
          /*
          {label: 'Показать по 10', value: '10'},
          {label: 'Показать по 25', value: '25'},
          {label: 'Показать по 50', value: '50'},
          {label: 'Показать по 100', value: '100', selected: true},
          {label: 'Показать по 150', value: '150'},
          {label: 'Показать по 250', value: '250'},
          {label: 'Показать по 500', value: '500'},
          */
          10,25,50,100,150,250,500
      ],
      selectedOption : 25,

    }),
    mounted() {
      this.getProxies();
    },
    methods: {
      getProxies() {
        let vm = this;
        this.isLoading = true;
        let new_items = [];
        axios.get('/api/settings/proxies/').then( response => {
          if (response.data.status === 'ok')
          {
              new_items = response.data.data.items;
              for (let i in  new_items )
                new_items[i].checked = false;
            vm.items = new_items;
          }
          vm.isLoading = false;
        }).catch( responce => {
          vm.isLoading = false;
        });
      },
      selectAll() {
        this.allSelected = !this.allSelected;
        for (let i in  this.items )
          this.items[i].checked = this.allSelected;
        console.log(this.allSelected, this.items);
      }
    },

  }
</script>
