<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <v-img
              :src="require('@/assets/images/logos/logo.png').default"
              alt="logo"
              contain
              class="me-3"
            ></v-img>

          </router-link>
        </v-card-title>

        <!-- login form -->
        <v-card-text>
          <v-form action="#" @submit.prevent="handleSubmit">
            <v-text-field
              outlined
              label="Email"
              placeholder="john@example.com"
              hide-details
              class="mb-3"
              v-model="formData.email"
            ></v-text-field>

            <v-text-field
              outlined
              :type="isPasswordVisible ? 'text' : 'password'"
              label="Senha"
              v-model="formData.password"
              placeholder="············"
              :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
              hide-details
              @click:append="isPasswordVisible = !isPasswordVisible"
            ></v-text-field>

            <div class="d-flex align-center justify-space-between flex-wrap">
              <v-checkbox label="Remember Me" hide-details class="me-3 mt-1"> </v-checkbox>

              <!-- forgot link -->
              <a href="javascript:void(0)" class="mt-1"> Esqueceu a senha? </a>
            </div>

            <v-btn type="submit" block color="primary" class="mt-6"> Entrar </v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <router-link :to="{ name: 'register' }"> Cadastro</router-link>
        </v-card-text>

        
      </v-card>
    </div>

  </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import Auth from '../../Auth.js';
import router from '../router'

export default {name: 'login',
  data () {
    return {
      formData:{
        email: '',
        password:'',
      }
    }
  },
  methods: {
    handleSubmit() {
      let data = {
        email: this.formData.email,
        password:this.formData.password, 
      };
      axios.post('/api/auth/login', data)
      .then(function (response) {
        //console.log(response);
        Auth.login(response.data.access_token, response.data.user);
        router.push('/dashboard');
      })
      .catch(function (error) {
        console.log(error);
      });
    }
  },
  setup() {
    const isPasswordVisible = ref(false)

    return {
      isPasswordVisible,

      icons: {
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
    }
  },
}
</script>

<style lang="scss">
@import '~@resources/sass/preset/pages/auth.scss';
</style>
