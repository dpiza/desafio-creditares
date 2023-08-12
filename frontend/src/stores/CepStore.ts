import { defineStore } from 'pinia';
import { Cep } from 'src/models/Cep';
import { api } from 'boot/axios';

export const useCepStore = defineStore('cep', {
  state: () => ({
    isLoading: false,
    results: [] as Cep[],
    counter: 0,
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
  },
});
