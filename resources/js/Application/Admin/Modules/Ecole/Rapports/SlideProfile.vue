<template>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12>
        <div class="mr-1">
          <v-card class="ma-5 text-center mt-12" shaped elevation="10">
            <v-avatar class="mt-n7" size="60" elevation="10">
              <img
                :src="
                  userData.avatar == null
                    ? `${baseURL}/images/avatar.png`
                    : `${baseURL}/images/` + userData.avatar
                "
              />
            </v-avatar>
            <v-card-title class="layout justify-center">{{
              userData.name
            }}</v-card-title>
            <v-card-subtitle class="layout justify-center"
              >{{ userData.adresse }}
            </v-card-subtitle>
            <v-list>
              <v-list-item>
                <v-list-item-title class="cyan--text text--darken-1"
                  >Email</v-list-item-title
                >
                <v-list-item-title class="cyan--text text--darken-1"
                  >Téléphone</v-list-item-title
                >
                <v-list-item-title class="cyan--text text--darken-1"
                  >Sexe</v-list-item-title
                >
              </v-list-item>
              <v-list-item class="mt-n5">
                <v-list-item-subtitle>{{ userData.email }}</v-list-item-subtitle>
                <v-list-item-subtitle>{{
                  userData.telephone
                }}</v-list-item-subtitle>
                <v-list-item-subtitle>{{ userData.sexe }}</v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-card>
        </div>
      </v-flex>

      <v-flex xs12 sm12 md12 lg12>
        <div class="mr-1">
          <v-toolbar flat color="rgba(0,0,0,0)" dense class="mt-1">
            <v-toolbar-title>Date</v-toolbar-title>

            <v-spacer></v-spacer>
            <span class="grey--text">Voir le calendrier</span>
          </v-toolbar>
          <div class="px-7 mb-5 col-md-12">
            <v-row row wrap>
              <v-flex xs12 sm12 md12 lg12>
                <!-- <statBlog v-bind:typechart="stat.typechart3" />    -->
                <v-date-picker
                  v-model="date2"
                  color="black"
                  class=""
                  width="100%"
                  :event-color="(date) => (date[9] % 2 ? 'red' : 'yellow')"
                  :events="functionEvents"
                >
                </v-date-picker>
              </v-flex>
            </v-row>
          </div>
        </div>
      </v-flex>
    </v-layout>
  </template>

  <script>
  const gradients = [
    ["#222"],
    ["#42b3f4"],
    ["red", "orange", "yellow"],
    ["purple", "violet"],
    ["#00c6ff", "#F0F", "#FF0"],
    ["#f72047", "#ffd200", "#1feaea"],
  ];
  export default {
    components: {},
    data() {
      return {
        fetchData: null,
        titreModal: "",
        drawer: null,
        gradient: gradients[5],
        gradientDirection: "top",
        gradients,
        fill: false,
        type: "trend",
        arrayEvents: null,
        date2: new Date().toISOString().substr(0, 10),
      };
    },
    methods:{

      functionEvents(date) {
        const [, , day] = date.split("-");
        if ([12, 17, 28].includes(parseInt(day, 10))) return true;
        if ([1, 19, 22].includes(parseInt(day, 10))) return ["red", "#00f"];
        return false;
      },

    },
    created() {},
  };
  </script>

