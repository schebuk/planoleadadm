<template>
  <div class="Users">
    <v-snackbar
      v-model="snackbar"
    >
      {{ toastText }}
      <template v-slot:action="{ attrs }">
        <v-btn
          color="pink"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
    
    <v-dialog
    v-model="modal.bulkrestore"
    max-width="290"
    >
      <v-card>
        <v-card-title class="text-h5">
          Restaurar registros?
        </v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="danger"
            text
            @click="closemodal('bulkrestore')"
          >
            Não
          </v-btn>

          <v-btn
            color="success"
            text
            @click="restoreBulkRegister()"
          >
            Sim
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
    v-model="modal.bulkdelete"
    max-width="290"
    >
      <v-card>
        <v-card-title class="text-h5">
          deletar registros permanentemente?
        </v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="danger"
            text
            @click="closemodal('bulkdelete')"
          >
            Não
          </v-btn>

          <v-btn
            color="success"
            text
            @click="deleteBulkRegister()"
          >
            Sim
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-row>
      <v-col>  
        <v-btn
          rounded
          color="primary"
          dark
          :to="{name:'users'}"
        >     
            <v-icon 
              v-text="mdiArrowLeft" 
            ></v-icon> 
            Usuarios
                          
        </v-btn>
      </v-col>
    </v-row>
    
    <div class="control">
      <div class="select">
        <v-row>
          
          <v-col
            class="d-inline-flex pa-2"
            cols="2"
            sm="2"
          >  
            <v-select 
              width="30"
              v-model="bulkActionType" 
              label="Bulk Action"
              @change="bulkAction()" 
              :items="bulkActionItens"
              item-text="text"
              item-value="action"
            ></v-select>
          </v-col>
          <v-col
            class="d-inline-flex pa-2"
            cols="1"
            sm="1"
          >  
            <v-select 
              width="30"
              v-model="tableData.length" 
              label="Register per page"
              @change="getUsers()" 
              :items="perPage"
            ></v-select>
          </v-col>
          
          <v-col
            class="d-inline-flex pa-2"
            cols="9"
            sm="9"
            align-self="center"
          >  
            <Pagination 
              :data="pagination.data" 
              @pagination-change-page="getUsers" 
              :limit="3"
              :show-disabled="true"
            >
              <template #prev-nav>
                  <span>&lt;&lt; </span>
              </template>
              <template #next-nav>
                  <span>&gt;&gt;</span>
              </template>
            </Pagination>
          </v-col>
        </v-row>
      </div>
    </div>
    <ul class="filterConteiner">
      <li v-for="column in columns" :style="'width: '+column.width+';'">
        <TableFilter 
          :showFilterfield="showFilterfield"
          :column="column" 
          :tableData="tableData" 
          @setSearchField="setSearchField" 
          @getUsers="getUsers"
        ></TableFilter>
      </li>
    </ul>
    <datatabletrash 
      :columns="columns" 
      :sortKey="sortKey" 
      :sortOrders="sortOrders" 
      :allSelelected="allSelelected"
      :registers="Users"
      :massSelelection="massSelelection"
      :modal="modal"
      @sort="sortBy" 
      @showFilter="showFilter" 
      @selectAll="selectAll"
      @fechadialogo="fechadialogo"
      @abredialogo="abredialogo"
      @restore="restore"
      @deleteregister="deleteregister"
      @closemodal="closemodal" 
      >
        
    </datatabletrash>
    <div class="control">
      <div class="select">
        <v-row>
          
          <v-col
            class="d-inline-flex pa-2"
            cols="2"
            sm="2"
          >  
            <v-select 
              width="30"
              v-model="bulkActionType" 
              label="Bulk Action"
              @change="bulkAction()" 
              :items="bulkActionItens"
              item-text="text"
              item-value="action"
            ></v-select>
          </v-col>
          
          <v-col
            class="d-inline-flex pa-2"
            cols="10"
            sm="10"
            align-self="center"
          >  
            <Pagination 
              :data="pagination.data" 
              @pagination-change-page="getUsers" 
              :limit="3"
              :show-disabled="true"
            >
              <template #prev-nav>
                  <span>&lt;&lt; </span>
              </template>
              <template #next-nav>
                  <span>&gt;&gt;</span>
              </template>
            </Pagination>
          </v-col>
        </v-row>
      </div>
    </div>
  </div>
