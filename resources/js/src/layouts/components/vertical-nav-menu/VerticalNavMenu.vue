<template>
  <v-navigation-drawer
    :value="isDrawerOpen"
    app
    floating
    width="260"
    class="app-navigation-menu"
    :right="$vuetify.rtl"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <!-- Navigation Header -->
    <div class="vertical-nav-header d-flex items-center ps-6 pe-5 pt-5 pb-2">
      <router-link to="/" class="d-flex align-center text-decoration-none">
        <v-img
          :src="require('@/assets/images/logos/logo.png').default"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        ></v-img>
      </router-link>
    </div>
    <v-list expand shaped class="vertical-nav-menu-items pr-5">
      <nav-menu-link title="Dashboard" :to="{ name: 'dashboard' }" :icon="icons.mdiHomeOutline"></nav-menu-link>
      <nav-menu-link title="Usuarios" :to="{ name: 'users' }" :icon="icons.mdiAccountMultiple"></nav-menu-link>
      <nav-menu-link title="Segmentos" :to="{ name: 'segments' }" :icon="icons.mdiDomain"></nav-menu-link>
      <nav-menu-link title="Regras" :to="{ name: 'rules' }" :icon="icons.mdiClipboardList"></nav-menu-link>    
      <nav-menu-link title="Qualidade" :to="{ name: 'quality' }" :icon="icons.mdiFilePercent"></nav-menu-link>  
      <nav-menu-link title="Anuncios" :to="{ name: 'ads' }" :icon="icons.mdiBookOpen"></nav-menu-link>     
      <nav-menu-link title="Clientes" :to="{ name: 'clients' }" :icon="icons.mdiAccountCash "></nav-menu-link>   
      <nav-menu-link title="Leads" :to="{ name: 'leads' }" :icon="icons.mdiTable "></nav-menu-link>       
      <nav-menu-link title="Configurações" :to="{ name: 'configs' }" :icon="icons.mdiCog"></nav-menu-link>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
  mdiHomeOutline,
  mdiAlphaTBoxOutline,
  mdiEyeOutline,
  mdiCreditCardOutline,
  mdiFileOutline,
  mdiFormSelect,
  mdiAccountCogOutline,
  mdiAccountMultiple,
  mdiCog,
  mdiDomain,
  mdiClipboardList,
  mdiFilePercent,
  mdiBookOpen,
  mdiAccountMultiplePlusOutline,
  mdiAccountCash,
  mdiAccountBoxMultiple,
  mdiTable,
} from '@mdi/js'
import NavMenuSectionTitle from './components/NavMenuSectionTitle.vue'
import NavMenuGroup from './components/NavMenuGroup.vue'
import NavMenuLink from './components/NavMenuLink.vue'

export default {
  components: {
    NavMenuSectionTitle,
    NavMenuGroup,
    NavMenuLink,
  },
  props: {
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  setup() {
    return {
      icons: {
        mdiHomeOutline,
        mdiAlphaTBoxOutline,
        mdiEyeOutline,
        mdiCreditCardOutline,
        mdiFileOutline,
        mdiFormSelect,
        mdiAccountCogOutline,
        mdiAccountMultiple,
        mdiCog,
        mdiDomain,
        mdiClipboardList,
        mdiFilePercent,
        mdiBookOpen,
        mdiAccountMultiplePlusOutline,
        mdiAccountCash,
        mdiAccountBoxMultiple,
        mdiTable,
      },
    }
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass/preset/mixins.scss';

.app-title {
  font-size: 1.25rem;
  font-weight: 700;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.3px;
}

// ? Adjust this `translateX` value to keep logo in center when vertical nav menu is collapsed (Value depends on your logo)
.app-logo {
  transition: all 0.18s ease-in-out;
  .v-navigation-drawer--mini-variant & {
    transform: translateX(-4px);
  }
}

@include theme(app-navigation-menu) using ($material) {
  background-color: map-deep-get($material, 'background');
}

.app-navigation-menu {
  .v-list-item {
    &.vertical-nav-menu-link {
      ::v-deep .v-list-item__icon {
        .v-icon {
          transition: none !important;
        }
      }
    }
  }
}

// You can remove below style
// Upgrade Banner
.app-navigation-menu {
  .upgrade-banner {
    position: absolute;
    bottom: 13px;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>
