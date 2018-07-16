<template>
    <div>
      <div class="text-center">
        <h3>Surveys CRUD</h3>
      </div>
      <div class="pull-right">
            <div class="form-group mx-sm-6 mb-2">
              <label class="sr-only">Search</label>
              <input type="text" class="form-control" placeholder="Type to search" v-model="target" @keyup.enter="getSurveys">
            </div>
      </div>
      <div class="clearfix"></div>
      <div class="pull-left">
        <button type="button" class="btn btn-info" @click="create">
          <i class="fa fa-plus"> </i> Add Survey
        </button>
      </div>
        <b-table striped hover
        :items="surveys"
        :fields="fields"
        :no-local-sorting="true"
        @sort-changed="sortingChanged"
        >
        <template slot="actions" slot-scope="row">
          <button class="btn btn-success" @click="edit(row.item, row.index)" title="Edit">
            <i class="fa fa-edit"></i>
          </button>
          <button class="btn btn-danger" @click="remove(row.item, row.index)" title="Save">
            <i class="fas fa-trash-alt"></i>
          </button>
        </template>
        </b-table>
        <survey-edit :show="showEdit" :draft="draft" @close="close"></survey-edit>
      <div class="box-footer text-center">
          <b-pagination
            :total-rows="totalRows"
            :per-page="perPage"
            align="center"
            v-model="currentPage"
            class="my-0"
            @input="getSurveys"
            />
      </div>
    </div>
</template>

<script>
    export default {
        watch:{
            target(){
                this.getSurveys()
            }
        },
        data(){
            return{
                fields: [
                    { key: 'id', label: '#', sortable: true, 'class': 'col-10' },
                    { key: 'name', sortable: true , 'class': 'col-35'},
                    { key: 'actions', sortable: false, 'class': 'col-10'},
                ],
                surveys: [],
                perPage: null,
                currentPage: 1,
                lastPage: null,
                target: '',
                draft: {},
                currentIndex: null,
                showEdit: false,
                sortBy: 'id',
                sortDesc: true,
                totalRows: null,
                loading: false,

            }
        },
        created(){
            this.getSurveys()
        },
        methods:{
            edit(survey, index){
                this.draft = JSON.parse(JSON.stringify(survey))
                this.currentIndex = index
                this.showEdit = true
            },
            create(){
                this.draft = {
                    id: null,
                    name: '',
                }
                this.showEdit = true
            },
            getSurveys(){
                axios.get('api/survey?page=' + this.currentPage + '&search=' + this.target + '&orderBy=' + this.sortBy + '&desc=' + this.sortDesc)
                    .then(response => {
                        this.currentPage = response.data.current_page
                        this.lastPage = response.data.last_page
                        this.totalRows = response.data.total
                        this.perPage = response.data.per_page
                        this.surveys = response.data.data
                    })
                    .catch(error => {
                        Vue.toasted.show(error.message, {icon: 'exclamation-triangle', type: 'error'})
                    })
            },
            close(){
                if (this.currentIndex != null) {
                    this.surveys.splice(this.currentIndex, 1, this.draft)
                } else{
                    console.log('paso')
                    this.surveys.unshift(this.draft)
                }
                this.showEdit = false
            },
            remove(item, index){
                if (confirm('Are you sure?')) {
                    axios.delete('api/survey/' + item.id)
                        .then( response => {
                            this.surveys.splice(index, 1);
                            Vue.toasted.show(response.data.message, {icon: 'trash-alt', type: 'error'})
                        })
                        .catch(error => {
                        })

                }
            },
            sortingChanged (ctx) {
                if (ctx.sortBy) {
                    this.sortBy = ctx.sortBy
                    this.sortDesc = ctx.sortDesc
                    this.currentPage = 1
                    this.getSurveys()
                }
            },
        },
    }
</script>