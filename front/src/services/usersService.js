import apiClient from 'ApiClients/main';
// Method HTTP pour gérer la ressource User
export default {
  list () {
    return apiClient.get('/users/');
  },
  get (id) {
    return apiClient.get(`/users/${id}`);
  },
  put (id, email, password) {
    return apiClient.put(`/users/${id}`, {
      email: email,
      password: password
    });
  },
  create (email, password) {
    return apiClient.post(`/users/`, {
      email: email,
      password: password
    });
  },
  delete (id) {
    return apiClient.delete(`/users/${id}`);
  }
};
