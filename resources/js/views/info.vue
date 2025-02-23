<template>
  <v-layout>
    <v-flex md12>
      <br /><br />
      <v-layout>
        <v-flex md1></v-flex>
        <v-flex md10>
          <v-layout>
            <v-flex md12>
              <v-card shaped elevation="0">
                <v-card-text>
                  <v-layout>
                    <v-col md="6" xs="12" cols="6">
                      <img
                        :src="this.baseURL + '/images/think.svg'"
                        alt="img"
                        style="height: 300px"
                      />
                    </v-col>
                    <v-col  md="6" xs="12" cols="6">
                      <h2 style="color: blue">
                        <v-btn color="primary" fab small text depressed>
                          <v-icon>info</v-icon> </v-btn
                        >Interdiction de barièrre sur base de privilège!
                      </h2>
                      <br />
                      <p style="font-size: 17px">
                        Désolez, vous ne pouvez pas accéder au contenue de cette
                        page.
                      </p>
                    </v-col>
                  </v-layout>
                </v-card-text>
              </v-card>
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex md1></v-flex>
      </v-layout>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  
}
</script>
