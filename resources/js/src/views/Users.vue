<template>
  <ag-grid-vue style="width: 100%; height: 500px;"
      class="ag-theme-alpine"
      :columnDefs="columnDefs"
      :rowData="rowData"
      :pagination="true"
      :paginationAutoPageSize="true">
  </ag-grid-vue>
</template>
<script>
  import { AgGridVue } from "ag-grid-vue";
  
  export default {
    name: "Table",
    data() {
      return {
        columnDefs: null,
        rowData: null,
      };
    },
    components: {
      AgGridVue,
    },
    beforeMount() {
      this.columnDefs = [
        { field: "name",sortable: true, filter: true  },
        { field: "email",sortable: true , filter: true },
        { field: "user",sortable: true, filter: true  },
        { field: "telephone",sortable: true, filter: true  },
        { field: "regraId",sortable: true, filter: true  },
        { field: "status",sortable: true, filter: true  },
      ];
      axios.get("/api/users/")
        .then((res) => {
          this.rowData =res.data;
        })
        .catch((error) => {
          console.log(error);
        });

      
    },
  };
  </script>
  <style lang="scss">
     @import "~ag-grid-community/styles/ag-grid.css";
     @import "~ag-grid-community/styles/ag-theme-alpine.css";
  </style>