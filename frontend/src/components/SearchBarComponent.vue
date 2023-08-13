<template>
  <div class="bar">
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
  </div>
</template>

<script setup lang="ts">
import { ref} from 'vue';
import { useCepStore } from 'stores/CepStore';

const search = ref('');
const cepStore = useCepStore(); 

const regexCep = RegExp(/^\d{5}-?\d{3}$/);

async function submitSearch(){
  if (search.value && regexCep.test(search.value)) {
    await cepStore.getByCep(search.value.replace('-', ''))
    console.log(cepStore.getResults);
  }else {
    await cepStore.getByAddress(search.value)
    console.log(cepStore.getResults);
  }
};
</script>

<style lang="scss">
.input {
  width: 350px;
    border-color: $primary;
  .q-field--outlined:hover .q-field__control:before {
    border-color: $accent;
  }
}

.bar {
  background-color: $primary;
}

.search-bar {
  width: 100%;
}

.q-btn {
  height: 39px;
  margin-left: 2px;
}

.q-bar {
  height:45px;
}
</style>