<template>
  <div class="Users">
    <ul class="filterConteiner">
      <li v-for="column in columns" :style="'width:'+column.width">
        <TableFilter :showFilterfield="showFilterfield" :column="column" :tableData="tableData" @setSearchField="setSearchField" @getUsers="getUsers"></TableFilter>
      </li>
    </ul>
    <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy" @showFilter="showFilter">
        <tbody>
          <tr v-for="user in Users" :key="user.id">
              <td>{{user.name}} 
              <td>{{user.email}}</td>
              <td>{{user.telephone}}</td>
              <td>{{user.user}}</td>
              <td>{{user.regraId}}</td>
              <td>
                <v-switch
                  :v-model="user.status"
                  inset
                ></v-switch>
              </td>
              <td>{{user.created_at}}</td>
          </tr>
        </tbody>
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
              v-model="tableData.length" 
              label="Register per page"
              @change="getUsers()" 
              :items="perPage"
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
} from '@mdi/js'
export default {
    components: { 
      datatable: Datatable, 
      TableFilter:TableFilter,
      'Pagination': LaravelVuePagination 
    },
    created() {
        this.getUsers();
    },
    setup() {
      return {
        mdiMagnify,
        mdiFilter,
      }
    },
    data() {
      let sortOrders = {};
      let showFilterfield = {};
      let columns = [
          {width: '14%', label: 'name', name: 'name',type:'string' },
          {width: '14%', label: 'email', name: 'email',type:'string'},
          {width: '14%', label: 'telephone', name: 'telephone',type:'number'},
          {width: '14%', label: 'user', name: 'user',type:'string'},
          {width: '14%', label: 'regraId', name: 'regraId',type:'number'},
          {width: '14%', label: 'status', name: 'status',type:'bool'},
          {width: '14%', label: 'created_at', name: 'created_at',type:'date'},
      ];
      let searchFields = ['name','email','telephone','user','regraId','status','created_at']
      columns.forEach((column) => {
          sortOrders[column.name] = 0;
          showFilterfield[column.name] = false;
      });
      return {
        Users: [],
        columns: columns,
        sortKey: 'id',
        sortOrders: sortOrders,
        showFilterfield: showFilterfield,
        perPage: ['10', '50', '100'],
        searchFields,
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
      }
    },
    methods: {
      getUsers(page = 1,url = '/api/users/?page=') {
            this.tableData.draw++;
            axios.get(url + page, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.Users = data.data.data;
                        this.configPagination(data);
                    }
                })
                .catch(errors => {
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
              this.$el.querySelector("#filterdiv").focus()
            },1);
        },
    }
};
  </script>