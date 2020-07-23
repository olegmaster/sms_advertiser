<template>
    <div>
        <b-card title="" class="main-card mb-4">

            <!-- Main table element -->
            <b-table show-empty
                     stacked="md"
                     :items="items"
                     :fields="fields"
                     :current-page="currentPage"
                     :per-page="perPage"
                     :filter="filter"
                     :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :sort-direction="sortDirection"
                     @filtered="onFiltered"
            >
                <template slot="id" slot-scope="row">{{row.id}}</template>
                <template slot="name" slot-scope="row">{{row.name}}</template>
                <template slot="created_at" slot-scope="row">{{row.created_at}}</template>
                <template slot="status" slot-scope="row">{{row.status}}</template>
                <template slot="actions" slot-scope="row"></template>

            </b-table>

            <b-row>
                <b-col md="6" class="my-1">
                    <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0"/>
                </b-col>
            </b-row>
        </b-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: [],
                fields: [
                    {key: 'id', label: 'ID'},
                    {key: 'name', label: 'Название тематики', sortable: true, 'class': 'text-center'},
                    {key: 'created_at', label: 'Дата создания'},
                    {key: 'status', label: 'Активен'},
                    {key: 'author', label: 'Автор'},
                    {key: 'actions', label: 'Операции'},
                ],
                currentPage: 1,
                perPage: 5,
                totalRows: 0,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                modalInfo: {title: '', content: ''}
            }
        },

        mounted() {
            this.fetchThematics()
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
        methods: {
            fetchThematics(page) {
                return axios.get('/api/settings/thematics/').then(result => {
                    console.log(result.data.data)
                    this.items = result.data.data;
                    this.totalRows = this.items.length
                });
            },
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
