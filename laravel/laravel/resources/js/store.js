export default {
  state:{
    lastSearch: {
      from: null,
      to: null
    }
  },
  nutations: {
    setLastSearch(state, payload) {
      state.lastSearch = payload;
    }
  }
};