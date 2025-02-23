<template>
  <v-card>

    <v-tabs orizontal>
      <v-tab>
        <v-icon left> mdi-lock </v-icon>
        La Securité de mon compte
      </v-tab>

      <!--item 1  -->
      <v-tab-item>
        <v-card flat>
          <v-card-text>

            <Mysecurity />
          </v-card-text>
        </v-card>
      </v-tab-item>
      <!-- fin item 1 -->


    </v-tabs>
  </v-card>
</template>

<script>
import Mysecurity from "./mysecurity.vue";

export default {
  components: {
    Mysecurity,

  },
  data() {
    return {
      title: "Securité",
    };
  },
  methods: {},
};
</script>
