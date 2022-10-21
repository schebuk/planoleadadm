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
      <li v-for="column in columns" :style="'width:'+column.width">
        <TableFilter :showFilterfield="showFilterfield" :column="column" :tableData="tableData" @setSearchField="setSearchField" @getUsers="getUsers"></TableFilter>
      </li>
    </ul>
    <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" :allSelelected="allSelelected" @sort="sortBy" @showFilter="showFilter" @selectAll="selectAll">
        
    </datatable>
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

import Datatable from './Datatable.vue';
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
      datatable: Datatable, 
      TableFilter:TableFilter,
      'Pagination': LaravelVuePagination,
    },
    created() {
        this.getUsers();
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
      let sortOrders = {};
      let showFilterfield = {};
      
      let modal = {
        restoredialog:[],
        deletedialog:[],
      };
      let columns = [
          {width: '14%', label: 'name', name: 'name',type:'string' },
          {width: '14%', label: 'email', name: 'email',type:'string'},
          {width: '14%', label: 'telephone', name: 'telephone',type:'number'},
          {width: '14%', label: 'user', name: 'user',type:'string'},
          {width: '14%', label: 'created_at', name: 'created_at',type:'date'},
      ];
      let searchFields = ['name','email','telephone','user','created_at']    
      let bulkActionItens = [{action:'default',text:'-----'},
        {action:'restore',text:'Restaurar registro'},
        {action:'delete',text:'Deletar Permanentemente'}
      ]
      columns.forEach((column) => {
          sortOrders[column.name] = 0;
          showFilterfield[column.name] = false;
      });
      return {
        Users: [],
        columns: columns,
        modal:modal,
        sortKey: 'id',
        sortOrders: sortOrders,
        showFilterfield: showFilterfield,
        perPage: ['10', '50', '100'],
        searchFields,
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
                this.Users[index].status = user.status == 0 ? false : true 
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
          this.columns.forEach((column) => {
            if (column.name != key)
              this.showFilterfield[column.name] = false;
          });
          this.tableData.search = '';
          this.tableData.search2 = '';
          this.showFilterfield[key] = !this.showFilterfield[key];
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
        this.massSelelection.forEach((value, index) => {
          if (value){
            this.selectedIds.push(index)
          }
          this.massSelelection[index] = false
        })
        var bodyFormData = new FormData()
        bodyFormData.append('ids', this.selectedIds); 
        switch (this.bulkActionType){
          case 'restore':
            axios.post('/api/users/restore/multiple', bodyFormData, {
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
            break
          case 'delete':
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
            break
        }
        this.bulkActionType = 'default'
        this.getUsers()
      }
    }
};
  </script>