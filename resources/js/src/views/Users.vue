<template>
  <div class="Users">
    <div class="topButtons">

      <v-dialog
        v-model="modal.usercad"
        max-width="800px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            class="mx-2"
            fab
            dark
            color="success"
            v-bind="attrs"
            v-on="on"
          >        
          <v-icon 
            v-text="mdiPlusThick" 
          ></v-icon>
             
          </v-btn>
        </template>
      
        <Form :fields="fields" modalname="usercad" type="create" @closemodal="closemodal" @save="save"></Form>
      </v-dialog>
      <v-btn
      class="mx-2"
      fab
      dark
      color="warning"
      >        
        <v-icon 
          v-text="mdiCloudUpload" 
        ></v-icon>
      </v-btn>
      
      <v-btn
      class="mx-2"
      fab
      dark
      color="primary"
      >        
        <v-icon 
          v-text="mdiFileDownload" 
        ></v-icon>
      </v-btn>
    </div>
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
                v-model="user.status"
                inset
                @click="changestatus(user.status,user.id)"
              ></v-switch>
            </td>
            <td>{{user.created_at}}</td>
            <td>
              <v-dialog
                v-model="modal.useredit[user.id]"
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
                
                <Form :fields="fields" :registerId="user.id" type="edit" :modalname="'useredit_'+user.id" url="api/users/" @closemodal="closemodal" @save="save"></Form>
              </v-dialog>

              <v-btn
                icon 
                color="#CCA01D"
                @click="abredialogo('trashdialog',user.id)"
              >                
                <v-icon 
                  v-text="mdiTrashCan" 
                ></v-icon>
              </v-btn>
              <v-dialog
                v-model="modal.trashdialog[user.id]"
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
                      @click="fechadialogo('trashdialog',user.id)"
                    >
                      Não
                    </v-btn>

                    <v-btn
                      color="success"
                      text
                      @click="trash(user.id)"
                    >
                      Sim
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              
              <v-btn
                icon 
                color="#CCA01D"
                @click="abredialogo('deletedialog',user.id)"
              >       
                <v-icon 
                  v-text="mdiDelete" 
                  color="#FF0000"
                ></v-icon> 
              </v-btn>
              <v-dialog
                v-model="modal.deletedialog[user.id]"
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
                      @click="fechadialogo('deletedialog',user.id)"
                    >
                      Não
                    </v-btn>

                    <v-btn
                      color="success"
                      text
                      @click="deleteregister(user.id)"
                    >
                      Sim
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              
            </td>
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
import Form from './Form.vue';
import LaravelVuePagination from 'laravel-vue-pagination';

import {
  mdiMagnify,
  mdiFilter,
  mdiCloudUpload,
  mdiPlusThick,
  mdiFileDownload,
  mdiPencil,
  mdiDelete,
  mdiTrashCan,
} from '@mdi/js'
export default {
    components: { 
      datatable: Datatable, 
      TableFilter:TableFilter,
      Form:Form,
      'Pagination': LaravelVuePagination 
    },
    created() {
        this.getUsers();
    },
    setup() {
      return {
        mdiMagnify,
        mdiFilter,
        mdiCloudUpload,
        mdiPlusThick,
        mdiFileDownload,
        mdiPencil,
        mdiDelete,
        mdiTrashCan,
      }
    },
    data() {
      let sortOrders = {};
      let showFilterfield = {};
      
      let modal = {
        usercad:false,
        useredit:[],
        trashdialog:[],
        deletedialog:[],
      };
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
      let fields = [
        {name:'name', type:'text'},
        {name:'email', type:'text'},
        {name:'telephone', type:'number'},
        {name:'user', type:'text'},
        {name:'regraId', type:'related',table:'regras',url:'/api/rules/getselect/',description:'rules'},
        {name:'status', type:'bool'},
      ]
      columns.forEach((column) => {
          sortOrders[column.name] = 0;
          showFilterfield[column.name] = false;
      });
      return {
        Users: [],
        columns: columns,
        fields:fields,
        modal:modal,
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
              this.Users.forEach((user, index) =>{
                this.Users[index].status = user.status == 0 ? false : true 
                this.modal.useredit[user.id] = false
                this.modal.trashdialog[user.id]= false
                this.modal.deletedialog[user.id]= false
              })
              this.configPagination(data);
              console.log(this.modal)
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
            let divfilter = "#filterdiv"+key
            console.log(divfilter)
            console.log(this.$el.querySelector(divfilter))
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
      save(formfields,modalname){        
        let  values = {
          name: formfields.name,
          email: formfields.email,
          telephone: formfields.telephone,
          user:formfields.user,
          regraId:formfields.regraId,
          status: formfields.status,
        }
        if(formfields.id){
          values['id'] = formfields.id
          axios.post('/api/users/edit', values)
          .then(response => {
            console.log(response)
          })
          .catch(errors => {
            console.log(errors)
          })
          
        }
        else{
          axios.post('/api/users/save', values)
          .then(response => {
            console.log(response)
          })
          .catch(errors => {
            console.log(errors)
          })
        }
        this.modal[modalname]=false;
        this.getUsers()
      },
      changestatus(status,id){
        status = status? 1:0
        axios.get('/api/users/status/'+id+'/'+status)
          .then(response => {
            console.log(response)
          })
          .catch(errors => {
            console.log(errors)
          })
        this.getUsers()
      },
      trash(id){
        axios.get('/api/users/trash/'+id)
          .then(response => {
            console.log(response)
          })
          .catch(errors => {
            console.log(errors)
          })
        this.fechadialogo('trashdialog',id)
        this.getUsers()
      },      
      deleteregister(id){
        axios.get('/api/users/delete/'+id)
          .then(response => {
            console.log(response)
          })
          .catch(errors => {
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
    }
};
  </script>