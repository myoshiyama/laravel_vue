import { mount } from '@vue/test-utils';
import flushPromises from 'flush-promises';
import PriceBreakdown from '../../bookable/PriceBreakdown.vue';

function createRootElem() {
  const elem = document.createElement('div');
  elem.id = 'app';
  return elem;
}

describe('PriceBreakdown.vue', () => {
  test('正しい価格の内訳を表示OK', async () => {
    const elem = createRootElem();

    const wrapper = mount(PriceBreakdown, {
      attachTo: elem,
      props: {
        price: {
          breakdown: { '1': 100, '2': 150 },
          total: 250
        }
      }
    });

    await flushPromises();

    // テキスト内に特定の文字列が含まれていることを確認
    expect(wrapper.text()).toContain('金額内訳');
    expect(wrapper.text()).toContain('100 x 1円');
    expect(wrapper.text()).toContain('150 x 2円');
    expect(wrapper.text()).toContain('合計250円');

  });

  test('価格データ欠落テスト', async () => {
    const elem = createRootElem();

    const wrapper = mount(PriceBreakdown, {
      attachTo: elem,
      props: {
        price: undefined
      }
    });

    await flushPromises();

    // エラーメッセージが表示されることを確認
    expect(wrapper.text()).toContain('エラー: 金額内訳が取得できません');
  });
});

