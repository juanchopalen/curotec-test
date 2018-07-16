<template>
<div>
  <b-modal v-model="show" size="lg" :title="draft.id ? 'Edit' : 'Add'">
    <b-container fluid>
         <b-row class="mb-1">
           <b-col><label :class="validName ? 'label-valid' : 'label-required'">Name</label></b-col>
         </b-row>
         <b-row class="mb-1">
           <b-col><input type="text" v-model="draft.name" class="form-control"></b-col>
         </b-row>
    </b-container>
    <div slot="modal-footer" class="pull-right">
        <b-btn class="btn btn-outline-danger" @click="close"> Close</b-btn>
        <b-btn class="btn btn-outline-primary" @click="save" :disabled="!validName"> {{draft.id ? 'Update' : 'Create'}}</b-btn>
    </div>
  </b-modal>
</div>
</template>

<script>
    export default {
        props: ['show', 'draft'],
        methods:{
            close(){
                this.$emit('close')
            },
            save(){
                if (this.draft.id) {
                    this.update()
                } else{
                    this.store()
                }
                this.close()
            },
            update(){
                axios.put('/api/survey/' + this.draft.id, this.draft)
                    .then( response => {
                        Vue.toasted.show(response.data.message, {icon: 'edit', type: 'success'})
                    })
                    .catch( error => {
                        Vue.toasted.show(error.message, {icon: 'exclamation-triangle', type: 'error'})
                    })
            },
            store(){
                axios.post('/api/survey', this.draft)
                    .then( response => {
                        this.draft.id = response.data.id
                        Vue.toasted.show(response.data.message, {icon: 'plus', type: 'success'})
                    })
                    .catch( error => {
                        Vue.toasted.show(error.message, {icon: 'exclamation-triangle', type: 'error'})
                    })
            },
        },
        computed:{
            validName(){
              return this.draft.name ? this.draft.name != '' : false
            },
        }
    }
</script>

<style>
    .label-required{
        color: red ;
        font-weight: bold ;
    }
    .label-valid{
        color: green ;
        font-weight: bold ;
    }
</style>