// import axios from 'axios';

// const mockResponse = {
//   data: {
//     data: {
//       title: '杉山市 小部屋',
//     },
//   },
// };

// export default {
//   get: jest.fn(() => Promise.resolve(mockResponse)),
// };

// jest.mock('axios', () => ({
//   create: jest.fn(() => require('./Bookable.axiosMock')),
// }));


export default {
  get: jest.fn(() => Promise.resolve({ data: { data: { title: '杉山市 小部屋' },}, },)),
};