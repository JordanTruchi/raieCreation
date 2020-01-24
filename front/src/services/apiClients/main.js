import axios from 'axios';
// serveur api
export const apiClient = axios.create({
  baseURL: `http://localhost/raieCreation/back/api`,
  withCredentials: false, // Default
  headers: {
    Accept: 'application/json'
  }
});
