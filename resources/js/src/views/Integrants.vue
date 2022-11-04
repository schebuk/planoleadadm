<template>
  <div class="Integrants">
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
      v-model="modal.bulkedit"
      max-width="800px"
    >   
      <Form :fields="bulkFields" modalname="bulkedit" title="Bulk edit" type="create" @closemodal="closemodal" @save="saveBulk"></Form>
    </v-dialog>
    <v-dialog
    v-model="modal.bulktrash"
    max-width="290"
    >
      <v-card>
        <v-card-title class="text-h5">
          mandar registros para lixeira?
        </v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="danger"
            text
            @click="closemodal('bulktrash')"
          >
            Não
          </v-btn>

          <v-btn
            color="success"
            text
            @click="trashBulkRegister()"
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
    <div class="topButtons">
      <v-dialog
        v-model="modal.cad"
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
            >
            </v-icon>             
          </v-btn>
        </template>      
        <Form :fields="fields" modalname="cad" title="Adicionar Segmento" type="create" @closemodal="closemodal" @save="save"></Form>
      </v-dialog>
      <v-btn
        class="mx-2"
        fab
        dark
        color="warning"
        :loading="isSelecting" 
        @click="handleFileImport"
      >        
        <v-icon 
          v-text="mdiCloudUpload" 
        ></v-icon>
      </v-btn>
      
      <v-btn
        class="mx-2"
        fab
        dark
        color="#a1d4cf"
        :loading="isSelectingTemplateExport" 
        @click="exportTemplate"
      >     
        <v-badge
          color="#ff0000"
          content="Ex"
        >     
            <v-icon 
              v-text="mdiCloudUpload" 
            ></v-icon>
        </v-badge>
      </v-btn>
      <input 
          ref="uploader" 
          class="d-none" 
          type="file" 
          @change="onFileChanged"
      >
      <v-btn
      class="mx-2"
      fab
      dark
      color="primary"
      :loading="isSelectingExport" 
      @click="exportRegisters"
      >        
        <v-icon 
          v-text="mdiFileDownload" 
        ></v-icon>
      </v-btn>
      
      <v-btn
        class="mx-2"
        fab
        dark
        color="#6e7b8b"
        :to="{name:'integrants-trash'}"
      >     
        <v-badge
          color="#ff0000"
          :content="trashCount"
        >   
          <v-icon 
            v-text="mdiTrashCan" 
          ></v-icon> 
          
        </v-badge> 
                        
      </v-btn>
      <v-btn
        class="mx-2"
        fab
        dark
        color="#f5c242"
        @click="clearSearch"
      >      
          <v-icon 
            v-text="mdiMagnifyRemoveOutline " 
          ></v-icon>                         
      </v-btn>
    </div>
    
    <div class="control">
      <div class="select">
        <v-row>
          
          <v-col
            class="d-inline-flex pa-2"
            cols="2"
            sm="2"
          >  
            <p style="padding-top:15px;">Mostrando de {{ fromRegister }}-{{ toRegister }} de {{ totalRegister}}</p>
          </v-col>
          <v-col
            class="d-inline-flex pa-2"
            cols="2"
            sm="2"
          >  
            <v-select 
              width="30"
              v-model="bulkActionType" 
              label="Ações em Massa"
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
              label="Registros por pagina"
              @change="getRegisters()" 
              :items="perPage"
            ></v-select>
          </v-col>
          
          <v-col
            class="d-inline-flex pa-2"
            cols="7"
            sm="7"
            align-self="center"
          >  
            <Pagination 
              :data="pagination.data" 
              @pagination-change-page="getRegisters" 
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
          :key="column.name" 
          @setSearchField="setSearchField" 
          @getRegisters="getRegisters"
        ></TableFilter>
      </li>
    </ul>
    <datatable 
      :registers="Registers" 
      :columns="columns" 
      :sortKey="sortKey" 
      :sortOrders="sortOrders" 
      :allSelelected="allSelelected" 
      :massSelelection="massSelelection"
      :fields="fields"
      :modal="modal"
      type="list"
      formeditUrl="api/integrants/"
      @sort="sortBy" 
      @changestatus="changestatus"
      @showFilter="showFilter" 
      @selectAll="selectAll"
      @fechadialogo="fechadialogo"
      @abredialogo="abredialogo"
      @trash="trash"
      @save="save"
      @closemodal="closemodal" 
    ></datatable>
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
              label="Ações em Massa"
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
              @pagination-change-page="getRegisters" 
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
  mdiMagnifyRemoveOutline,
} from '@mdi/js'
export default {
    components: { 
      datatable: Datatable, 
      TableFilter:TableFilter,
      Form:Form,
      'Pagination': LaravelVuePagination 
    },
    beforeMount() {
      this.getColumns()
      this.getRegisters()
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
        mdiMagnifyRemoveOutline,
      }
    },
    data() {      
      let modal = {
        cad:false,
        edit:[],
        trashdialog:[],
        deletedialog:[],
        bulkedit:false,
        trash:false,
        bulktrash:false,
        bulkdelete:false,
      };
      let fields = [
        {name:'name', type:'text'},
        {name:'status', type:'bool'},
      ]
      let bulkFields = [
        {name:'status', type:'bool'},
      ]      
      let bulkActionItens = [{action:'default',text:'-----'},
        {action:'edit',text:'Editar'},
        {action:'trash',text:'Mandar para Lixeira'},
      ]
      return {
        Registers: [],
        columns: [],
        fields:fields,
        bulkFields:bulkFields,
        modal:modal,
        sortKey: 'id',
        sortOrders: [],
        showFilterfield: [],
        perPage: ['10', '50', '100'],
        snackbar:false,
        toastText: '',
        toRegister:'',
        fromRegister:'',
        totalRegister: '',
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
          dir: 'desc',
        },
        pagination:{},
        isSelecting: false,
        isSelectingExport:false,
        isSelectingTemplateExport:false,        
        selectedFile: null,
        massSelelection: [],
        selelectionIds: [],
        allSelelected: false,
        trashData:[],
        trashCount:0,
        bulkActionItens:bulkActionItens,
        bulkActionType:'',
        selectedIds: [],
      }
    },
    methods: {
      getRegisters(page = 1,url = '/api/integrants/?page=') {
        this.tableData.draw++;
        axios.get(url + page, {params: this.tableData})
          .then(response => {
            let data = response.data;
            let countRegisters = 0
            if (this.tableData.draw == data.draw) {
              this.Registers = data.data.data;
              this.allSelelected = false
              this.Registers.forEach((register, index) =>{
                this.Registers[index].status = register.status == 0 ? false : true 
                this.modal.edit[register.id] = false
                this.modal.trashdialog[register.id]= false
                this.modal.deletedialog[register.id]= false
                if(!this.massSelelection[register.id]){
                  this.massSelelection[register.id] = false
                }
                else{
                  countRegisters++
                }
              })
              if (countRegisters == this.tableData.length){
                this.allSelelected = true
              }
              this.configPagination(data)
              this.getTrash()
            }
          })
          .catch(errors => {
              this.snackbar = true
              this.toastText = errors
              console.log(errors);
          });
      },
      getColumns(){
        axios.post('/api/config/columns/integrants',{id:1})
          .then(response => {
            if (response.data.data){
              this.columns = response.data.data
            }
            else{
              this.columns = [
                {"name": "clientId", "type": "int(10)", "label": "clientId"}, 
                {"name": "userId", "type": "int(10)", "label": "userId"}, 
                {"name": "status", "type": "tinyint(1)", "label": "status"}, 
                {"name": "created_at", "type": "timestamp", "label": "created_at"}
              ]
            }
            
            let filter= []
            this.columns.forEach((column) => {
              this.sortOrders[column.name] = 0
              filter[column.name] = false
            });
            
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
        this.toRegister = data.data.to;
        this.fromRegister = data.data.from;
        this.totalRegister = data.data.total;
      },
      sortBy(key) {
          this.sortKey = key;
          this.columns.forEach((column) => {
            if (column.name != key)
              this.sortOrders[column.name] = 0;
          });
          
          this.tableData.column = key;
          switch (this.sortOrders[key]){
            case 0:
              this.sortOrders[key] = 1 
              this.tableData.dir = 'asc'
              break 
            case 1:
              this.sortOrders[key] =  -1
              this.tableData.dir = 'desc'
              break
            case -1:
              this.sortOrders[key] = 0
              this.tableData.column = '';
              this.tableData.dir = ''
            break
          }
          
          this.getRegisters();
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
        this.getRegisters()
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
      save(formfields,modalname){        
        let  values = {
          name: formfields.name,
          status: formfields.status,
        }
        if(formfields.id){
          values['id'] = formfields.id
          axios.post('/api/integrants/edit', values)
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
          
        }
        else{
          axios.post('/api/integrants/save', values)
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
        }
        this.modal[modalname]=false;
        this.getRegisters()
      },
      saveBulk(formfields,modalname){  
        this.massSelelection.forEach((value, index) => {
          if (value){
            this.selectedIds.push(index)
          }
          this.massSelelection[index] = false
        })
        var bodyFormData = new FormData()
        bodyFormData.append('ids', this.selectedIds); 
        if (formfields.regraId) {
          bodyFormData.append('regraId', formfields.regraId); 
        }
        if (formfields.status != null) {
          bodyFormData.append('status', formfields.status); 
        }
        axios.post('/api/integrants/edit/multiple', bodyFormData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(response => {
          this.snackbar = true
          this.toastText = response.data.message
        })
        .catch(errors => {
          this.snackbar = true
          this.toastText = errors.data.error
        })          
        this.modal[modalname]=false;
        this.bulkActionType = 'default'
        this.getRegisters()
      },
      changestatus(status,id){
        status = status? 1:0
        axios.get('/api/integrants/status/'+id+'/'+status)
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
        this.getRegisters()
      },
      trash(id){
        axios.get('/api/integrants/trash/'+id)
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
        this.fechadialogo('trashdialog',id)
        this.getRegisters()
      },      
      deleteregister(id){
        axios.get('/api/integrants/delete/'+id)
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
        this.getRegisters()
      },
      abredialogo(modal,id){
        this.$set(this.modal[modal],id , true) 
      },
      fechadialogo(modal,id){
        this.$set(this.modal[modal],id , false) 
      },
      handleFileImport() {
        this.isSelecting = true;

        // After obtaining the focus when closing the FilePicker, return the button state to normal
        window.addEventListener('focus', () => {
            this.isSelecting = false
        }, { once: true });
        
        // Trigger click on the FileInput
        this.$refs.uploader.click();
      },
      onFileChanged(e) {
        const formData = new FormData();
        const file = e.target.files[0];
        formData.append('file', file);
        axios.post('/api/integrants/import', formData)
          .then(response => {
            this.snackbar = true
            this.toastText = response.data.message
            console.log(response)
            this.getRegisters()
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(error)
          });
          
      },
      exportRegisters(){
        this.isSelectingExport = true;
        axios.post('/api/integrants/export',{responseType: 'arraybuffer'})
          .then(response => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'integrants.csv');
                document.body.appendChild(fileLink);
                fileLink.click();
                
                this.isSelectingExport = false;
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(errors)
          });
      },
      exportTemplate(){
        this.isSelectingTemplateExport = true;
        axios.post('/api/integrants/export/template',{responseType: 'arraybuffer'})
          .then(response => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'integrantstemplate.csv');
                document.body.appendChild(fileLink);
                fileLink.click();
                
                this.isSelectingTemplateExport = false;
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(errors)
          });
      },
      selectAll(){
        this.allSelelected = !this.allSelelected 
        this.Registers.forEach((register) =>{
          this.massSelelection[register.id] = this.allSelelected
        })
        console.log(this.massSelelection)
      },
      getTrash(){
        axios.post('api/integrants/gettrash/')
          .then(response => {
            this.trashData = response.data
            this.trashCount = response.data.length
          })
          .catch(errors => {
            this.snackbar = true
            this.toastText = errors
            console.log(errors)
          });
      },
      bulkAction(){
        switch (this.bulkActionType){
          case 'edit':
            this.modal.bulkedit = true
            break
          case 'trash':
            this.modal.bulktrash = true
            break
          case 'delete':
            this.modal.bulkdelete = true
            break    
        }        
      },
      trashBulkRegister(){
        
        this.massSelelection.forEach((value, index) => {
          if (value){
            this.selectedIds.push(index)
          }
          this.massSelelection[index] = false
        })
        var bodyFormData = new FormData()
        bodyFormData.append('ids', this.selectedIds); 
        axios.post('/api/integrants/trash/multiple', bodyFormData, {
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
        this.modal.bulktrash = false
        this.bulkActionType = 'default'
        this.getRegisters()

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
        axios.post('/api/integrants/delete/multiple', bodyFormData, {
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
        this.getRegisters()
      },
      clearSearch(){
        this.tableData.searchField = ''
        this.tableData.search = ''
        this.tableData.searchType = ''
        this.tableData.operator = ''
        this.tableData.searchType2 = ''
        this.tableData.search2 = ''
        this.getRegisters()

      }
    }
};
  </script>