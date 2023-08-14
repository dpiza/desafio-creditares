import { defineStore } from 'pinia';
import { Cep } from 'src/models/Cep';
import { api } from 'boot/axios';
import { bus } from 'boot/eventbus';

export const useCepStore = defineStore('cep', {
  state: () => ({
    emptyResult: false,
    isLoading: false,
    results: [] as Cep[],
  }),

  getters: {
    getResults(state) {
      return state.results;
    },
    getEmptyResult(state) {
      return state.emptyResult;
    },
  },

  actions: {
    async getAll() {
      this.isLoading = true;
      await api
        .get('/cep/')
        .then((response) => {
          this.results = response.data.data;
        })
        .finally(() => (this.isLoading = false));
    },
    async getByCep(cep: string) {
      this.isLoading = true;
      await api
        .get('/cep/' + cep)
        .then((response) => {
          this.results = response.data.data;
        })
        .finally(() => {
          this.isLoading = false;
          bus.emit('refreshEvent');
        });
    },
    async getByAddress(address: string) {
      this.isLoading = true;
      await api
        .get('/cep/search/' + address)
        .then((response) => {
          if (response.data.data[0]) {
            this.results = response.data.data;
          } else {
            this.emptyResult = true;
          }
        })
        .finally(() => {
          this.isLoading = false;
          bus.emit('refreshEvent');
        });
    },
    clearBuffer() {
      this.results = [];
      this.emptyResult = false;
    },
  },
});
