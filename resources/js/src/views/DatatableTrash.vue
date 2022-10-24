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
                <th v-for="column in columns" :key="column.name"  :id="'th'+column.name"
                    :style="'width:'+column.width+';'+'cursor:pointer;'">
                        <a href="javascript:void(0);" @click="$emit('sort', column.name)" style="text-decoration:none; color:black;
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
                      {{register[column.name]==0?'Desativado':'ativado'}}
                    </span>
                    <span v-else>
                        {{register[column.name]}}
                    </span>
              </td>
              <td>
              
                <v-btn
                  icon 
                  color="#89F98C"
                  @click="$emit('abredialogo','restoredialog',register.id)"
                >                
                  <v-icon 
                    v-text="mdiFileRestore" 
                  ></v-icon>
                </v-btn>
                <v-dialog
                  v-model="modal.restoredialog[register.id]"
                  max-width="290"
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
          >       
            <v-icon 
              v-text="mdiDelete" 
              color="#FF0000"
            ></v-icon> 
          </v-btn>
          <v-dialog
            v-model="modal.deletedialog[register.id]"
            max-width="290"
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
        emits: ['setSearchField','getUsers'],
        props:['columns','sortKey', 'sortOrders','allSelelected','registers','massSelelection','fields','modal'],
        methods: {
          closeModal(modalname){
            this.$emit('closemodal', modalname)
          },
        },
    }
</script>