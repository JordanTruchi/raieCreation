<template>
  <div class="containAll">
    <v-app class="containAppointment">
      <div
        v-if="openForm"
        class="addAppointment"
      >
        <p>Date choisie <span>{{ dateSelected + ' ' + timeSelected }}</span></p>
        <input
          v-model="nomUser"
          type="text"
          placeholder="Votre nom"
          value=""
        >
        <input
          v-model="prenomUser"
          type="text"
          placeholder="Votre prénom"
          value=""
        >
        <input
          v-model="emailUser"
          type="text"
          placeholder="Votre email"
          value=""
        >
        <input
          v-model="telephoneUser"
          type="text"
          placeholder="Votre téléphone"
          value=""
        >
        <div
          class="buttonTest"
          @click="postEvent"
        >
          Réserver
        </div>
      </div>
      <v-row class="fill-height">
        <v-col>
          <v-sheet height="64">
            <v-toolbar
              flat
              color="white"
            >
              <v-btn
                outlined
                class="mr-4"
                color="grey darken-2"
                @click="setToday"
              >
                Today
              </v-btn>
              <div
                class="navigationButton"
                @click="prev"
              >
                Précedent
              </div>
              <div
                class="navigationButton"
                @click="next"
              >
                Suivant
              </div>
              <v-toolbar-title>{{ title }}</v-toolbar-title>
              <v-spacer />
            </v-toolbar>
          </v-sheet>
          <v-sheet height="600">
            <v-calendar
              ref="calendar"
              v-model="focus"
              color="primary"
              :events="events"
              event-color="red"
              :now="today"
              :type="type"
              @click:time="checkDate"
              @change="updateRange"
            />
          </v-sheet>
        </v-col>
      </v-row>
    </v-app>
  </div>
</template>

<script>
import { appointment } from '../services/appointmentService';

export default {
  components: {
  },
  data: function () {
    return {
      focus: '',
      type: 'day',
      start: null,
      end: null,
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      events: [],
      openForm: false,
      dateSelected: '',
      timeSelected: '',
      nomUser: '',
      prenomUser: '',
      emailUser: '',
      telephoneUser: ''
    };
  },
  computed: {
    title () {
      const { start, end } = this;
      if (!start || !end) {
        return '';
      }
      const startMonth = this.monthFormatter(start);
      const startYear = start.year;
      const startDay = start.day + this.nth(start.day);
      return `${startMonth} ${startDay} ${startYear}`;
    },
    monthFormatter () {
      return this.$refs.calendar.getFormatter({
        timeZone: 'UTC', month: 'long'
      });
    }
  },
  mounted () {
    // fonctionne mal
    appointment.listAppointment()
      .then(({ data: resList }) => {
        resList.forEach(res => {
          let { dateTime: goodDate } = res;
          goodDate = goodDate.slice(0, -3);
          let newD = new Date(goodDate.getTime() + 30 * 60000);
          this.events.push({
            name: res.nom + ' ' + res.prenom + ' ' + res.email + ' ' + res.telephone,
            start: res.dateTime,
            end: newD.getFullYear() + ' - ' + newD.getMonth() + ' - ' + newD.getDate() + ' - ' + newD.getHours() + ':' + newD.getMinutes()
          });
        });
      });
    this.$refs.calendar.checkChange();
  },
  methods: {
    viewDay ({ date }) {
      this.focus = date;
      this.type = 'day';
    },
    setToday () {
      this.focus = this.today;
    },
    checkDate (dateEntiere) {
      this.test = dateEntiere;
      this.dateSelected = dateEntiere.date;
      this.timeSelected = dateEntiere.time;
      this.openForm = true;
    },
    // Ajouter un évènement fonctionne mal
    postEvent () {
      this.openForm = false;
      let trueDate = this.dateSelected + ' ' + this.timeSelected;
      // durée du rendez-vous 30min --> a gérer via des catégories en back end à terme
      let endH = new Date(trueDate.getTime() + 30 * 60000);
      // js Date object ----> DateTime object sql
      // ajouter un rendez vous en bdd et un utilisateur s'il n'existe pas
      // ajoute le nouveau rdv dans le dom
      appointment.createAppointment(trueDate, this.nomUser, this.prenomUser, this.emailUser, this.telephoneUser)
        .then(({ data: resList }) => {
          this.events.push({
            name: this.nomUser + ' ' + this.prenomUser + ' ' + this.emailUser + ' ' + this.telephoneUser,
            start: this.dateSelected + ' ' + this.timeSelected,
            end: this.dateSelected + ' ' + endH.getHours() + ':' + endH.getMinutes()
          });
        });
    },
    // changer de page dans le calendrier
    // empêche les utilisateurs de regarder les rendez-vous d'hier
    // a factoriser // duplicata dans next()
    prev () {
      let diff = 0;
      let createToday = new Date(this.$refs.calendar.times.today.date);
      let lookingFor;
      if (this.$refs.calendar.value) {
        lookingFor = new Date(this.$refs.calendar.value);
      } else {
        lookingFor = new Date(this.$refs.calendar.times.today.date);
      }

      if (createToday && lookingFor) {
        diff = Math.round((lookingFor - createToday) / (1000 * 60 * 60 * 24));
      }
      console.log(createToday, lookingFor, diff);
      if (diff > 0 && diff) { this.$refs.calendar.prev(); }
    },
    // empêche les utilisateurs de regarder le calendrier plus de 7 jours à l'avance
    next () {
      let diff = 0;
      let createToday = new Date(this.$refs.calendar.times.today.date);
      let lookingFor;
      if (this.$refs.calendar.value) {
        lookingFor = new Date(this.$refs.calendar.value);
      } else {
        lookingFor = new Date();
      }
      console.log(createToday, lookingFor);
      if (createToday && lookingFor) {
        diff = Math.round((lookingFor - createToday) / (1000 * 60 * 60 * 24));
      }
      if (diff < 7) { this.$refs.calendar.next(); }
    },
    // quelques exemple de rdv par défaut
    updateRange ({ start, end }) {
      const events = [];
      let j = 24;
      for (let i = 0; i < 7; i++) {
        events.push({
          name: 'toto',
          start: '2020-01-' + j + ' 10:00',
          end: '2020-01-' + j + ' 10:30'
        });
        events.push({
          name: 'John',
          start: '2020-01-' + j + ' 12:30',
          end: '2020-01-' + j + ' 13:00'
        });
        events.push({
          name: 'tata',
          start: '2020-01-' + j + ' 15:00',
          end: '2020-01-' + j + ' 15:30'
        });
        events.push({
          name: 'titi',
          start: '2020-01-' + j + ' 17:30',
          end: '2020-01-' + j + ' 18:00'
        });
        j++;
      }

      this.start = start;
      this.end = end;
      this.events = events;
    },
    nth (d) {
      return d > 3 && d < 21
        ? 'th'
        : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10];
    }
  }
};
</script>
<style lang="scss" scoped>
@import 'Scss/home';
</style>
