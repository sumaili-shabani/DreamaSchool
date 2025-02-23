<template>
  <div class="text-center container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">{{ header }}</div>

          <div class="card-body">
            <v-overlay :value="overlay">
              <v-progress-circular
                indeterminate
                size="64"
              ></v-progress-circular>
            </v-overlay>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      header: "",
      overlay: true,
    };
  },

  watch: {
    overlay(val) {
      val &&
        setTimeout(() => {
          this.overlay = false;
        }, 3000);
    },
  },
  created() {
    this.checkConnected();
  },

  methods: {
    checkConnected() {
      if (this.userData.id_role == 1) {
        this.gotoPage("admin/dashbord");
      } else if (this.userData.id_role == 2) {
        this.gotoPage("user/dashbord");
      } else {
      }
    },
  },
};
</script>