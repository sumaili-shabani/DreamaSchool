<template>
    <div>
        <!-- debit -->
        <div class="card">
            <div class="card-body">
                <div class="profile-set">
                    <div class="profile-head">
                    </div>
                    <div class="profile-top text-center">
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
                            <div class="ms-auto" style="float: right;">

                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <span><b>Sexe:</b>{{ userData.sexe }}</span>
                    <span><b>N° de téléphone:</b> {{ userData.telephone }}</span>
                    <span><b>Adresse domicile: </b>{{ userData.adresse }}</span>

                </div>
            </div>
        </div>
        <!-- fin -->

    </div>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            title: "Basic",
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",
                name: "",
                email: "",
                password: "",
                // photo: "",
                sexe: "",
                avatar: "",
                telephone: "",
                adresse: "",
            },
            fetchData: null,
            titreModal: "",
        };
    },

    computed: {
        ...mapGetters(["userList", "isloading"]),
    },
    created() {
        this.editData(this.userData.id);
    },
    methods: {
        ...mapActions(["getUser"]),

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/showUser/${id}`).then(({ data }) => {
                var donnees = data.data;

                //   donnees.map((item) => {
                //     this.svData.name = item.name;
                //     this.svData.email = item.email;
                //     this.svData.sexe = item.sexe;
                //     this.svData.id_role = item.name;
                //     this.svData.id = item.user_id;
                //     this.titleComponent = "modification de " + item.name;
                //   });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },
    },
};
</script>
