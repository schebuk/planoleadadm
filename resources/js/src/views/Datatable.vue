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
                <th v-for="column in columns" :key="column.name" 
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
                    <span v-if="column.type == 'bool'">
                        
                        <v-switch
                            v-model="register[column.name]"
                            inset
                            @click="$emit('changestatus',register[column.name],register.id)"
                        ></v-switch>
                    </span>
                    <span v-else>
                        {{register[column.name]}}
                    </span>
                </td>
                <td>
                    <v-dialog
                      v-model="modal.useredit[register.id]"
                      max-width="800px"
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
                            title="Edit User" 
                            :modalname="'useredit_'+register.id" 
                            :url="formeditUrl" 
                            @closemodal="closeModal" 
                            @save="save">
                        </Form>
                    </v-dialog>
            
                    <v-btn
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
            }
        },
        emits: ['setSearchField','getUsers'],
        props:['columns','sortKey', 'sortOrders','allSelelected','registers','massSelelection','fields','formeditUrl','modal'],
        methods: {
          closeModal(modalname){
            this.$emit('closemodal', modalname)
          },
          save(fieldvalues,modalname){
            this.$emit('save', fieldvalues, modalname)
          },
        },
    }
</script>