import { apiClient } from 'ApiClients/main';
// Method HTTP pour gérer la ressource Appointment
export const appointment = {
  listAppointment () {
    return apiClient.get('/appointment');
  },
  getAppointment (id) {
    return apiClient.get(`/appointment/${id}`);
  },
  putAppointment (id, date) {
    return apiClient.put(`/appointment/${id}`, {
      date: date
    });
  },
  createAppointment (date, nom, prenom, email, telephone) {
    let form = new FormData();
    form.append('dateAppointment', date);
    form.append('nomUser', nom);
    form.append('prenomUser', prenom);
    form.append('emailUser', email);
    form.append('telephoneUser', telephone);
    return apiClient.post(`/appointment`, form);
  },
  deleteAppointment (id) {
    return apiClient.delete(`/appointment/${id}`);
  }
};
