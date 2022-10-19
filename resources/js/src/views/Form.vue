<template>
    <v-card>
        <v-card-title>
          <span class="text-h5">{{ title }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row v-for="field in fields" :key="field.name">
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field v-if="field.type == 'text'"
                  v-model="formreturn[field.name]"
                  :label="field.name"
                  required
                ></v-text-field>
                <v-text-field v-if="field.type == 'number'" 
                v-model="formreturn[field.name]"
                  :label="field.name"
                  type="number"
                  required
                ></v-text-field>
                
                <v-select v-if="field.type == 'related'"
                v-model="formreturn[field.name]"
                  :items="related[field.name]"
                  :label="field.name"
                  item-text="name"
                  item-value="id"
                  return-object
                  required
                ></v-select>

                
                <v-radio-group  v-if="field.type == 'bool'" 
                v-model="formreturn[field.name]">
                  <template v-slot:label>
                    <div>{{field.name}}</div>
                  </template>
                    <v-radio
                      label="Deactive"
                      :value="0"
                    ></v-radio>
                    <v-radio
                      label="Active"
                      :value="1"
                    ></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>
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
          <v-btn
            color="blue darken-1"
            text
            @click="save()"
          >
            Save 
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
        props:['fields','modalname','registerId','type','url','title'],
        setup() {
            return {
                mdiFilter,
                mdiSort,
                mdiSortAlphabeticalAscending ,
                mdiSortAlphabeticalDescending ,
            }
        },
        created() {
            this.checkfields();
        },
        data() {
          let formreturn =[]
          
          if(this.registerId){
            axios.get(this.url+this.registerId)
              .then(response => {
                this.fields.forEach((field) => {                  
                  this.$set(formreturn, field.name, response.data[field.name]) 
                })    
              })
              .catch((err) => {
                console.log(err)
              })   
          }
          else{
            
            this.fields.forEach((field) => {
              formreturn[field.name] = ''
            })
          }
          return{
            related: [],
            formreturn: formreturn,
          }
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
          checkfields(){
            this.fields.forEach((field) => {
              if (field.type == 'related'){
                axios.get(field.url + field.description, {})
                  .then(response => {
                    this.$set(this.related, field.name, response.data.data)           
                  })
                  .catch((err) => {
                    console.log(err)
                  })               
                }                
            });        
          },
        }
    }
</script>