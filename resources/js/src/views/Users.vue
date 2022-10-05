<template>
  
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-uppercase">
            nome
          </th>
          <th class="text-uppercase">
            email
          </th>
          <th class="text-center text-uppercase">
            telephone
          </th>
          <th class="text-center text-uppercase">
            regraId
          </th>
          <th class="text-center text-uppercase">
            status 
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in users"
          :key="item.data"
        >
          <td>{{ item.name }}</td>
          <td class="text-center">
            {{ item.email }}
          </td>
          <td class="text-center">
            {{ item.telephone }}
          </td>
          <td class="text-center">
            {{ item.regraId }}
          </td>
          <td class="text-center">
            {{ item.status }}
          </td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>

</template>

<script>
  export default {
   name: "Users",
   data() {
     return {
       users: {},
     };
   },
   created() {
     this.getUser();
   },
   methods: {
     getUser() {
       axios.get("/api/users/")
        .then((res) => {
           this.users = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
     },
   },
  }
</script>
