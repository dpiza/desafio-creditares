<template>
  <div>
    <q-card class="address-card">
        {{ logradouro }}<br>
        {{ bairro }}<br>
        {{ cidade }} - {{ uf }}<br>
        {{ cep }}<br>
    </q-card>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';

export default defineComponent({
  name: 'AddressCardComponent',
  props: {
    cep: {
      type: String,
      required: true
    },
    logradouro: {
      type: String,
      required: true
    },
    bairro: {
      type: String,
      required: true
    },
    cidade: {
      type: String,
      required: true
    },
    uf: {
      type: String,
      required: true
    }
  }
})

</script>
<style lang="scss">
.address-card {
  width: 250px;
  height: 118px;
  padding: 8px;
}

body {
  &.screen--xs, &.screen--sm {
    .address-card {
      width: 100%;
      height: 100%;
      padding: 8px;
    }
  }
}

</style>