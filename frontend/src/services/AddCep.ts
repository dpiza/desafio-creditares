import { api } from 'boot/axios';
import { Cep } from 'src/models/Cep';

export function addCep(address: Cep) {
  return api
    .post('/cep/' + address.cep, {
      cep: address.cep,
      logradouro: address.logradouro,
      bairro: address.bairro,
      cidade: address.cidade,
      uf: address.uf,
    })
    .then((response) => response)
    .catch((error) => error);
}
