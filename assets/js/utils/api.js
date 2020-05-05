import axios from 'axios';
import { errorMessage } from './message';
import getObjectValue from 'lodash/get';

export const post = async (endpoint, params = {}, onError = defaultErrorMessage) => {
  return await axios
    .post(endpoint, params)
    .then((response) => {
      return response;
    })
    .catch(onError);
};

export const defaultErrorMessage = ((error) => {
  console.log(error.response);
  
  const message = getObjectValue(
    error, 
    'response.data.message', 
    getObjectValue(error, 'response.data.title', 'Something went wrong =(')
  );
  errorMessage(message);
  return getObjectValue(error, 'response', null);
});
