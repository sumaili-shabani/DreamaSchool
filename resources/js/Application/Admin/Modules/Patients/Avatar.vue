<template>
    <v-menu bottom rounded offset-y transition="scale-transition">
      <template v-slot:activator="{ on }">
        <v-btn icon x-large v-on="on">
         
          <v-tooltip bottom color="black">
            <template v-slot:activator="{ on, attrs }" >
              
                <span v-bind="attrs" v-on="on">
                  <v-avatar size="48" color="rgb(183, 44, 44)">
                    <span
                      class="white--text headline"
                      style="text-transform: lowercase"
                    >
                      {{ userData.name | subStr }}
                    </span>
                  </v-avatar>
                </span>
             
            </template>
            <span>Mon comptes</span>
          </v-tooltip>
          
        </v-btn>
      </template>
      <v-card width="300">
        <v-card-text>
          <div style="text-align: center">
            <v-avatar size="60" color="rgb(183, 44, 44)">
              <span class="white--text headline">{{
               userData.name  | subStr
              }}</span> </v-avatar
            ><br />
            <b style="text-transform: lowercase">{{
              userData.name 
            }}</b>
            <br />
            {{ userData.email  }}
  
            <!-- <v-btn :to="'/apps/profil/'+this.userData.teacher_id" small rounded outlined style="text-style:lowercase" >gérer mon compte school</v-btn> -->
            <br /><br />
            <v-divider></v-divider><br />
            <v-btn small outlined :href="`/logout`">
              <v-icon>exit_to_app</v-icon>
              déconnexion
            </v-btn>
          </div>
        </v-card-text>
      </v-card>
    </v-menu>
  </template>
  <script>
  export default {
    data() {
      return {
        teacher_name: 'Maley Glodi',
        email:"glodimaley@gmail.com",
      };
    },
    filters: {
      subStr(value) {
        if (value.length > 2) {
          return value.slice(0, 1).toLowerCase();
        } else {
          return value;
        }
      },
      LowerCase(value) {
        return value.toLowerCase();
      },
    },
  };
  </script>