<template>
  <div class="text-center">

    <v-overlay :value="overlay">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
  </div>
</template>
<script>
  export default {
    data: () => ({
      overlay: true,
    }),

  }
</script>
