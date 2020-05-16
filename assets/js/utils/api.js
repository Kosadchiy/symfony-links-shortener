import axios from 'axios';
import { errorMessage } from './message';
import getObjectValue from 'lodash/get';
import Cookies from 'js-cookie';

const getAuthHeader = () => {  
  const token = Cookies.get('token');
  if (token) {
    return {
      Authorization: `Bearer ${token}`
    }
  }
  return;
}

export const post = async (endpoint, params = {}, onError = defaultErrorMessage) => {
  return await axios
    .post(endpoint, params, { headers: getAuthHeader() })
    .then((response) => {
      return response;
    })
    .catch(onError);
};

export const get = async (endpoint, params = {}, onError = defaultErrorMessage) => {
  return await axios
    .get(endpoint, { headers: getAuthHeader(), ...params })
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
