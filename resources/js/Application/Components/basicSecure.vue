<template>




    <!-- debit -->
    <div class="card">
        <div class="card-body">
            <div class="profile-set">
                <div class="profile-head">
                </div>
                <div class="profile-top">
                    <div class="profile-content">
                        <div class="profile-contentimg">
                            <img :src="this.userData.avatar == null
                                ? `${baseURL}/images/avatar.png`
                                : `${baseURL}/images/` + this.userData.avatar
                                " alt="img" id="blah">
                            <div class="profileupload">

                                <a href="javascript:void(0);"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/edit-set.svg`" alt="img"></a>
                            </div>
                        </div>
                        <div class="profile-contentname">
                            <h2>{{ userData.name }}</h2>
                            <span style="color: blue;">{{ userData.email }}</span>
                            <a href="javascript:void(0)"
                                :class="userData.id_role == 1 ? 'btn btn-success btn-sm clear-noti' :
                                    userData.id_role == 2 ? 'btn btn-primary btn-sm clear-noti' : 'btn btn-default btn-sm clear-noti'"> {{
                                            userData.id_role | getRoleConnected }} </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">

                <v-tabs orizontal>
                    <v-tab>
                        <v-icon left>mdi-lock </v-icon>
                        La Sécurité de mon compte
                    </v-tab>
                    <!-- item 1 -->
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                <Mysecurity />
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <!-- fin -->


                </v-tabs>

            </div>
        </div>
    </div>
    <!-- fin -->










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
