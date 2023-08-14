<template>
  <q-page>
    <div class="main-page">
      <img src="/busca.png" v-show="emptyData"/>
      <img src="/vazio.png" v-show="data.length == 0 && emptyData == false"/>
      <div class="container row" v-show="data.length > 0 && emptyData == false" :key="refreshKey">
        <div v-for="i in data"
        class="q-pa-sm col-xs-12 col-sm-12 col-md-3 col-lg-3 q-col-gutter-sm" :key="i">
          <address-card-component
          :cep="i['cep']"
          :logradouro="i['logradouro']"
          :bairro="i['bairro']"
          :cidade="i['cidade']"
          :uf="i['uf']"
          class="cursor-pointer"
          @click="
            prompt_edit = true,
            prompt_modal = true,
            address.cep = i['cep'],
            address.logradouro = i['logradouro'],
            address.bairro = i['bairro'],
            address.cidade = i['cidade'],
            address.uf = i['uf']"
            />
        </div>
      </div>
    </div> 

    <!-- Add Address Sticky Button -->
    <q-page-sticky position="bottom-right" :offset="[20, 20]">
      <q-btn fab icon="add" color="primary" @click="prompt_add = true, prompt_modal = true" />
    </q-page-sticky>
 
    <!-- Address Modal -->
    <q-dialog v-model="prompt_modal" persistent>
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6" v-show="prompt_add">Cadastrar Endereço</div>
          <div class="text-h6" v-show="prompt_edit">Editar Endereço</div>
        </q-card-section>
        <q-form>
          <q-card-section class="q-pt-none">
            <q-input dense v-model="address.cep" autofocus label="CEP" />
            <q-input dense v-model="address.logradouro" label="Logradouro" />
            <q-input dense v-model="address.bairro" label="Bairro" />
            <q-input dense v-model="address.cidade" label="Cidade" />
            <q-input dense v-model="address.uf" label="UF" />
          </q-card-section> 
          <q-card-actions align="right" class="text-primary">
            <q-btn flat label="Apagar" color="red" v-show="prompt_edit" @click="confirmDialog"/>
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
import { addCep, editCep, removeCep } from 'src/services';
import { bus } from 'boot/eventbus';
import { Cep } from 'src/models/Cep';

export default defineComponent({
  name: 'IndexPage',
  components: { AddressCardComponent },
  setup () {
    const cepStore = useCepStore();
    const refreshKey = ref(0);
    const data = ref([] as Cep[]);
    const emptyData = ref(false);
    const address = ref({
      cep: '',
      logradouro: '',
      bairro: '',
      cidade: '',
      uf: ''
    })

    // Event listener to update the cards component
    bus.on('refreshEvent', async () => {
      if(cepStore.getResults.length == 0) {
        await cepStore.getAll();
      }
      data.value = cepStore.getResults;
      emptyData.value = cepStore.getEmptyResult;
      refreshKey.value += 1;
      cepStore.clearBuffer();
    });

    // Performs getAll when the page is refreshed
    (async () => {
      if (cepStore.getResults.length == 0) {
        await cepStore.getAll();
      }
      data.value = cepStore.getResults;
      cepStore.clearBuffer();
    })();
 
    // Address Actions
    async function addAddress() {
      const regexCep = RegExp(/^\d{5}-?\d{3}$/);
      if(regexCep.test(address.value.cep)) {
        const response = await addCep({
          cep: address.value.cep.replace('-', ''),
          logradouro: address.value.logradouro,
          bairro: address.value.bairro,
          cidade: address.value.cidade,
          uf: address.value.uf,
        });
        if(response.status == 201) {
          triggerPositive("Endereço cadastrado com sucesso.");
          bus.emit('refreshEvent');
        } else if(response.response.data.message == "Validation errors") {
          triggerNegative('Erro: Todos os campos são obrigatórios.');
        } else {
          triggerNegative('Erro: ' + response.response.data.message);
        }
      } else {
        triggerNegative('Erro: CEP inválido');
      }
    }
    async function editAddress() {
      const regexCep = RegExp(/^\d{5}-?\d{3}$/);
      if(regexCep.test(address.value.cep)) {
        const response = await editCep({
          cep: address.value.cep,
          logradouro: address.value.logradouro,
          bairro: address.value.bairro,
          cidade: address.value.cidade,
          uf: address.value.uf,
        });
        if(response.status == 200) {
          triggerPositive("Endereço alterado com sucesso.");
          bus.emit('refreshEvent');
        } else if(response.response.data.message == "Validation errors") {
          triggerNegative('Erro: Todos os campos são obrigatórios.');
        } else if(response.response.data.message == "Cep unknown in database") {
          triggerNegative('Erro: O CEP não existe no banco de dados.');
        } else {
          triggerNegative('Erro: ' + response.response.data.message);
        }
      } else {
        triggerNegative('Erro: CEP inválido');
      }
    }
    async function removeAddress() {
      const response = await removeCep(address.value.cep);
      if(response.status == 200) {
        triggerPositive("Endereço removido com sucesso.");
        bus.emit('refreshEvent');
      } else if(response.response.data.message == "Cep unknown in database") {
        triggerNegative('Erro: O CEP não existe no banco de dados.');
      } else {
        triggerNegative('Erro: ' + response.response.data.message);
      }
    }

    // Address Modal
    const prompt_modal = ref(false);
    const prompt_edit = ref(false);
    const prompt_add = ref(false);
    function resetModal() {
      prompt_edit.value = false;
      prompt_add.value = false;
      address.value.cep = '';
      address.value.logradouro = '';
      address.value.bairro = '';
      address.value.cidade = '';
      address.value.uf = '';
    }

    // Notify and Dialog
    const $q = useQuasar();
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
    function confirmDialog () {
      $q.dialog({
        title: 'Confirmar',
        message: 'Tem certeza que deseja apagar o endereço?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        removeAddress();
        prompt_modal.value = false;
        resetModal();
      })
    }

    return {
      refreshKey,
      data,
      emptyData,
      address,
      prompt_edit,
      prompt_add,
      prompt_modal,
      addAddress,
      editAddress,
      removeAddress,
      confirmDialog,
      resetModal,
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