import { Message } from 'element-ui';

export const errorMessage = (text) => {
  Message({
    showClose: true,
    message: text,
    type: 'error'
  });
};

export const successMessage = (text) => {
  Message({
    showClose: true,
    message: text,
    type: 'success'
  });
};