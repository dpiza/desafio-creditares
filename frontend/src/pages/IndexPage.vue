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
          @click="prompt_edit = true, prompt = true,
            cep = i['cep'],
            logradouro = i['logradouro'],
            bairro = i['bairro'],
            cidade = i['cidade'],
            uf = i['uf']"/>
        </div>
      </div>
    </div> 

    <!-- Add Address Sticky Button -->
    <q-page-sticky position="bottom-right" :offset="[20, 20]">
      <q-btn fab icon="add" color="primary" @click="prompt_add = true, prompt = true" />
    </q-page-sticky>

    <!-- Add/Edit Address Modal -->
    <q-dialog v-model="prompt" persistent>
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6" v-show="prompt_add">Cadastrar Endereço</div>
          <div class="text-h6" v-show="prompt_edit">Editar Endereço</div>
        </q-card-section>

        <q-form
          @reset="onResetAdd">
          <q-card-section class="q-pt-none">

            <q-input dense v-model="cep" autofocus label="CEP" />
            <q-input dense v-model="logradouro" autofocus label="Logradouro" />
            <q-input dense v-model="bairro" autofocus label="Bairro" />
            <q-input dense v-model="cidade" autofocus label="Cidade" />
            <q-input dense v-model="uf" autofocus label="UF" />
          </q-card-section>
          
          <q-card-actions align="right" class="text-primary">
            <q-btn flat label="Apagar" color="red" v-show="prompt_edit" @click="confirm"/>
            <q-space />
            <q-btn flat label="Cancelar" v-close-popup @click="resetModal"/>
            <q-btn flat label="Salvar" v-show="prompt_add" v-close-popup @click="addAddress(),resetModal()"/>
            <q-btn flat label="Salvar" v-show="prompt_edit" v-close-popup @click="editAddress(),resetModal()"/>
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
import { addCep } from 'src/services/AddCep';
import { editCep } from 'src/services/EditCep';
import { removeCep } from 'src/services/RemoveCep';

export default defineComponent({
  name: 'IndexPage',
  components: { AddressCardComponent },
  setup () {
    const $q = useQuasar();

    const data = ref([]);

    const search = ref('');
    const cep = ref('');
    const logradouro = ref('');
    const bairro = ref('');
    const cidade = ref('');
    const uf = ref('');

    const edit_cep = ref('');
    const edit_logradouro = ref('');
    const edit_bairro = ref('');
    const edit_cidade = ref('');
    const edit_uf = ref('');

    const cepStore = useCepStore(); 

    (async () => {
      if (cepStore.getResults.length == 0) {
        await cepStore.getAll();
      }
      data.value = cepStore.getResults;
      cepStore.clearBuffer();
    })()

    async function addAddress() {
      const response = await addCep({
        cep: cep.value,
        logradouro: logradouro.value,
        bairro: bairro.value,
        cidade: cidade.value,
        uf: uf.value,
      });
      if(response.status == 201) {
        triggerPositive("Endereço cadastrado com sucesso.");
      } else {
        triggerNegative('Erro: ' + response.response.data.message);
      }
    }

    async function editAddress() {
      const response = await editCep({
        cep: cep.value,
        logradouro: logradouro.value,
        bairro: bairro.value,
        cidade: cidade.value,
        uf: uf.value,
      });
      if(response.status == 200) {
        triggerPositive("Endereço alterado com sucesso.");
      } else {
        triggerNegative('Erro: ' + response.response.data.message);
      }
    }

    async function removeAddress() {
      const response = await removeCep(cep.value);
      if(response.status == 200) {
        triggerPositive("Endereço removido com sucesso.");
      } else {
        console.log(response)
        triggerNegative('Erro: ' + response.response.data.message);
      }
    }

    function triggerPositive (message: string) {
      $q.notify({
        type: 'positive',
        message: message
      })
    }

    function triggerNegative (message: string) {
      $q.notify({
        type: 'negative',
        message: message
      })
    }

    function triggerWarning (message: string) {
      $q.notify({
        type: 'warning',
        message: message
      })
    }

    const prompt_edit = ref(false);
    const prompt_add = ref(false);
    const prompt = ref(false);

    function resetModal() {
      prompt_edit.value = false;
      prompt_add.value = false;
      cep.value = '';
      logradouro.value = '';
      bairro.value = '';
      cidade.value = '';
      uf.value = '';
    }

    function confirm () {
      $q.dialog({
        title: 'Confirmar',
        message: 'Tem certeza que deseja deletar o cep?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        removeAddress();
        prompt.value = false;
      })
    }

    return {
      resetModal,
      addAddress,
      editAddress,
      removeAddress,
      confirm,
      search,
      data,
      onClickEvent: Event,
      cep,
      logradouro,
      bairro,
      cidade,
      uf,
      edit_cep,
      edit_logradouro,
      edit_bairro,
      edit_cidade,
      edit_uf,
      prompt_edit,
      prompt_add,
      prompt,
      onResetAdd () {
        cep.value = null
        logradouro.value = null
        bairro.value = null
        cidade.value = null
        uf.value = null
      },
      async submitSearch(){
        if (search.value) {
          await cepStore.getByCep(search.value)
          console.log(cepStore.getResults);
        }
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