<template>
    <v-simple-table>
        <thead>
            <tr>
                <th>
                    <v-checkbox
                        v-model="allSelelected"
                      @click="$emit('selectAll')"
                    ></v-checkbox>
                </th>
                <th v-for="column in columns" :key="column.name" :id="'th'+column.name"
                    style="cursor:pointer;">
                        <a href="javascript:void(0);" @click="sort(column.name)" style="text-decoration:none; color:black;
                        text-transform: capitalize;">
                            {{column.label}}
                            <v-icon wi v-text="mdiSort" v-if="sortOrders[column.name] == 0"></v-icon>
                            <v-icon wi v-text="mdiSortAlphabeticalAscending" v-else-if="sortOrders[column.name] > 0"></v-icon>
                            <v-icon v-text="mdiSortAlphabeticalDescending" v-else></v-icon>
                        </a>
                        <v-icon 
                            v-text="mdiFilter" 
                            style="float:right;"
                            @click="$emit('showFilter', column.name)"
                        ></v-icon>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="register in registers" :key="register.id">
                <td>
                    <v-checkbox
                        v-model="massSelelection[register.id]"
                    ></v-checkbox>
                </td>
                <td v-for="column in columns">
                    <span v-if="column.type == 'tinyint(1)'">
                        
                        <v-switch v-if="type == 'list'"
                            v-model="register[column.name]"
                            inset
                            @click="$emit('changestatus',register[column.name],register.id)"
                        ></v-switch>
                        
                        <span v-if="type == 'trash'">
                          {{register[column.name]==0?'Desativado':'ativado'}}
                        </span>
                    </span>
                    <span v-else-if="column.type == 'timestamp'">
                        {{register[column.name] | formatDate }}
                    </span>
                    <span v-else>
                        {{register[column.name]}}
                    </span>
                </td>
                <td>
                    <v-dialog
                      v-model="modal.edit[register.id]"
                      max-width="800px"
                      v-if="type == 'list'"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          icon
                          color="3D1EF9"
                          v-bind="attrs"
                          v-on="on"
                        >     
                          <v-icon 
                            v-text="mdiPencil" 
                          ></v-icon>
                          
                        </v-btn>
                      </template>
                      
                        <Form 
                            :fields="fields" 
                            :registerId="register.id" 
                            type="edit" 
                            title="Editar" 
                            :modalname="'edit_'+register.id" 
                            :url="formeditUrl" 
                            @closemodal="closeModal" 
                            @save="save">
                        </Form>
                    </v-dialog>
            
                    <v-btn 
                      v-if="type == 'list'"
                      icon 
                      color="#CCA01D"
                      @click="$emit('abredialogo','trashdialog',register.id)"
                    >                
                      <v-icon 
                        v-text="mdiTrashCan" 
                      ></v-icon>
                    </v-btn>
                    
                    <v-dialog
                      v-model="modal.trashdialog[register.id]"
                      max-width="290"
                      v-if="type == 'list'"
                    >
                      <v-card>
                        <v-card-title class="text-h5">
                          Mandar registro para lixeira?
                        </v-card-title>
            
                        <v-card-actions>
                          <v-spacer></v-spacer>
            
                          <v-btn
                            color="danger"
                            text
                            @click="$emit('fechadialogo','trashdialog',register.id)"
                          >
                            Não
                          </v-btn>
            
                          <v-btn
                            color="success"
                            text
                            @click="$emit('trash',register.id)"
                          >
                            Sim
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>  
                    
                    <v-btn
                      icon 
                      color="#89F98C"
                      @click="$emit('abredialogo','restoredialog',register.id)"
                      v-if="type == 'trash'"
                    >                
                      <v-icon 
                          v-text="mdiFileRestore" 
                        ></v-icon>
                      </v-btn>
                      <v-dialog
                        v-model="modal.restoredialog[register.id]"
                        max-width="290"
                        v-if="type == 'trash'"
                      >
                      <v-card>
                        <v-card-title class="text-h5">
                          Restaturar Registro?
                        </v-card-title>
        
                        <v-card-actions>
                          <v-spacer></v-spacer>
        
                          <v-btn
                            color="danger"
                            text
                            @click="$emit('fechadialogo','restoredialog',register.id)"
                          >
                            Não
                          </v-btn>
        
                          <v-btn
                            color="success"
                            text
                            @click="$emit('restore',register.id)"
                          >
                            Sim
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                    <v-btn
                      icon 
                      color="#CCA01D"
                      @click="$emit('abredialogo','deletedialog',register.id)"
                      v-if="type == 'trash'"
                    >       
                      <v-icon 
                        v-text="mdiDelete" 
                        color="#FF0000"
                      ></v-icon> 
                    </v-btn> 
                    <v-dialog
                        v-model="modal.deletedialog[register.id]"
                        max-width="290"
                        v-if="type == 'trash'"
                      >
                        <v-card>
                          <v-card-title class="text-h5">
                            deletar permanetemente?
                          </v-card-title>

                          <v-card-actions>
                            <v-spacer></v-spacer>

                            <v-btn
                              color="danger"
                              text
                              @click="$emit('fechadialogo','deletedialog',register.id)"
                            >
                              Não
                            </v-btn>

                            <v-btn
                              color="success"
                              text
                              @click="$emit('deleteregister',register.id)"
                            >
                              Sim
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>           
                  </td>
            </tr>
          </tbody>
    </v-simple-table>
</template>

<script>

import Form from './Form.vue';

    import {
        mdiFilter,
        mdiSort,
        mdiSortAlphabeticalAscending ,
        mdiSortAlphabeticalDescending ,
        mdiPencil,
        mdiDelete,
        mdiTrashCan,
        mdiFileRestore,
    } from '@mdi/js'

    export default{
        components: { 
            Form:Form,
        },
        setup() {
            return {
                mdiFilter,
                mdiSort,
                mdiSortAlphabeticalAscending ,
                mdiSortAlphabeticalDescending ,
                mdiPencil,
                mdiDelete,
                mdiTrashCan,
                mdiFileRestore,
            }
        },
        emits: ['setSearchField','getRegisters','sort'],
        props:['columns','sortKey', 'sortOrders','allSelelected','registers','massSelelection','fields','formeditUrl','modal','type'],
        methods: {
          closeModal(modalname){
            this.$emit('closemodal', modalname)
          },
          save(fieldvalues,modalname){
            this.$emit('save', fieldvalues, modalname)
          },
          sort(column){
            this.$emit('sort', column)
          }
        },
    }
</script>