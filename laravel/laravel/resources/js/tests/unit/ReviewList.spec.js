import { mount } from '@vue/test-utils';
import flushPromises from 'flush-promises';

window.axios = require('axios');

import $route from '../../routes';
import { createStore } from 'vuex'
import storeDefinition from '../../store';
const $store = createStore(storeDefinition);
import ReviewList from '../../bookable/ReviewList.vue';

function createRootElem() {
  const elem = document.createElement('div');
  elem.id = 'app';
  return elem;
}

test('"レビュー一覧"が正しく表示されるか', async function () {
  const elem = createRootElem();

  const wrapper = mount(ReviewList, {
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

  await wrapper.vm.$nextTick();
  await flushPromises();

  expect(wrapper.text()).toContain('レビュー一覧');
});

const elem = null;
const wrapper = null;

test('例外テスト："エラーテスト"が表示されないか', async function () {
  const elem = createRootElem();

  const wrapper = mount(ReviewList, {
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

  await wrapper.vm.$nextTick();
  await flushPromises();

  expect(wrapper.text()).not.toContain('エラーテスト');
});
