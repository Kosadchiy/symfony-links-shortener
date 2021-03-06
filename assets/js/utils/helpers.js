import Cookies from 'js-cookie';

export const fillFormErrors = function (errors) {
  this.errors = {};
  errors.forEach(error => {
    const propertyPath = error.propertyPath.replace(/[\[\]']+/g, '');
    if (this.errors[propertyPath]) {
      this.errors[propertyPath].push(error.title);
    } else {
      this.errors[propertyPath] = [error.title];
    }
  });
}

export const isAuth = function () {
  return typeof Cookies.get('token') !== 'undefined';
}