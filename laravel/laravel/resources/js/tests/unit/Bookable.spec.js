import { mount } from '@vue/test-utils';
import { createStore } from 'vuex';
import flushPromises from 'flush-promises';
import storeDefinition from '../../store';
import { createRouter, createWebHistory } from 'vue-router';
import { routes } from '../../routes';
import Bookable from '../../bookable/Bookable.vue';
import ReviewListStub from './ReviewList.stub';

jest.mock('axios', () => require('./Bookable.axiosMock'));

const vErrorsStub = {
  template: '<div></div>',
};

test('Bookable.vue', async () => {
  const router = createRouter({
    history: createWebHistory(),
    routes,
  });

  const store = createStore(storeDefinition);

  function createRootElem() {
    const elem = document.createElement('div');
    elem.id = 'app';
    return elem;
  }

  const elem = createRootElem();

  const app = mount(Bookable, {
    global: {
      plugins: [store, router],
      stubs: {
        'v-errors': vErrorsStub,
        'ReviewList': ReviewListStub,
      },
    },
  });

  await router.isReady();

  try {
    await app.vm.$nextTick();
    await flushPromises();

    expect(app.text()).toContain('杉山市 小部屋');
  } catch (error) {
    expect(error).toBeUndefined();
  }
});
