<template>
  <q-layout view="hHh Lpr fFf">
    <q-header>
      <q-toolbar class="bg-white">
        <q-img width="101px" src="/icons/icon_cep.png"/>
      </q-toolbar>
      <img src="/london-1920-300.png" class="header-image"/>
      <q-bar dark>
        <div class="search-bar row no-wrap justify-center">
          <div class="input">
            <q-input
              rounded
              hide-bottom-space
              dense
              outlined
              bg-color="secondary"
              label="Buscar endereço"
            />
          </div>
          <div>
            <q-btn
            unelevated
            padding="11px"
            rounded
            color="secondary"
            text-color="primary"
            icon-right="search"
            />
          </div>
        </div>
      </q-bar >
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

const linksList = [
  {
    title: 'Docs',
    caption: 'quasar.dev',
    icon: 'school',
    link: 'https://quasar.dev'
  }
];

export default defineComponent({
  name: 'MainLayout',

  components: {
  },

  setup () {
    const leftDrawerOpen = ref(false)

    return {
      essentialLinks: linksList,
      leftDrawerOpen,
      toggleLeftDrawer () {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
});
</script>

<style lang="scss">
  .header-image {
    width: 100%;
    min-width: 600px;
    max-height: 300px;
    align-self:auto;
    display: block;
  }

  .input {
    width: 350px;
  }

  .search-bar {
    width: 100%;
  }

  .q-btn {
    height: 39px;
    margin-left: 2px;
  }

  .q-toolbar {
    max-width: 1140;
    height: 50px;
  }
  
  .q-bar {
    height:45px;
  }
</style>