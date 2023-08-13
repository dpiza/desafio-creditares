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
      <search-bar-component/>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import SearchBarComponent from 'components/SearchBarComponent.vue';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'MainLayout',
  components: {SearchBarComponent},
});
</script>

<style lang="scss">

.q-item {
  padding-left: 0;
}

.q-toolbar {
  max-width: 1140;
  height: 50px;
}

.header-image {
  width: 100%;
  min-width: 600px;
  max-height: 300px;
  align-self:auto;
  display: block;
}

</style>