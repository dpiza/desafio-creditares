import { boot } from 'quasar/wrappers';
import { EventBus } from 'quasar';

const bus = new EventBus();

// bus.on('SearchComplete', () => {
//   const { getResults } = useCepStore();

//   console.log(getResults);
// });

export default boot(async ({ app }) => {
  app.config.globalProperties.$bus = bus;
  app.provide('bus', bus);
});

export { bus };
