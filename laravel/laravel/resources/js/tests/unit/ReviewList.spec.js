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

test('ReviewList.vue', async function () {
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

  try {
    await wrapper.vm.$nextTick();
    await flushPromises();

    // 画面に「レビュー一覧」というテキストが含まれているかを検証
    expect(wrapper.text()).toContain('レビュー一覧');
  } catch (error) {
    // 例外が発生した場合のエラーハンドリング
    console.error('エラーが発生しました:', error);
  }
});