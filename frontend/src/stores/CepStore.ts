import { defineStore } from 'pinia';
import { Cep } from 'src/models/Cep';
import { api } from 'boot/axios';

export const useCepStore = defineStore('cep', {
  state: () => ({
    isLoading: false,
    results: [] as Cep[],
  }),

  getters: {
    getResults(state) {
      return state.results;
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
          this.results.push(response.data.data);
        })
        .finally(() => {
          this.isLoading = false;
          // this.$router.push('search');
        });
    },
    async getByAddress(address: string) {
      this.isLoading = true;
      await api
        .get('/cep/search/' + address)
        .then((response) => {
          this.results.push(response.data.data);
        })
        .finally(() => {
          this.isLoading = false;
          // this.$router.push('search');
        });
    },
    clearBuffer() {
      this.results = [];
      console.log(this.results);
    },
  },
});
