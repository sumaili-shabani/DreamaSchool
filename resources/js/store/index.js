import axios from "axios";
import { isNull } from "lodash";
const state = {
    apiBaseURL: window.emerfine.apiBaseURL,
    isLoading: false,

    // mes scripts
    userList: [],
    roleList: [],

    userType: isNull(window.emerfine.user)
        ? "null"
        : window.emerfine.user.user_type,
    //localisation
    paysList: [],
    provinceList: [],

    //ecole
    anneeList: [],
    classeList: [],
    sectionList: [],
    divisionList: [],
    eleveList:[],
    eleveInscritList:[],

    TrancheList:[],
    FraisList:[],
    MoisList:[
        {
            id:"9",
            designation:"Septembre"
        },

        {
            id:"10",
            designation:"Octombre"
        },
        {
            id:"11",
            designation:"Novembre"
        },
        {
            id:"12",
            designation:"Décembre"
        },
        {
            id:"01",
            designation:"Janvier"
        },
        {
            id:"02",
            designation:"Février"
        },
        {
            id:"03",
            designation:"Mars"
        },
        {
            id:"04",
            designation:"Avril"
        },
        {
            id:"05",
            designation:"Mai"
        },
        {
            id:"06",
            designation:"Juin"
        },
        {
            id:"07",
            designation:"Juillet"
        },
        {
            id:"08",
            designation:"Août"
        },
    ],

    CatProduct:[],
    fournisseurList:[],
    ModeList:[],
    compteDepenseList:[],
    compteList:[],

    //gestion de cotation
    PeriodeList:[],
    CatCoursList:[],
    CoursList:[],
    EnseignantList:[],



};

const getters = {
    isloading: (state) => state.isLoading,

    // mes scripts
    userList: (state) => state.userList,
    roleList: (state) => state.roleList,

    //localisation
    paysList: (state) => state.paysList,
    provinceList: (state) => state.provinceList,

    //ecole
    anneeList: (state) => state.anneeList,
    classeList: (state) => state.classeList,
    sectionList: (state) => state.sectionList,
    divisionList: (state) => state.divisionList,
    eleveList: (state) => state.eleveList,
    eleveInscritList: (state) => state.eleveInscritList,
    //paiement
    TrancheList: (state) => state.TrancheList,
    FraisList: (state) => state.FraisList,
    MoisList: (state) => state.MoisList,
    CatProduct: (state) => state.CatProduct,

    fournisseurList: (state) => state.fournisseurList,
    ModeList: (state) => state.ModeList,
    compteList: (state) => state.compteList,

    compteDepenseList: (state) => state.compteDepenseList,

    //gestion de cotation
    PeriodeList: (state) => state.PeriodeList,
    CatCoursList: (state) => state.CatCoursList,
    CoursList: (state) => state.CoursList,
    EnseignantList: (state) => state.EnseignantList,










};

