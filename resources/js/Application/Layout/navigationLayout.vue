<template>
  <!-- navigation 2 -->
  <!-- debit -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        <ul style="margin-left: -15px">
          <li v-for="(link, index) in linkAdmin.linkAdmin.links" :key="index">
            <RouterLink :to="link.href">
              <img
                :src="`${baseURL}/vuetheme/assets/img/icons/${link.icon}.svg`"
                alt="img"
              />
              <span> {{ link.text }}</span>
            </RouterLink>
          </li>
          <li
            class="submenu"
            v-for="list in linkAdmin.linkAdmin.listGroup"
            :key="list.text"
          >
            <a href="javascript:void(0);">
              <img
                :src="`${baseURL}/vuetheme/assets/img/icons/${list.icon}.svg`"
                alt="img"
              />
              <span> {{ list.text }}</span> <span class="menu-arrow"></span>
            </a>
            <ul>
              <li v-for="(link1, index2) in list.items" :key="index2">
                <RouterLink :to="link1.href">
                  <img
                    :src="`${baseURL}/vuetheme/assets/img/icons/${link1.icon}.svg`"
                    alt="img"
                  />
                  {{ link1.text }}
                </RouterLink>
              </li>
            </ul>
          </li>

          <li
            class="submenu"
            v-for="list in linkAdmin.linkAdmin.listGroupMenu"
            :key="list.text"
          >
            <a href="javascript:void(0);">
              <img
                :src="`${baseURL}/vuetheme/assets/img/icons/${list.icon}.svg`"
                alt="img"
              />
              <span> {{ list.text }}</span> <span class="menu-arrow"></span>
            </a>
            <ul>
              <li
                class="submenu"
                v-for="(list2, index3) in list.submenu"
                :key="index3"
              >
                <a href="javascript:void(0);">
                  <img
                    :src="`${baseURL}/vuetheme/assets/img/icons/${list2.icon}.svg`"
                    alt="img"
                  />
                  <span> {{ list2.text }}</span>
                  <span class="menu-arrow"></span>
                  <v-icon small>chevron_right</v-icon>
                </a>
                <ul>
                  <li v-for="(list3, index4) in list2.items" :key="index4">
                    <RouterLink :to="list3.href">
                      <img
                        :src="`${baseURL}/vuetheme/assets/img/icons/${list3.icon}.svg`"
                        alt="img"
                      />
                      {{ list3.text }}
                    </RouterLink>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <hr />
          <li>
            <a :href="`${this.baseURL}/logout`">
              <img
                :src="`${baseURL}/vuetheme/assets/img/icons/logout.svg`"
                alt="img"
              />
              <span>Déconnexion</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- fin --><!-- fin navigation 2 -->
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["linkAdmin"],
  components: {},
  data() {
    return {
      title: "Je suis une page!!!",
    };
  },
  computed: {
    ...mapGetters(["userList", "isloading"]),
  },
  methods: {
    ...mapActions(["getUser"]),
  },
  created() {},
};
</script>

<style scoped>
.sidebar-menu > ul > li a {
  text-decoration: none;
}

.sidebar .sidebar-menu > ul > li > a {
  padding: 10px 15px;
  position: relative;
  color: #212b36;
}

.v-icon.v-icon hover {
  color: #fff;
}
</style>
