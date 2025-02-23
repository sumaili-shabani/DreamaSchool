<template>
    <div data-app>
        <!-- debit -->
        <div class="main-wrapper">
            <!-- header -->
            <NavMenu />
            <!-- Fin header -->

            <!-- slideBar -->
            <NavigationLayout :linkAdmin="linkAdmin" />
            <!-- fin slider -->

            <!-- router here -->

            <div class="page-wrapper pagehead">
                <div class="content">
                    <transition name="fade" mode="out-in">
                        <router-view></router-view>
                    </transition>
                </div>
            </div>
            <!-- router here -->
        </div>
        <!-- fin -->
    </div>
</template>
<script>
import NavMenu from "../Application/Layout/NavMenu.vue";
import NavigationLayout from "../Application/Layout/navigationLayout.vue";

export default {
    components: {
        NavMenu,
        NavigationLayout,
    },
    data() {
        return {
            linkAdmin: [],
        };
    },
    methods: {
        testLink() {
            if (this.userData.id_role == 1) {
                this.linkAdmin = {
                    linkAdmin: {
                        links: [
                            {
                                icon: "dashboard",
                                text: "Tableau de bord",
                                href: "/admin/dashboard",
                            },

                            {
                                icon: "event",
                                text: "Calendrier",
                                href: "/admin/page_event",
                            },
                        ],

                        listGroup: [
                            {
                                text: "Reception",
                                icon: "room_preferences",
                                items: [
                                    {
                                        icon: "person",
                                        text: "Elève",
                                        href: "/admin/eleve",
                                    },
                                    {
                                        icon: "data_table",
                                        text: "Inscription",
                                        href: "/admin/inscription",
                                    },
                                    {
                                        icon: "credit_card_gear",
                                        text: "Présences",
                                        href: "/admin/presence",
                                    },
                                    {
                                        icon: "transfer1",
                                        text: "Clauture d'Effectif",
                                        href: "/admin/clauture_effectif",
                                    },
                                ],
                            },

                            {
                                text: "Gestion de stock",
                                icon: "store",
                                items: [
                                    {
                                        icon: "product",
                                        text: "Produits",
                                        href: "/admin/Produits",
                                    },
                                    {
                                        icon: "shopping_cart",
                                        text: "Ventes",
                                        href: "/admin/VenteEnteteVente",
                                    },
                                    {
                                        icon: "shopping_bag",
                                        text: "Approvisionnement",
                                        href: "/admin/VenteEnteteEntree",
                                    },
                                    {
                                        icon: "wallet",
                                        text: "Etat de Besoin",
                                        href: "/admin/VenteEnteteCommande",
                                    },


                                    {
                                        icon: "description",
                                        text: "Rapports de stock",
                                        href: "/admin/RapportsJour_Vente",
                                    },

                                ],
                            },

                            {
                                text: "Statistiques",
                                icon: "area_chart",
                                items: [
                                    {
                                        icon: "insert_chart",
                                        text: "Elèves",
                                        href: "/admin/StatistqueEleve",
                                    },
                                    {
                                        icon: "insert_chart",
                                        text: "Finances",
                                        href: "/admin/StatistiqueFinance",
                                    },
                                    {
                                        icon: "insert_chart",
                                        text: "Utilisateurs",
                                        href: "/admin/statistique_user",
                                    },
                                ],
                            },
                            {
                                text: "Rapports",
                                icon: "time",
                                items: [

                                    {
                                        icon: "data_table",
                                        text: "Rap sur Inscription",
                                        href: "/admin/rapport_inscription",
                                    },

                                    {
                                        icon: "credit_card",
                                        text: "Rap sur Paiement",
                                        href: "/admin/rapport_paiement",
                                    },

                                    {
                                        icon: "payments",
                                        text: "Rap Comptabilité",
                                        href: "/admin/RapportsComptabilite"
                                    },
                                    {
                                        icon: "description",
                                        text: "Rap Rec/Depenses",
                                        href: "/admin/RapportsJour_Caisse"
                                    },

                                    {
                                        icon: "printer",
                                        text: "Rap de scolarité",
                                        href: "/admin/resultat_scolaire"
                                    },


                                ],
                            },
                        ],
                        listGroupMenu: [
                            {
                                text: "Gestion des cours",
                                icon: "school",
                                submenu: [
                                    {
                                        text: "Planification de cours",
                                        icon: "event",
                                        items: [
                                            {
                                                icon: "time",
                                                text: "Périodicité",
                                                href: "/admin/periode",
                                            },
                                            {
                                                icon: "category",
                                                text: "Catégorie de cours",
                                                href: "/admin/category_cours",
                                            },
                                            {
                                                icon: "places",
                                                text: "Cours",
                                                href: "/admin/cours",
                                            },
                                        ],
                                    },

                                    {
                                        text: "Attributtions de cours",
                                        icon: "work",
                                        items: [
                                            {
                                                icon: "group",
                                                text: "Ensignants",
                                                href: "/admin/enseignants",
                                            },
                                            {
                                                icon: "dataset",
                                                text: "Attribution cours",
                                                href: "/admin/attribution_cours",
                                            },
                                            {
                                                icon: "description",
                                                text: "Cotation de cours",
                                                href: "/admin/cotations",
                                            },
                                        ],
                                    },
                                ],
                            },

                            {
                                text: "Finances",
                                icon: "wallet1",
                                submenu: [
                                    {
                                        text: "Flux d'opération",
                                        icon: "settings_applications",
                                        items: [
                                            {
                                                icon: "payments",
                                                text: "Paiement",
                                                href: "/admin/finances_paiement",
                                            },
                                            {
                                                icon: "business_center",
                                                text: "Recettes",
                                                href: "/admin/recette",
                                            },
                                            {
                                                icon: "card_membership",
                                                text: "Depenses",
                                                href: "/admin/depenseAll",
                                            },
                                        ],
                                    },

                                    {
                                        text: "Comptabilité",
                                        icon: "work",
                                        items: [
                                            {
                                                icon: "transcation",
                                                text: "Cloture de la Caisse",
                                                href: "/admin/Cloture_Caisse",
                                            },
                                            {
                                                icon: "event",
                                                text: "Comptabilité(Opé.)",
                                                href: "/admin/EnteteOperationComptable",
                                            },
                                            {
                                                icon: "event_available",
                                                text: "Cloture de la Comptabilité",
                                                href: "/admin/ClotureComptabilite",
                                            },
                                        ],
                                    },
                                ],
                            },


                            {
                                text: "Configurations",
                                icon: "credit_card_gear",
                                submenu: [
                                    {
                                        text: "Scolarité",
                                        icon: "box",
                                        items: [
                                            {
                                                icon: "api",
                                                text: "Année scolaire",
                                                href: "/admin/annee_scolaire",
                                            },

                                            {
                                                icon: "api",
                                                text: "Classes",
                                                href: "/admin/classes",
                                            },
                                            {
                                                icon: "api",
                                                text: "Options",
                                                href: "/admin/options",
                                            },
                                            {
                                                icon: "api",
                                                text: "Sections",
                                                href: "/admin/sections",
                                            },
                                            {
                                                icon: "api",
                                                text: "Divisions",
                                                href: "/admin/divisions",
                                            },
                                            {
                                                icon: "event",
                                                text: "Mois scolaires",
                                                href: "/admin/mois_scolaire",
                                            },
                                        ],
                                    },
                                    {
                                        text: "Localisation",
                                        icon: "expense1",

                                        items: [
                                            {
                                                icon: "api",
                                                text: "Pays",
                                                href: "/admin/pays",
                                            },
                                            {
                                                icon: "api",
                                                text: "Provinces",
                                                href: "/admin/provinces",
                                            },

                                            {
                                                icon: "api",
                                                text: "Chef lieu",
                                                href: "/admin/ville",
                                            },
                                            {
                                                icon: "api",
                                                text: "Commune",
                                                href: "/admin/commune",
                                            },

                                            {
                                                icon: "api",
                                                text: "Quartier",
                                                href: "/admin/quartier",
                                            },

                                            {
                                                icon: "api",
                                                text: "Avenue",
                                                href: "/admin/avenue",
                                            },
                                        ],
                                    },
                                    {
                                        text: "Paiement frais",
                                        icon: "cases",
                                        items: [
                                            {
                                                icon: "bid_landscape",
                                                text: "Tranche",
                                                href: "/admin/paiement_tranche",
                                            },
                                            {
                                                icon: "card_membership",
                                                text: "Frais",
                                                href: "/admin/paiement_frais",
                                            },
                                            {
                                                icon: "corporate_fare",
                                                text: "Prevision",
                                                href: "/admin/paiement_prevision",
                                            },
                                        ],
                                    },

                                    {
                                        text: "Finance-Compté",
                                        icon: "payments",
                                        items: [
                                            {
                                                icon: "api",
                                                text: "Classes",
                                                href: "/admin/ClassesFin",
                                            },
                                            {
                                                icon: "api",
                                                text: "Comptes",
                                                href: "/admin/CompteFin",
                                            },
                                            {
                                                icon: "api",
                                                text: "Sous Comptes",
                                                href: "/admin/SousCompte",
                                            },
                                            {
                                                icon: "api",
                                                text: "SSous Comptes",
                                                href: "/admin/SSousCompte",
                                            },
                                            {
                                                icon: "api",
                                                text: "Type Compte",
                                                href: "/admin/TypeCompte",
                                            },
                                            {
                                                icon: "api",
                                                text: "Config. Taux",
                                                href: "/admin/TTaux",
                                            },
                                            {
                                                icon: "api",
                                                text: "Type Position",
                                                href: "/admin/TypePosition",
                                            },
                                            {
                                                icon: "api",
                                                text: "Type Opération",
                                                href: "/admin/TypeOperation",
                                            },
                                            {
                                                icon: "api",
                                                text: "Rubriques",
                                                href: "/admin/Comptes",
                                            },
                                            {
                                                icon: "api",
                                                text: "Caisse&Banque",
                                                href: "/admin/Banque",
                                            },
                                            {
                                                icon: "api",
                                                text: "ModePaie",
                                                href: "/admin/modepaie",
                                            }
                                            // {
                                            //   icon: "groups",
                                            //   text: "Services Treseorerie",
                                            //   href: "/admin/Provenance",
                                            // },
                                            // {
                                            //   icon: "groups",
                                            //   text: "Cat. Rubriques",
                                            //   href: "/admin/CategorieRubrique",
                                            // },
                                            // {
                                            //   icon: "groups",
                                            //   text: "Rubriques Depenses",
                                            //   href: "/admin/Rubriques",
                                            // },
                                            // {
                                            //   icon: "groups",
                                            //   text: "Blocs",
                                            //   href: "/admin/Blocs",
                                            // }

                                        ],
                                    },

                                    {
                                        text: "Trésorerie",
                                        icon: "box",
                                        items: [
                                            {
                                                icon: "api",
                                                text: "Rubriques Depenses",
                                                href: "/admin/Comptes",
                                            },
                                            {
                                                icon: "api",
                                                text: "Cat.Rubriques EB",
                                                href: "/admin/CategorieRubrique",
                                            },
                                            {
                                                icon: "api",
                                                text: "Rubriques EB",
                                                href: "/admin/Rubriques",
                                            },
                                            {
                                                icon: "api",
                                                text: "Blocs(Finances)",
                                                href: "/admin/Blocs",
                                            },
                                            {
                                                icon: "api",
                                                text: "Services(Finances)",
                                                href: "/admin/Provenance",
                                            }
                                        ],
                                    },

                                    {
                                        text: "Ventes & Stock",
                                        icon: "conveyor_belt",
                                        items: [
                                            {
                                                icon: "category",
                                                text: "CatégorieProduit",
                                                href: "/admin/CategorieProduit",
                                            },
                                            {
                                                icon: "groups",
                                                text: "Fournisseurs",
                                                href: "/admin/Fournisseur",
                                            }
                                        ],
                                    },
                                ],
                            },

                            {
                                text: "Paramètrage",
                                icon: "settings",
                                submenu: [
                                    {
                                        text: "Systèmes",
                                        icon: "settings_applications",
                                        items: [
                                            {
                                                icon: "domain",
                                                text: "Application",
                                                href: "/admin/configure_site",
                                            },
                                        ],
                                    },

                                    {
                                        text: "Comptes",
                                        icon: "credit_card_gear",
                                        items: [
                                            {
                                                icon: "group",
                                                text: "utilisateur",
                                                href: "/admin/compte",
                                            },
                                            {
                                                icon: "settings",
                                                text: "Privilège",
                                                href: "/admin/role",
                                            },
                                        ],
                                    },
                                ],
                            },
                        ],
                    },
                };
            } else if (this.userData.id_role == 2) {
                this.linkAdmin = {
                    linkAdmin: {
                        links: [
                            {
                                icon: "dashboard",
                                text: "Tableau de bord",
                                href: "/user/dashboard",
                            },
                            {
                                icon: "time",
                                text: "Rapport",
                                href: "/user/page_rapport",
                            },
                            {
                                icon: "event",
                                text: "Calendrier",
                                href: "/user/page_event",
                            },
                        ],

                        listGroup: [
                            {
                                text: "Statistiques",
                                icon: "area_chart",
                                items: [
                                    {
                                        icon: "insert_chart",
                                        text: "Statistique sur Les utilisateur",
                                        href: "/user/statistique_user",
                                    },
                                ],
                            },
                        ],
                        listGroupMenu: [
                            {
                                text: "Configurations",
                                icon: "credit_card_gear",
                                submenu: [
                                    {
                                        text: "Configurations",
                                        icon: "box",
                                        items: [
                                            {
                                                icon: "data_table",
                                                text: "Configurations 1",
                                                href: "/user/operation_configuration_1",
                                            },

                                            {
                                                icon: "api",
                                                text: "Configurations 2",
                                                href: "/user/operation_configuration_2",
                                            },
                                        ],
                                    },
                                    {
                                        text: "Autorisation",
                                        icon: "conveyor_belt",
                                        items: [
                                            {
                                                icon: "api",
                                                text: "Autorisation 1",
                                                href: "/user/operation_aut_1",
                                            },

                                            {
                                                icon: "api",
                                                text: "Autorisation 2",
                                                href: "/user/operation_aut_2",
                                            },
                                        ],
                                    },
                                ],
                            },

                            {
                                text: "Paramètrage",
                                icon: "settings",
                                submenu: [
                                    {
                                        text: "Comptes",
                                        icon: "credit_card_gear",
                                        items: [
                                            {
                                                icon: "person",
                                                text: "Mon profil",
                                                href: "/user/profil",
                                            },
                                            {
                                                icon: "lock",
                                                text: "Sécurité",
                                                href: "/user/security",
                                            },
                                        ],
                                    },
                                ],
                            },
                        ],
                    },
                };
            } else if (this.userData.id_role == 3) {
                this.linkAdmin = {
                    linkAdmin: {
                        links: [
                            {
                                icon: "dashboard",
                                text: "Tableau de bord",
                                href: "/entreprise/dashboard",
                            },
                            {
                                icon: "time",
                                text: "Rapport",
                                href: "/entreprise/page_rapport",
                            },
                            {
                                icon: "event",
                                text: "Calendrier",
                                href: "/entreprise/page_event",
                            },
                        ],

                        listGroup: [
                            {
                                text: "Statistiques",
                                icon: "area_chart",
                                items: [
                                    {
                                        icon: "insert_chart",
                                        text: "Statistique sur Les utilisateur",
                                        href: "/entreprise/statistique_entreprise",
                                    },
                                ],
                            },
                        ],
                        listGroupMenu: [
                            {
                                text: "Configurations",
                                icon: "credit_card_gear",
                                submenu: [
                                    {
                                        text: "Configurations",
                                        icon: "box",
                                        items: [
                                            {
                                                icon: "data_table",
                                                text: "Configurations 1",
                                                href: "/entreprise/operation_configuration_1",
                                            },

                                            {
                                                icon: "api",
                                                text: "Configurations 2",
                                                href: "/entreprise/operation_configuration_2",
                                            },
                                        ],
                                    },
                                    {
                                        text: "Autorisation",
                                        icon: "conveyor_belt",
                                        items: [
                                            {
                                                icon: "api",
                                                text: "Autorisation 1",
                                                href: "/entreprise/operation_aut_1",
                                            },

                                            {
                                                icon: "api",
                                                text: "Autorisation 2",
                                                href: "/entreprise/operation_aut_2",
                                            },
                                        ],
                                    },
                                ],
                            },

                            {
                                text: "Paramètrage",
                                icon: "settings",
                                submenu: [
                                    {
                                        text: "Comptes",
                                        icon: "credit_card_gear",
                                        items: [
                                            {
                                                icon: "person",
                                                text: "Mon profil",
                                                href: "/entreprise/profil",
                                            },
                                            {
                                                icon: "lock",
                                                text: "Sécurité",
                                                href: "/entreprise/security",
                                            },
                                        ],
                                    },
                                ],
                            },
                        ],
                    },
                };
            } else {
            }
        },
    },
    computed: {},
    created() {
        this.$vuetify.theme.dark = false;
        this.testLink();
    },
};
</script>

<style scoped>
.sidebar-menu>ul>li a {
    text-decoration: none;
}
</style>
