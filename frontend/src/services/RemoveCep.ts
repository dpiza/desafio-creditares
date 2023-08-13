import { api } from 'boot/axios';

export function removeCep(cep: string) {
  return api
    .delete('/cep/' + cep)
    .then((response) => response)
    .catch((error) => error);
}
