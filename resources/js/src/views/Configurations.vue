<template>
  <div class="Configurations">
    <h2>Usuarios</h2>
    <div class="drag-container" v-drag-and-drop:options="options">
      <ul class="drag-list">
        <li class="drag-column" v-for="group in groups" :key="group.id">
          <span class="drag-column-header">
            <h2>{{ group.name }}</h2>
            <feather-icon type="more-vertical"></feather-icon>
          </span>
          <vue-draggable-group
            v-model="group.items"
            :groups="groups"
            :data-id="group.id"
            @change="onGroupsChange"
          >
            <ul class="drag-inner-list" :data-id="group.id">
              <li class="drag-item" v-for="item in group.items" :key="item.id" :data-id="item.id">
                <div class="drag-item-text">{{ item.name }}</div>
              </li>
            </ul>
          </vue-draggable-group>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    let groups = [
        {
          id: 1,
          name: "Não Selecionados",
          items: []
        },
        {
          id: 2,
          name: "Selecionados",
          items: []
        }
      ]
      let options = {
        dropzoneSelector: ".drag-inner-list",
        draggableSelector: ".drag-item"
      }
      let ignorefields = ['id','delete','trash','password','remember_token']
    return {
      groups:groups,
      options:options,
      ignorefields:ignorefields,
    };
  },
  created() {
    this.getUserColumns();
  },  
  methods: {
    async onGroupsChange() {
      await this.$nextTick()
      console.log(this.groups[1].items)
      var bodyFormData = new FormData()
      let json = []
      this.groups[1].items.forEach((field) => {
        json.push({label: field.label, name:field.name, type:field.type }); 
      })
      
      bodyFormData.append('userId', 1); 
      bodyFormData.append('page', 'users'); 
      bodyFormData.append('json', JSON.stringify(json)); 
      
      axios.post('/api/config/columns/save', bodyFormData, {
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
    },
    getUserColumns(){
      axios.get('api/config/users')
        .then(response => {
          let i = 1
          let items = []
          let items2 = []
          let itensSel = []
          axios.post('api/config/columns/users',{userId:1})
            .then(response2 => {
              if(response2.data.data){
                let jsonUser = response2.data.data
                jsonUser.forEach((json) => {
                  itensSel.push(json.name)
                  items2.push({ id: i, name: json.name, label: json.label, type: json.type, groupId: 2 })
                  i++
                })
                response.data.forEach((column) => {
                  if (!this.ignorefields.includes(column.Field)){
                    if (!itensSel.includes(column.Field)){
                      items.push({ id: i, name: column.Field, label: column.Field, type: column.Type, groupId: 1 })
                    }
                    i++
                  }
                })
              }
              else{
                response.data.forEach((column) => {
                  if (!this.ignorefields.includes(column.Field)){
                    items.push({ id: i, name: column.Field, label: column.Field, type: column.Type, groupId: 1 })
                    i++
                  }
                })
              }
              this.$set(this.groups[0], 'items', items) 
              this.$set(this.groups[1], 'items', items2) 

            })
            .catch(errors => {
              this.snackbar = true
              this.toastText = errors
              console.log(errors)
            })
        })
        .catch(errors => {
          this.snackbar = true
          this.toastText = errors
          console.log(errors)
        })
    }
  }
};
</script>

