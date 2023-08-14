<template>
  <div>
    <q-card v-show="db==true" class="address-card saved">
        {{ logradouro }}<br>
        {{ bairro }}<br>
        {{ cidade }} - {{ uf }}<br>
        {{ cep }}<br>
    </q-card>
    <q-card v-show="db==false" class="address-card not-saved">
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
    },
    db: {
      type: Boolean,
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

.saved {
  background: $saved;
}

.not-saved {
  background: $not-saved;
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