<template>
  <q-page>
    <div class="main-page">
      <div class="container row">
        <div v-for="i in data"
        class="q-pa-sm col-xs-12 col-sm-12 col-md-3 col-lg-3 q-col-gutter-sm" :key="i">
          <address-card-component
          :cep="i['cep']"
          :logradouro="i['logradouro']"
          :bairro="i['bairro']"
          :cidade="i['cidade']"
          :uf="i['uf']"
          class="cursor-pointer"
          @click="prompt_edit = true,
            edit_cep = i['cep'],
            edit_logradouro = i['logradouro'],
            edit_bairro = i['bairro'],
            edit_cidade = i['cidade'],
            edit_uf = i['uf']"/>
        </div>
      </div>
    </div>

    <!-- Add Address Sticky Button -->
    <q-page-sticky position="bottom-right" :offset="[20, 20]">
      <q-btn fab icon="add" color="primary" @click="prompt_add = true" />
    </q-page-sticky>

    <!-- Add Address Modal -->
    <q-dialog v-model="prompt_add" persistent>
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">Cadastrar Endereço</div>
        </q-card-section>

        <q-form
          @reset="onResetAdd">
          <q-card-section class="q-pt-none">

            <q-input dense v-model="add_cep" autofocus label="CEP" />
            <q-input dense v-model="add_logradouro" autofocus label="Logradouro" />
            <q-input dense v-model="add_bairro" autofocus label="Bairro" />
            <q-input dense v-model="add_cidade" autofocus label="Cidade" />
            <q-input dense v-model="add_uf" autofocus label="UF" />
          </q-card-section>
          
          <q-card-actions align="right" class="text-primary">
            <q-btn flat label="Cancelar" v-close-popup type="reset"/>
            <q-btn flat label="Salvar" v-close-popup />
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>

    <!-- Modify Address Modal -->
    <q-dialog v-model="prompt_edit" persistent>
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">Editar Endereço</div>
        </q-card-section>

        <q-form>
          <q-card-section class="q-pt-none">

            <q-input dense v-model="edit_cep" autofocus label="CEP" />
            <q-input dense v-model="edit_logradouro" autofocus label="Logradouro" />
            <q-input dense v-model="edit_bairro" autofocus label="Bairro" />
            <q-input dense v-model="edit_cidade" autofocus label="Cidade" />
            <q-input dense v-model="edit_uf" autofocus label="UF" />
          </q-card-section>
          
          <q-card-actions align="right" class="text-primary">
            <q-btn flat label="Cancelar" v-close-popup/>
            <q-btn flat label="Salvar" v-close-popup @click="triggerPositive"/>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>

  </q-page>
</template>

<script lang="ts">
import AddressCardComponent from 'components/AddressCardComponent.vue';
import { useQuasar } from 'quasar';
import { defineComponent, ref } from 'vue';
import { useCepStore } from 'stores/CepStore';

export default defineComponent({
  name: 'IndexPage',
  components: { AddressCardComponent },
  setup () {
    const $q = useQuasar();

    const data = ref([]);

    const add_cep = ref('');
    const add_logradouro = ref('');
    const add_bairro = ref('');
    const add_cidade = ref('');
    const add_uf = ref('');

    const edit_cep = ref('');
    const edit_logradouro = ref('');
    const edit_bairro = ref('');
    const edit_cidade = ref('');
    const edit_uf = ref('');

    const cepStore = useCepStore(); 

    (async () => {
      await cepStore.getAll();
      data.value = cepStore.getResults;
    })()


    return {
      data,
      onClickEvent: Event,
      add_cep,
      add_logradouro,
      add_bairro,
      add_cidade,
      add_uf,
      edit_cep,
      edit_logradouro,
      edit_bairro,
      edit_cidade,
      edit_uf,
      prompt_edit: ref(false),
      prompt_add: ref(false),
      onResetAdd () {
        add_cep.value = null
        add_logradouro.value = null
        add_bairro.value = null
        add_cidade.value = null
        add_uf.value = null
      },
      triggerPositive () {
        $q.notify({
          type: 'positive',
          message: 'This is a "positive" type notification.'
        })
      },

      triggerNegative () {
        $q.notify({
          type: 'negative',
          message: 'This is a "negative" type notification.'
        })
      },

      triggerWarning () {
        $q.notify({
          type: 'warning',
          message: 'This is a "warning" type notification.'
        })
      }
    }
  }
});
</script>

<style lang="scss">
.main-page {
  width: 100%;
  display: flex;
  justify-content: space-evenly;
  align-content: center;
}

.container {
  min-width: 1100px;
  max-width: 1140px;
  padding: 16px 16px;
}

body {
  &.screen--xs, &.screen--sm {
    .container {
        min-width: 100%;
        max-width: 100%;
        padding: 0;
    }
  }
}

</style>