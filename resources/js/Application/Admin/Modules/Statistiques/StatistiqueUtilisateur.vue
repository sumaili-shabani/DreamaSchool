<template>
    <div>

        <!-- debit -->
        <div class="row">

            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>{{ svData.NombreTotalUtilisateur }}</h4>
                        <h5>Total des utilisateurs</h5>
                    </div>
                    <div class="dash-imgs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4> {{ svData.NombreTotalUtilisateurM }}</h4>
                        <h5>Total des ut.hommes</h5>
                    </div>
                    <div class="dash-imgs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-user-check">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4>{{ svData.NombreTotalUtilisateurF }}</h4>
                        <h5>Total des Ut. Femmes</h5>
                    </div>
                    <div class="dash-imgs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <h4> {{ svData.NombreTotalRole }}</h4>
                        <h5>Nombre total de rôles</h5>
                    </div>
                    <div class="dash-imgs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-file">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                </div>
            </div>



            <!-- statistique -->
            <div class="col-lg-6 col-sm-12 col-12 d-flex">
                <dashRoleUsers v-bind:typechart="stat.typechart2" style="width: 100%;" />
            </div>

            <div class="col-lg-6 col-sm-12 col-12 d-flex">
                <dashRoleUsers v-bind:typechart="stat.typechart3" style="width: 100%;" />
            </div>
            <!-- fin statistique -->





        </div>
        <!-- fin -->



























        <!-- composent -->

    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import dashRoleUsers from "./dashRoleUsers.vue";
export default {
    components: {
        dashRoleUsers,
    },
    data() {
        return {
            titre: "Mon tableau de bord",
            team: [],
            query: "",
            dialog: false,
            loading: false,
            disabled: false,

            fav: false,
            stat: {
                options: null,
                series: null,
                typechart1: "line",
                typechart2: "area",
                typechart3: "bar",
                typechart4: "donut",
            },

            svData: {
                NombreTotalUtilisateur: "",
                NombreTotalUtilisateurM: "",
                NombreTotalUtilisateurF: "",
                NombreTotalRole: "",
            },

            sheet: false,

            picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),

            query: "",
            fetchData: null,
        };
    },
    created() {
        this.showCountNotification();
    },
    computed: {
        ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
        ...mapActions([
            "getPays",
            "getProvince",
            "getUser2",
            "getFormejuridique",
            "getSecteurList",
        ]),

        showCountNotification() {
            var id_user = this.userData.id;
            this.editOrFetch(`${this.apiBaseURL}/showCountDashbord`).then(
                ({ data }) => {
                    var donnees = data.data;

                    this.getSvData(this.svData, data.data[0]);
                }
            );
        },
    },
};
</script>
<style scoped>
#views {
    max-height: 470px;
    overflow: scroll;
}

#views2 {
    max-height: 250px;
    overflow: scroll;
}
</style>
