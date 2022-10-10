<template>
  <div class="Users">
    

    <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy" @showFilter="showFilter">
        <tbody>
          <tr >
            <td v-for="column in columns" style=" height:0;">
              <div class="tableFilters" v-if="showFilterfield[column.name]">     
                <v-col
                  class="d-flex"
                  cols="12"
                  sm="12"
                >          
                  <v-text-field
                    v-model="tableData.search"
                    outlined
                    dense
                    placeholder="Search"
                    icon
                    :searchField="column.name"
                    @keydown="setSearchField"
                    hide-details
                  ></v-text-field>
                </v-col>
                <v-col
                  class="d-flex"
                  cols="12"
                  sm="12"
                >
                  <v-select
                    :items="searchTypeItens"
                    label="Search Type"
                    v-model="tableData.searchType"
                    filled
                    dense
                    @change="getUsers()"
                  ></v-select>
                </v-col>
              </div>
            </td>
          </tr>
          <tr v-for="user in Users" :key="user.id">
              <td>{{user.name}} 
              <td>{{user.email}}</td>
              <td>{{user.telephone}}</td>
              <td>{{user.user}}</td>
              <td>{{user.regraId}}</td>
              <td>{{user.status}}</td>
          </tr>
        </tbody>
    </datatable>
    <div class="control">
      <div class="select">
        <v-select 
          width="30"
          v-model="tableData.length" 
          label="Register per page"
          @change="getUsers()" 
          :items="perPage"
        ></v-select>
        
        <pagination :pagination="pagination"
          @prev="getUsers(pagination.prevPageUrl)"
          @next="getUsers(pagination.nextPageUrl)"> 
        </pagination>
      </div>
    </div>
  </div>
</div>
</template>
<style>
  .table {
    width: 100%;
  }
  .tableFilters{
    position: absolute;
    border: 1px black solid;
    background-color: azure;
    top:60px;
  }
</style>
<script>  

import Datatable from './Datatable.vue';
import Pagination from './Pagination.vue';

import {
  mdiMagnify,
  mdiFilter,
} from '@mdi/js'
export default {
    components: { datatable: Datatable, pagination: Pagination },
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
          {width: '18%', label: 'name', name: 'name' },
          {width: '18%', label: 'email', name: 'email'},
          {width: '18%', label: 'telephone', name: 'telephone'},
          {width: '18%', label: 'user', name: 'user'},
          {width: '18%', label: 'regraId', name: 'regraId'},
          {width: '18%', label: 'status', name: 'status'},
      ];
      let searchTypeItens = ['contains','start','end','equal','notequal','greater','greaterequal','lesser','lesserequal'];
      let searchFields = ['name','email','telephone','user','regraId','status']
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
        searchTypeItens,
        searchFields,
        tableData: {
          draw: 0,
          length: 10,
          search: '',
          searchType: 'contains',
          searchField: '',
          column: 0,
          dir: 'asc',
        },
        pagination: {
          lastPage: '',
          currentPage: '',
          total: '',
          totalPages:'',
          lastPageUrl: '',
          nextPageUrl: '',
          prevPageUrl: '',
          from: '',
          to: '',
          links: {},
        },
      }
    },
    methods: {
      getUsers(url = '/api/users/') {
        console.log(url)
            this.tableData.draw++;
            axios.get(url, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.Users = data.data.data;
                        this.configPagination(data.data);
                    }
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        configPagination(data) {
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.totalPages = Math.ceil(parseInt(data.total) / parseInt(data.per_page));
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
            this.pagination.path = data.path;
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
        setSearchField: function(event){
          this.tableData.searchField = event.target.attributes.searchfield.value;
          this.getUsers()
        },
        showFilter(key){
            this.columns.forEach((column) => {
              if (column.name != key)
                this.showFilterfield[column.name] = false;
            });
            this.showFilterfield[key] = !this.showFilterfield[key]
        },
    }
};
  </script>