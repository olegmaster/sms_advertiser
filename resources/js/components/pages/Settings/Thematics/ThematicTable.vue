<template>
    <div>
        <b-card title="" class="main-card mb-4">

            <!-- Main table element -->
            <b-table striped hover show-empty bordered
                     stacked="md"
                     :items="thematics"
                     :fields="fields"
                     :current-page="currentPage"
                     :per-page="perPage"
                     :filter="filter"
                     :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :sort-direction="sortDirection"
                     @filtered="onFiltered"
                     :busy="busyState"
            >
                <template v-slot:cell(checkbox_field)="data">
                    <b-form-checkbox v-model="data.item.checked"></b-form-checkbox>
                </template>
                <template v-slot:table-busy>
                    <div class="text-center text-danger my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Загрузка...</strong>
                    </div>
                </template>
                <template slot="id" slot-scope="row">{{row.id}}</template>
                <template slot="name" slot-scope="row"><b>{{row.name}}</b></template>
                <template slot="created_at" slot-scope="row">{{row.created_at}}</template>
                <template slot="status" slot-scope="row">Hello World</template>
                <template slot="username" slot-scope="row">{{row.username}}</template>
                <template v-slot="actions" slot-scope="row">
                    <b-button variant="success">Редактировать</b-button>
                    <b-button variant="danger">Удалить</b-button>
                </template>

            </b-table>

            <b-row v-if="totalRows > perPage">
                <b-col md="6" class="my-1">
                    <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0"/>
                </b-col>
            </b-row>
        </b-card>
    </div>
</template>

<script>
    export default {
        props: {
            thematics: {
                type: Object,
            },
            totalRows: {
                type: Number
            },
            busyState: {
                type: Boolean
            }
        },
        data() {
            return {
                fields: [
                    {key:'checkbox_field', label:''},
                    {key: 'id', label: 'ID'},
                    {
                        key: 'name',
                        label: 'Название тематики',
                        sortable: true,
                        'class': 'text-center text-uppercase',
                        variant: 'primary'
                    },
                    {key: 'created_at', label: 'Дата создания'},
                    {
                        key: 'status', label: 'Активен', formatter: value => {
                            return value === 1 ? 'Да' : 'Нет'
                        }
                    },
                    {key: 'username', label: 'Автор'},
                ],
                currentPage: 1,
                perPage: 20,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                modalInfo: {title: '', content: ''}
            }
        },

        computed: {
            sortOptions() {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return {text: f.label, value: f.key}
                    })
            }
        },
        filters: {
            uppercase(value) {
                return 33
            }
        },
        methods: {
            info(item, index, button) {
                this.modalInfo.title = `Row index: ${index}`
                this.modalInfo.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', 'modalInfo', button)
            },
            resetModal() {
                this.modalInfo.title = ''
                this.modalInfo.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        }
    }
</script>
