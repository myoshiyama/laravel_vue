import { mount } from '@vue/test-utils';
import flushPromises from 'flush-promises';

window.axios = require('axios');

import $route from '../../routes';
import { createStore } from 'vuex';
import storeDefinition from '../../store';
import Availability from '../../bookable/Availability.vue';

function createWrapper() {
  const elem = document.createElement('div');
  elem.id = 'app';

  const wrapper = mount(Availability, {
    attachTo: elem,
    mocks: {},
    stubs: {},
    global: {
      plugins: [
        createStore(storeDefinition),
        $route,
      ],
    },
  });

  return { elem, wrapper };
}

test('"予約状況確認" を確認', async () => {
  const { wrapper } = createWrapper();

  await wrapper.vm.$nextTick();
  await flushPromises();

  expect(wrapper.text()).toContain('予約状況確認');
});

test('"エラーテスト"が無いことを確認', async () => {
  const { wrapper } = createWrapper();

  await wrapper.vm.$nextTick();
  await flushPromises();

  expect(wrapper.text()).not.toContain('エラーテスト');
});