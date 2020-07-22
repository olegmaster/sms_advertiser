<template>
  <div>
    <page-title :heading=heading :subheading=subheading :icon=icon></page-title>

    <b-card title="Example" class="main-card mb-4">
      <div>
        <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>
          <b-table striped="true" bordered="true" outlined="true" hover="true" foot-clone="true" :items="items" :fields="fields">
            <template v-slot:cell(checkbox_field)="row">
              <b-form-checkbox v-model="row.detailsShowing" @change="row.toggleDetails">
              </b-form-checkbox>
            </template>
          </b-table>
      </div>
      <b-button class="mr-2 mb-2" @click="isLoading=!isLoading;"> Загрузка </b-button>
    </b-card>
  </div>
</template>

<script>

  import PageTitle from "../../../../Layout/Components/PageTitle.vue";
  import VueElementLoading from 'vue-element-loading'

  export default {
    components: {
      PageTitle,
      VueElementLoading
    },
    data: () => ({
      heading: 'Настройки',
      subheading: 'Прокси сервера',
      icon: 'pe-7s-home icon-gradient bg-warm-flame',
      proxies : [],
      fields: [ 'checkbox_field', 'first_name', 'last_name', 'age' ],
      items: [
        { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { age: 89, first_name: 'Geneva', last_name: 'Wilson' }
      ],
      allSelected: false,
      isLoading: false
    }),
  }
</script>
