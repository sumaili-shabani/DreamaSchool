<template>
  <v-menu bottom rounded offset-y transition="scale-transition">
    <template v-slot:activator="{ on }">
      <v-btn icon x-large v-on="on">
        <v-tooltip bottom color="black">
          <template v-slot:activator="{ on, attrs }">
            <span v-bind="attrs" v-on="on">
              <v-avatar size="48" color="rgb(183, 44, 44)">
                <span
                  class="white--text headline"
                  style="text-transform: lowercase"
                >
                  {{ teacher_name | subStr }}
                </span>
              </v-avatar>
            </span>
          </template>
          <span>Mon compte</span>
        </v-tooltip>
      </v-btn>
    </template>

    <v-card width="300">
      <v-card-text>
        <div style="text-align: center">
          <!-- <v-avatar size="60" color="rgb(183, 44, 44)">
            <span class="white--text headline">{{
              this.userData.name | subStr
            }}</span> </v-avatar
          >  -->

          <img
            style="border-radius: 50px; width: 50px; height: 50px"
            :src="
              this.userData.avatar == null
                ? `${baseURL}/images/avatar.png`
                : `${baseURL}/images/` + this.userData.avatar
            "
          />

          <!-- test -->

          <v-spacer></v-spacer>

          <v-menu bottom right>
            <template v-slot:activator="{ on, attrs }">
              <v-btn dark icon v-bind="attrs" v-on="on">
                <v-icon color="black">mdi-dots-vertical</v-icon>
              </v-btn>
            </template>

            <v-list elevation="20" rounded>
              <v-list-item v-for="(item, i) in items" :key="i" :to="item.href">
                <v-list-item-title>
                  <v-icon>{{ item.icon }}</v-icon> {{ item.title }}
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
          <!-- fin test -->

          <br />
          <b style="text-transform: lowercase">{{ this.userData.name }}</b>
          <br />
          {{ this.userData.email }}

          <!-- <v-btn :to="'/apps/profil/'+this.userData.teacher_id" small rounded outlined style="text-style:lowercase" >gérer mon compte school</v-btn> -->
          <br /><br />
          <v-divider></v-divider><br />
          <v-btn small outlined :href="`${this.baseURL}/logout`">
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
  created() {
    this.getInfoConnected();
  },
  data() {
    return {
      teacher_name: window.emerfine.user.name,
      items: [{ title: "Mon profil", href: "/admin/profil", icon: "person" }],
    };
  },
  methods: {
    getInfoConnected() {
      if (this.userData.id_role == 1) {
        this.items = [
          { title: "Mon profil", href: "/admin/profil", icon: "person" },
        ];
      } else {
         this.items = [
          { title: "Mon profil", href: "/user/profil", icon: "person" },
        ];
      }
      // console.log(window.emerfine.user);
    },
  },
  filters: {
    subStr(value) {
      if (value.length > 2) {
        return value.slice(0, 2).toLowerCase();
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