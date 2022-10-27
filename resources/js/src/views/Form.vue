<template>
    <v-card>
        <v-card-title>
          <span class="text-h5">{{ title }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>           
              <v-form
              ref="form"
              lazy-validation
            >
              <v-row v-for="field in fields" :key="field.name">
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                <v-text-field v-if="field.type == 'text' && field.name != 'email'"
                  v-model="formreturn[field.name]"
                  :label="field.name"
                  required
                  :rules="textRules"
                ></v-text-field>
                <v-text-field v-if="field.type == 'text' && field.name == 'email'"
                  v-model="formreturn[field.name]"
                  :label="field.name"
                  required
                  :rules="emailRules"
                ></v-text-field>
                <v-text-field v-if="field.type == 'number'" 
                v-model="formreturn[field.name]"
                  :label="field.name"
                  type="number"
                  required
                  :rules="numberRules"
                ></v-text-field>
                
                <v-container
                  class="px-0"
                  fluid
                  v-if="field.type == 'json'"
                >
                
                <p>{{field.name}}</p>
                <v-row>
                    <v-col cols="2" v-for="content in field.contents" :key="content.name">
                      <v-checkbox 
                        :v-model="formreturn[field.name]" 
                        :value="content.name" 
                        :label="content.name"
                        :rules="checkboxRules"
                      ></v-checkbox>
                  </v-col>
                </v-row>
                </v-container>
                  
                  <v-select v-if="field.type == 'related'"
                  v-model="formreturn[field.name]"
                    :items="related[field.name]"
                    :label="field.name"
                    item-text="name"
                    item-value="id"
                    return-object
                    required
                    :rules="relatedRules"
                  ></v-select>

                  
                  <v-radio-group  
                    v-if="field.type == 'bool'" 
                    v-model="formreturn[field.name]"
                    :rules="boolRules"
                    required
                  >
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
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="closeModal(modalname)"
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
            let textRules= [
              v => !!v || 'Campo e obrigatorio',
            ]
            let emailRules= [
              v => !!v || 'E-mail é obrigatorio',
              v => /.+@.+\..+/.test(v) || 'E-mail invalido',
            ]
            let relatedRules=[v => !!v || 'Campo e obrigatorio']
            let numberRules= [
              v => !!v || 'Campo e obrigatorio',
            ]
            let boolRules= [
              v => v >= 0 || 'Campo e obrigatorio'
            ]
            let checkboxRules= [
              v => v == 0 || 'Campo e obrigatorio'
            ]
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
              if (field.type =='json'){
                formreturn[field.name] = []
                field.content.forEach((content) => {
                  formreturn[field.name][content.name].checked = false
                })
              }
            })
          }
          return{
            related: [],
            formreturn: formreturn,
            textRules:textRules,
            emailRules:emailRules,
            relatedRules:relatedRules,
            numberRules:numberRules,
            boolRules:boolRules,
          }
        },
        methods: {
          closeModal(){
            this.$emit('closemodal', this.modalname)
          },
          save(){
           if(this.$refs.form.validate()){
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
                  case 'json':
                    fieldvalues[field.name] = JSON.stringify(this.formreturn[field.name])
                    break
                  default:
                    fieldvalues[field.name] = this.formreturn[field.name]
                    break
                }
              })
              console.log(this.formreturn)
              this.$emit('save', fieldvalues, this.modalname)
            }
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