const actions = {
    //mes scripts
    async getUser({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_user`)
            .then(({ data }) => {
                commit("SET_USER", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getRole({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_role`)
            .then(({ data }) => {
                commit("SET_ROLE", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    //localisation
    async getPays({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_pays_2`)
            .then(({ data }) => {
                commit("SET_PAYS", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getProvince({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_province_2`)
            .then(({ data }) => {
                commit("SET_PROVINCE", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    //ecole
    async getAnneeScollaire({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_anne_scollaire_2`)
            .then(({ data }) => {
                commit("SET_ANNEE_SCOLAIRE", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },
    async getClasse({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_classe_2`)
            .then(({ data }) => {
                commit("SET_CLASSE", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getSection({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_section_2`)
            .then(({ data }) => {
                commit("SET_SECTION", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },
    async getDivision({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_division_2`)
            .then(({ data }) => {
                commit("SET_DIVISION", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getEleveList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/getListEleve`)
            .then(({ data }) => {
                commit("SET_ELEVE_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },
    async getEleveInscritList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/getListEleveInscrits`)
            .then(({ data }) => {
                commit("SET_ELEVE_INSCRIT_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    //paiement
    async getTrancheList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_tranche_2`)
            .then(({ data }) => {
                commit("SET_TRANCHE_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getFraisList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_type_tranche_2`)
            .then(({ data }) => {
                commit("SET_FRAIS_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getMoisList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_mois_scolaire_2`)
            .then(({ data }) => {
                commit("SET_MOIS_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getCategory({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_categorie_produit_2`)
            .then(({ data }) => {
                commit("SET_CATPRODUCT_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getFournisseur({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_list_fournisseur`)
            .then(({ data }) => {
                commit("SET_Fournisseur_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    //gestion de recette
    async getModeList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_tconf_modepaie_2`)
            .then(({ data }) => {
                commit("SET_Mode_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getCompteList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_compte_entree`)
            .then(({ data }) => {
                commit("SET_CompteComptable_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getCompteDepenseList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_compte_sortie`)
            .then(({ data }) => {
                commit("SET_CompteSortie_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    //gestion de cotation
    async getPeriodeList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_periode_2`)
            .then(({ data }) => {
                commit("SET_PERIODE_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getCatCoursList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_cat_cours_2`)
            .then(({ data }) => {
                commit("SET_CAT_COURS_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getCoursList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_cours_2`)
            .then(({ data }) => {
                commit("SET_COURS_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getEnseignantList({ commit }) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/fetch_enseignant_2`)
            .then(({ data }) => {
                commit("SET_ENSEIGNANT_LIST", data.data);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },













};
//update data
const mutations = {
    SET_LOADING_STATUS: (state) => (state.isLoading = !state.isLoading),

    //mes scripts
    SET_USER: (state, userList) => (state.userList = userList),
    SET_ROLE: (state, roleList) => (state.roleList = roleList),

    //localisation
    SET_PAYS: (state, paysList) => (state.paysList = paysList),
    SET_PROVINCE: (state, provinceList) => (state.provinceList = provinceList),

    //ecole
    SET_ANNEE_SCOLAIRE: (state, anneeList) => (state.anneeList = anneeList),
    SET_CLASSE: (state, classeList) => (state.classeList = classeList),
    SET_SECTION: (state, sectionList) => (state.sectionList = sectionList),
    SET_DIVISION: (state, divisionList) => (state.divisionList = divisionList),
    SET_ELEVE_LIST: (state, eleveList) => (state.eleveList = eleveList),
    SET_ELEVE_INSCRIT_LIST: (state, eleveInscritList) => (state.eleveInscritList = eleveInscritList),

    //paiements
    SET_TRANCHE_LIST: (state, TrancheList) => (state.TrancheList = TrancheList),
    SET_FRAIS_LIST: (state, FraisList) => (state.FraisList = FraisList),

    SET_MOIS_LIST: (state, MoisList) => (state.MoisList = MoisList),

    //vente
    SET_CATPRODUCT_LIST: (state, CatProduct) => (state.CatProduct = CatProduct),
    SET_Fournisseur_LIST: (state, fournisseurList) => (state.fournisseurList = fournisseurList),

    //gestion de recette
    SET_Mode_LIST: (state, ModeList) => (state.ModeList = ModeList),
    SET_CompteComptable_LIST: (state, compteList) => (state.compteList = compteList),
    SET_CompteSortie_LIST: (state, compteDepenseList) => (state.compteDepenseList = compteDepenseList),

    //gestion de cotation
    SET_PERIODE_LIST: (state, PeriodeList) => (state.PeriodeList = PeriodeList),
    SET_CAT_COURS_LIST: (state, CatCoursList) => (state.CatCoursList = CatCoursList),
    SET_COURS_LIST: (state, CoursList) => (state.CoursList = CoursList),
    SET_ENSEIGNANT_LIST: (state, EnseignantList) => (state.EnseignantList = EnseignantList),










};

export default {
    state,
    getters,
    actions,
    mutations,
};
