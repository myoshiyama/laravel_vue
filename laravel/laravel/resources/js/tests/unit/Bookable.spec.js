import { mount } from '@vue/test-utils';
import flushPromises from 'flush-promises';

window.axios = require('axios');

import $route from '../../routes';
import { createStore } from 'vuex'
import storeDefinition from '../../store';
const $store = createStore(storeDefinition);
import Bookable from '../../bookable/Bookable.vue';

function createRootElem() {
  const elem = document.createElement('div');
  elem.id = 'app';
  return elem;
}

test('Bookable.vue', function () {
  const elem = createRootElem();

  const wrapper = mount(Bookable, {
    attachTo: elem,
    mocks: {},
    stubs: {},
    global: {
      plugins: [
        $store,
        $route,
      ],
    },
  });

  wrapper.vm.$nextTick(async function () {
    await flushPromises();

    // 画面に「杉山市 小部屋」というテキストが含まれているかを検証
    expect(wrapper.text()).toContain('杉山市 小部屋');

    done();
  })
});