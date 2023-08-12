<template>
  <q-layout view="hHh Lpr fFf">
    <q-header>
      <q-toolbar class="bg-white">
        <q-item clickable tag="home" href="#">
          <q-img width="110px" src="/icons/icon_cepdb.png" href="#"/>
        </q-item>
      </q-toolbar>
      <img
        class="header-image"  
        src="/london-1920-300.png"
        />
      <q-bar dark>
        <div class="search-bar row no-wrap justify-center">
          <div class="input">
            <q-input
              clearable
              rounded
              dense
              outlined
              bg-color="secondary"
              label="Buscar endereço"
              v-model="search"
              @keydown.enter="submitSearch"
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
            @click="submitSearch"
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

export default defineComponent({
  name: 'MainLayout',

  components: {
  },

  setup () {
    const search = ref('')
    return {
      search,
      submitSearch(){
        search.value && console.log(search.value);
      }
    }
  }
});
</script>

<style lang="scss">

.q-item {
  padding-left: 0;
}

.header-image {
  width: 100%;
  min-width: 600px;
  max-height: 300px;
  align-self:auto;
  display: block;
}

.input {
  width: 350px;
    border-color: $primary;
  .q-field--outlined:hover .q-field__control:before {
    border-color: $accent;
  }
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