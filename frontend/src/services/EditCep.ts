import { api } from 'boot/axios';
import { Cep } from 'src/models/Cep';

export function editCep(address: Cep) {
  return api
    .put('/cep/' + address.cep, {
      cep: address.cep,
      logradouro: address.logradouro,
      bairro: address.bairro,
      cidade: address.cidade,
      uf: address.uf,
    })
    .then((response) => response)
    .catch((error) => error);
}
