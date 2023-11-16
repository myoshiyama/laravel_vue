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

const createApp = async (textToCheck) => {
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
  await app.vm.$nextTick();
  await flushPromises();

  if (textToCheck === 'エラーテスト') {
    expect(app.text()).not.toContain(textToCheck);
  } else {
    expect(app.text()).toContain(textToCheck);
  }
};

test('杉山市 小部屋 が表示されるか', async () => {
  await createApp('杉山市 小部屋');
});

test('例外テスト：エラーテスト が表示されるか', async () => {
  await createApp('エラーテスト');
});
