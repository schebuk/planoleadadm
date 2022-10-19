<template>
    <v-card>
        <v-card-title>
          <span class="text-h5">Trash list</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-simple-table>
              <thead>
                  <tr>
                      <th v-for="column in trashFields" :key="column.name">
                          {{column.name}}
                      </th>
                  </tr>
              </thead>
              <tr v-for="user in trashData" :key="user.id">
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.telephone}}</td>
                <td>{{user.user}}</td>                
              </tr>
          </v-simple-table>
            
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="closeModal('userRegister')"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
</template>

<script>
    import {
        mdiFilter,
        mdiSort,
        mdiSortAlphabeticalAscending ,
        mdiSortAlphabeticalDescending ,
    } from '@mdi/js'
    export default{
        emits: ['closemodal','save'],
        props:['trashData','trashFields','modalname'],
        setup() {
            return {
                mdiFilter,
                mdiSort,
                mdiSortAlphabeticalAscending ,
                mdiSortAlphabeticalDescending ,
            }
        },
        created() {
        },
        data() {
        },
        methods: {
          closeModal(){
            this.$emit('closemodal', this.modalname)
          },
          save(){
            let fieldvalues = []
            if (this.registerId){
              fieldvalues['id'] = this.registerId
            }
            this.fields.forEach((field) => {
              switch (field.type){
                case 'related':              
                  fieldvalues[field.name] = this.formreturn[field.name].id
                  if (!this.formreturn[field.name].id){
                    fieldvalues[field.name] = this.formreturn[field.name]
                  }
                  break
                default:
                  fieldvalues[field.name] = this.formreturn[field.name]
                  break
              }
            })
            this.$emit('save', fieldvalues, this.modalname)
          },
        }
    }
</script>