</template>

<script>  

import DatatableTrash from './DatatableTrash.vue';
import TableFilter from './TableFIlter.vue';
import LaravelVuePagination from 'laravel-vue-pagination';

import {
  mdiMagnify,
  mdiFilter,
  mdiDelete,
  mdiArrowLeft,
  mdiFileRestore ,
} from '@mdi/js'
export default {
    components: { 
      datatabletrash: DatatableTrash, 
      TableFilter:TableFilter,
      'Pagination': LaravelVuePagination,
    },
    created() {
        this.getUsers();
        this.getColumns();
    },
    setup() {
      return {
        mdiMagnify,
        mdiFilter,
        mdiDelete,
        mdiArrowLeft,
        mdiFileRestore,
      }
    },
    data() {      
      let modal = {
        restoredialog:[],
        deletedialog:[],
        bulkrestore:false,
        bulkdelete:false,
      }; 
      let bulkActionItens = [{action:'default',text:'-----'},
        {action:'restore',text:'Restaurar registro'},
        {action:'delete',text:'Deletar Permanentemente'}
      ]
      return {
        Users: [],
        columns: [],
        modal:modal,
        sortKey: 'id',
        sortOrders: [],
        showFilterfield: [],
        perPage: ['10', '50', '100'],
        snackbar:false,
        toastText: '',
        tableData: {
          draw: 0,
          length: 10,
          search: '',
          searchType: 'contains',
          searchField: '',
          operator:'AND',
          search2: '',
          searchType2: 'contains',
          column: 0,
          dir: 'asc',
        },
        pagination:{},      
        massSelelection: [],
        selelectionIds: [],
        allSelelected: false,
        bulkActionItens:bulkActionItens,
        bulkActionType:'',
        selectedIds: [],
      }
    },
    methods: {
      getUsers(page = 1,url = '/api/users/trash/list/?page=') {
        this.tableData.draw++;
        axios.get(url + page, {params: this.tableData})
          .then(response => {
            let data = response.data;
            let countRegisters = 0
            if (this.tableData.draw == data.draw) {
              this.Users = data.data.data;
              this.allSelelected = false
              this.Users.forEach((user, index) =>{
                this.modal.restoredialog[user.id]= false
                this.modal.deletedialog[user.id]= false
                if(!this.massSelelection[user.id]){
                  this.massSelelection[user.id] = false
                }
                else{
                  countRegisters++
                }
              })
              if (countRegisters == this.tableData.length){
                this.allSelelected = true
              }
              this.configPagination(data)
            }
          })
          .catch(errors => {
              this.snackbar = true
              this.toastText = errors
              console.log(errors);
          });
      },
      getColumns(){
        axios.post('/api/config/columns/users',{userId:1})
          .then(response => {
            if (response.data.data){
              this.columns = response.data.data
            }
            else{
              this.columns = [
                {"name": "name", "type": "varchar(255)", "label": "name"}, 
                {"name": "email", "type": "varchar(255)", "label": "email"}, 
                {"name": "user", "type": "varchar(255)", "label": "user"}, 
                {"name": "telephone", "type": "varchar(255)", "label": "telephone"}, 
                {"name": "regraId", "type": "int(11)", "label": "regraId"}, 
                {"name": "status", "type": "tinyint(1)", "label": "status"}, 
                {"name": "created_at", "type": "timestamp", "label": "created_at"}
              ]
            }
            
            let sort = []
            let filter= []
            this.columns.forEach((column) => {
              sort[column.name] = 0
              filter[column.name] = false
            });
            
            this.$set(this.sortOrders, sort)
          
            this.$set(this.showFilterfield, filter)
            
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(errors)
          })
      },
      configPagination(data) {
        this.pagination = data;
      },
      sortBy(key) {
          this.sortKey = key;
          this.columns.forEach((column) => {
            if (column.name != key)
              this.sortOrders[column.name] = 0;
          });
          this.sortOrders[key] = this.sortOrders[key] == 0?  1 : this.sortOrders[key] * -1;
          this.tableData.column = key;
          this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
          this.getUsers();
      },
      getIndex(array, key, value) {
          return array.findIndex(i => i[key] == value)
      },
      setSearchField(val){
        this.tableData.searchField = val.field;
        this.tableData.search = val.search;
        this.tableData.searchType = val.type;
        this.tableData.operator = val.operator;
        this.tableData.searchType2 = val.type2; 
        this.tableData.search2 = val.search2;
        this.getUsers()
      },
      showFilter(key){
        console.log(this.showFilterfield[key])
        let type = ''
          this.columns.forEach((column) => {
            if (column.name != key){
              this.$set(this.showFilterfield, column.name, false)
            }
            else{
              type = column.type
            }
          });
          this.tableData.search = '';
          this.tableData.search2 = '';
          this.tableData.searchType='contains'
          this.tableData.searchType2='contains'
          if (type == 'tinyint(1)'){
            this.tableData.searchType='equal'
          }
          if (type == 'timestamp'){
            this.tableData.searchType='greater'
            this.tableData.searchType2='greater'
          }
          this.$set(this.showFilterfield, key, !this.showFilterfield[key])
          console.log(this.showFilterfield)
          this.$nextTick(() => {
            let divfilter = "#filterdiv"+key
            this.$el.querySelector(divfilter).focus()
          },1);
      },
      closemodal(modalname){
        let modal = modalname.split('_')
        if (modal[1]){   
          let modalname = modal[0]; 
          let modalid = modal[1]     
          this.$set(this.modal[modalname],modalid , false) 
        }
        else{
          this.modal[modalname]=false;
        }
      },
      restore(id){
        axios.get('/api/users/restore/'+id)
          .then(response => {
            this.snackbar = true
            this.toastText = response.data.message
            console.log(response)
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors.data.error
            console.log(errors)
          })
        this.fechadialogo('restoredialog',id)
        this.getUsers()
      },      
      deleteregister(id){
        axios.get('/api/users/delete/'+id)
          .then(response => {
            this.snackbar = true
            this.toastText = response.data.message
            console.log(response)
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(errors)
          })
        this.fechadialogo('deletedialog',id)
        this.getUsers()
      },
      abredialogo(modal,id){
        this.$set(this.modal[modal],id , true) 
      },
      fechadialogo(modal,id){
        this.$set(this.modal[modal],id , false) 
      },
      selectAll(){
        this.allSelelected = !this.allSelelected 
        this.Users.forEach((user) =>{
          this.massSelelection[user.id] = this.allSelelected
        })
        console.log(this.massSelelection)
      },
      bulkAction(){
        switch (this.bulkActionType){
          case 'restore':
            this.modal.bulkrestore = true
            break
          case 'delete':
            this.modal.bulkdelete = true
            break    
        }        
      },
      restoreBulkRegister(){
        
        this.massSelelection.forEach((value, index) => {
          if (value){
            this.selectedIds.push(index)
          }
          this.massSelelection[index] = false
        })
        var bodyFormData = new FormData()
        bodyFormData.append('ids', this.selectedIds); 
        axios.post('/api/users/restore/multiple', bodyFormData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
          .then(response => {
            this.trashData = response.data
            this.trashCount = response.data.length
            this.snackbar = true
            this.toastText = response.data.message
            console.log(response)
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(errors)
          });
        this.selectedIds = []
        this.modal.bulkrestore = false
        this.bulkActionType = 'default'
        this.getUsers()

      },
      deleteBulkRegister(){
        this.massSelelection.forEach((value, index) => {
          if (value){
            this.selectedIds.push(index)
          }
          this.massSelelection[index] = false
        })
        var bodyFormData = new FormData()
        bodyFormData.append('ids', this.selectedIds); 
        axios.post('/api/users/delete/multiple', bodyFormData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
          .then(response => {
            this.snackbar = true
            this.toastText = response.data.message
            console.log(response)
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(errors)
          });
        this.selectedIds = []
        this.modal.bulkdelete = false
        this.bulkActionType = 'default'
        this.getUsers()
      }
    }
};
  </script>