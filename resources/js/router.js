import Vue from "vue";
import VueRouter from "vue-router";
import VueRouteMiddleware from "vue-route-middleware";

import isNotAdmin from "./app/middleware/isNotAdmin";
import isNotUser from "./app/middleware/isNotUser";
import isNotEntreprise from "./app/middleware/isNotEntreprise";

Vue.use(VueRouter);

import Info from "./views/info.vue";

/*
 *=====================
 * Application
 *=====================
 */
import DashBoard from "./Application/Components/profileConnected.vue";
import ComptePage from "./Application/Admin/pages/ComptePage.vue";
import RolePage from "./Application/Admin/pages/RolePage.vue";
import SitePage from "./Application/Admin/pages/SitePage.vue";
import UserProfile from "./Application/Components/UserProfile.vue";
import BasicSecure from "./Application/Components/basicSecure.vue";
import StatistiqueUtilisateur from "./Application/Admin/Modules/Statistiques/StatistiqueUtilisateur.vue";
import StatistqueEleve from "./Application/Admin/Modules/Statistiques/StatistqueEleve.vue";
import StatistiqueFinance from "./Application/Admin/Modules/Statistiques/StatistiqueFinance.vue";

//localasation
import PaysPage from "./Application/Admin/Modules/Localisation/pays.vue";
import ProvincePage from "./Application/Admin/Modules/Localisation/province.vue";
import VillePage from "./Application/Admin/Modules/Localisation/Ville.vue";
import CommunePage from "./Application/Admin/Modules/Localisation/Commune.vue";
import QuartierPage from "./Application/Admin/Modules/Localisation/Quartier.vue";
import AvenuePage from "./Application/Admin/Modules/Localisation/Avenue.vue";

// scolarite
import AnneeScolaire from "./Application/Admin/Modules/Ecole/Modules/AnneeScolaire.vue";
import Classe from "./Application/Admin/Modules/Ecole/Modules/Classe.vue";
import Section from "./Application/Admin/Modules/Ecole/Modules/Section.vue";
import Division from "./Application/Admin/Modules/Ecole/Modules/Division.vue";
import Option from "./Application/Admin/Modules/Ecole/Modules/Option.vue";

//Pages
import Eleves from "./Application/Admin/Modules/Ecole/Pages/Eleves.vue";
import InscriptionScolaire from "./Application/Admin/Modules/Ecole/Pages/InscriptionScolaire.vue";
import PresenceEleve from "./Application/Admin/Modules/Ecole/Pages/PresenceEleve.vue";
import Ponctualite from "./Application/Admin/Modules/Ecole/Pages/Ponctualite.vue";

//Paiement
import Tranche from "./Application/Admin/Modules/Ecole/Paiement/Tranche.vue";
import Frais from "./Application/Admin/Modules/Ecole/Paiement/Frais.vue";
import PrevisionPage from "./Application/Admin/Modules/Ecole/Paiement/PrevisionPage.vue";
import PaiementPage from "./Application/Admin/Modules/Ecole/Paiement/PaiementPage.vue";


import MoisPage from "./Application/Admin/Modules/Ecole/Modules/MoisPage.vue";
import ClauturePage from "./Application/Admin/Modules/Ecole/Paiement/ClauturePage.vue";
//Rapports
import RapportPrevision from "./Application/Admin/Modules/Ecole/Rapports/RapportPrevision.vue";
import RapportPaiement from "./Application/Admin/Modules/Ecole/Rapports/RapportPaiement.vue";
import RapportIncription from "./Application/Admin/Modules/Ecole/Rapports/RapportIncription.vue";

//============ FINANCE =================================================================

import ClassesFin from './Application/Admin/Modules/Finances/Classes.vue'
import CompteFin from './Application/Admin/Modules/Finances/CompteFin.vue'
import SousCompte from './Application/Admin/Modules/Finances/SousCompte.vue'
import SSousCompte from './Application/Admin/Modules/Finances/SSousCompte.vue'
import TypeCompte from './Application/Admin/Modules/Finances/TypeCompte.vue'
import TypeOperation from './Application/Admin/Modules/Finances/TypeOperation.vue'
import TypePosition from './Application/Admin/Modules/Finances/TypePosition.vue'
import TTaux from './Application/Admin/Modules/Finances/TTaux.vue'
import Banque from './Application/Admin/Modules/Finances/Banque.vue'
import modepaie from './Application/Admin/Modules/Finances/ModePaiement.vue'

import Cloture_Caisse from './Application/Admin/Modules/Finances/Cloture_Caisse.vue'
import ClotureComptabilite from './Application/Admin/Modules/Finances/ClotureComptabilite.vue'

import depense from './Application/Admin/Modules/Finances/Depenses.vue'
import depenseAll from './Application/Admin/Modules/Finances/DepenseAll.vue'
import recette from './Application/Admin/Modules/Finances/Ressources.vue'
import Comptes from './Application/Admin/Modules/Finances/Comptes.vue'
import EnteteOperationComptable from './Application/Admin/Modules/Finances/EnteteOperationComptable.vue'
import Blocs from './Application/Admin/Modules/Tresorerie/Blocs.vue'
import CategorieRubrique from './Application/Admin/Modules/Tresorerie/CategorieRubrique.vue'
import EnteteEtatBesoin from './Application/Admin/Modules/Tresorerie/EnteteEtatBesoin.vue'
import Provenance from './Application/Admin/Modules/Tresorerie/Provenance.vue'
import Rubriques from './Application/Admin/Modules/Tresorerie/Rubriques.vue'
import EnteteBonEngagement from './Application/Admin/Modules/Tresorerie/EnteteBonEngagement.vue'

import RapportsJour_Caisse from './Application/Admin/Modules/Rapports/Finances/RapportsJour_Caisse.vue'
import RapportsComptabilite from './Application/Admin/Modules/Rapports/Finances/RapportsComptabilite.vue'
import RapportsJour_Vente from './Application/Admin/Modules/Rapports/Finances/RapportsJour_Vente.vue'

//module vente
import CategorieProduit from './Application/Admin/Modules/Ventes/CategorieProduit.vue'
import Produits from './Application/Admin/Modules/Ventes/Produits.vue'
import Fournisseur from './Application/Admin/Modules/Ventes/Fournisseur.vue'

import VenteEnteteCommande from './Application/Admin/Modules/Ventes/VenteEnteteCommande.vue'
import VenteEnteteEntree from './Application/Admin/Modules/Ventes/VenteEnteteEntree.vue'
import VenteEnteteVente from './Application/Admin/Modules/Ventes/VenteEnteteVente.vue'

//gestion des cours
import Periode from './Application/Admin/Modules/Ecole/GestionCours/Periode.vue'
import CategoryCours from './Application/Admin/Modules/Ecole/GestionCours/CategoryCours.vue'
import Cours from './Application/Admin/Modules/Ecole/GestionCours/Cours.vue'

import Enseignant from './Application/Admin/Modules/Ecole/GestionCours/Enseignant.vue'
import AttributionCours from './Application/Admin/Modules/Ecole/GestionCours/AttributionCours.vue'
import CotationPage from './Application/Admin/Modules/Ecole/GestionCours/CotationPage.vue'

import RapportScolairePage from './Application/Admin/Modules/Ecole/GestionCours/Rapports/RapportScolairePage.vue'



/*
 *=====================
 * Application
 *=====================
 */

const Router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/apps/infos",
            name: "infos",
            component: Info,
        },

        {
            path: "/dashbord",
            nema: "dashbord_admin",
            component: DashBoard,
        },

        {
            path: "/admin/role",
            nema: "role_admin",
            component: RolePage,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: "/admin/compte",
            nema: "compte_admin",
            component: ComptePage,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: "/admin/configure_site",
            nema: "configure_site_admin",
            component: SitePage,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: "/admin/profil",
            nema: "profil_admin",
            component: UserProfile,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/security",
            nema: "security_admin",
            component: BasicSecure,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: "/admin/statistique_user",
            nema: "statistique_user_admin",
            component: StatistiqueUtilisateur,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/StatistqueEleve",
            nema: "StatistqueEleve_admin",
            component: StatistqueEleve,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/StatistiqueFinance",
            nema: "StatistiqueFinance_admin",
            component: StatistiqueFinance,
            meta: { middleware: [isNotAdmin] },
        },
         {
            path: "/admin/pays",
            nema: "pays_admin",
            component: PaysPage,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/provinces",
            nema: "provinces_admin",
            component: ProvincePage,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: "/admin/ville",
            nema: "ville_admin",
            component: VillePage,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: "/admin/commune",
            nema: "commune_admin",
            component: CommunePage,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/quartier",
            nema: "quartier_admin",
            component: QuartierPage,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/avenue",
            nema: "avenue_admin",
            component: AvenuePage,
            meta: { middleware: [isNotAdmin] },
        },

        //scolarite
        {
            path: "/admin/annee_scolaire",
            nema: "annee_scolaire_admin",
            component: AnneeScolaire,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/classes",
            nema: "classes_admin",
            component: Classe,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/sections",
            nema: "sections_admin",
            component: Section,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/divisions",
            nema: "divisions_admin",
            component: Division,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/options",
            nema: "options_admin",
            component: Option,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/eleve",
            nema: "eleve_admin",
            component: Eleves,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/inscription",
            nema: "inscription_admin",
            component: InscriptionScolaire,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: "/admin/presence",
            nema: "presence_admin",
            component: PresenceEleve,
            meta: { middleware: [isNotAdmin] },
        },

        //Ponctualite
        {
            path: "/admin/ponctualite/:codeInscription",
            nema: "ponctualite_admin",
            component: Ponctualite,
            meta: { middleware: [isNotAdmin] },
        },

        //Paiement
        {
            path: "/admin/paiement_tranche",
            nema: "paiement_tranche_admin",
            component: Tranche,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/paiement_frais",
            nema: "paiement_frais_admin",
            component: Frais,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/paiement_prevision",
            nema: "paiement_prevision_admin",
            component: PrevisionPage,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/finances_paiement",
            nema: "finances_paiement_admin",
            component: PaiementPage,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/rapport_echeance",
            nema: "rapport_echeance_admin",
            component: RapportPrevision,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/rapport_inscription",
            nema: "rapport_inscription_admin",
            component: RapportIncription,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/rapport_paiement",
            nema: "rapport_paiement_admin",
            component: RapportPaiement,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/clauture_effectif",
            nema: "clauture_effectif_admin",
            component: ClauturePage,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: "/admin/mois_scolaire",
            nema: "mois_scolaire_admin",
            component: MoisPage,
            meta: { middleware: [isNotAdmin] },
        },

        //Finance et vente


        {
            path: '/admin/Comptes',
            name: 'Comptes',
            component: Comptes,
            meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/depense',
            name: 'depense',
            component: depense,
            meta: { middleware: [isNotAdmin] }

        },
        {
            path: '/admin/depenseAll',
            name: 'depenseAll',
            component: depenseAll,
            meta: { middleware: [isNotAdmin] }

        },
        {
            path: '/admin/recette',
            name: 'recette',
            component: recette,
            meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/ClassesFin',
            name: 'ClassesFin',
            component: ClassesFin,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/CompteFin',
            name: 'CompteFin',
            component: CompteFin,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/SousCompte',
            name: 'SousCompte',
            component: SousCompte,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/SSousCompte',
            name: 'SSousCompte',
            component: SSousCompte,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/TypeCompte',
            name: 'TypeCompte',
            component: TypeCompte,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/TypeOperation',
            name: 'TypeOperation',
            component: TypeOperation,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/TypePosition',
            name: 'TypePosition',
            component: TypePosition,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/Banque',
            name: 'Banque',
            component: Banque,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/Cloture_Caisse',
            name: 'Cloture_Caisse',
            component: Cloture_Caisse,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/modepaie',
            name: 'modepaie',
            component: modepaie,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/TTaux',
            name: 'TTaux',
            component: TTaux,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/CategorieRubrique',
            name: 'CategorieRubrique',
            component: CategorieRubrique,
            meta: { middleware: [isNotAdmin] },
        },
        {//
            path: '/admin/Provenance',
            name: 'Provenance',
            component: Provenance,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/Rubriques',
            name: 'Rubriques',
            component: Rubriques,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/EnteteBonEngagement',
            name: 'EnteteBonEngagement',
            component: EnteteBonEngagement,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/Blocs',
            name: 'Blocs',
            component: Blocs,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/EnteteEtatBesoin',
            name: 'EnteteEtatBesoin',
            component: EnteteEtatBesoin,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/RapportsJour_Caisse',
            name: 'RapportsJour_Caisse',
            component: RapportsJour_Caisse,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/RapportsComptabilite',
            name: 'RapportsComptabilite',
            component: RapportsComptabilite,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/EnteteOperationComptable',
            name: 'EnteteOperationComptable',
            component: EnteteOperationComptable,
            meta: { middleware: [isNotAdmin] },
        },

        //module vente
        {
            path: '/admin/CategorieProduit',
            name: 'CategorieProduit',
            component: CategorieProduit,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/Produits',
            name: 'Produits',
            component: Produits,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/Fournisseur',
            name: 'Fournisseur',
            component: Fournisseur,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/VenteEnteteCommande',
            name: 'VenteEnteteCommande',
            component: VenteEnteteCommande,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/VenteEnteteEntree',
            name: 'VenteEnteteEntree',
            component: VenteEnteteEntree,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/VenteEnteteVente',
            name: 'VenteEnteteVente',
            component: VenteEnteteVente,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/RapportsJour_Vente',
            name: 'RapportsJour_Vente',
            component: RapportsJour_Vente,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/ClotureComptabilite',
            name: 'ClotureComptabilite',
            component: ClotureComptabilite,
            meta: { middleware: [isNotAdmin] },
        },

        //gestion de cours
        {
            path: '/admin/periode',
            name: 'periode_admin',
            component: Periode,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/category_cours',
            name: 'category_cours_admin',
            component: CategoryCours,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: '/admin/cours',
            name: 'cours_admin',
            component: Cours,
            meta: { middleware: [isNotAdmin] },
        },
        {
            path: '/admin/enseignants',
            name: 'enseignants_admin',
            component: Enseignant,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: '/admin/attribution_cours',
            name: 'attribution_cours_admin',
            component: AttributionCours,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: '/admin/cotations',
            name: 'cotations_admin',
            component: CotationPage,
            meta: { middleware: [isNotAdmin] },
        },

        {
            path: '/admin/resultat_scolaire',
            name: 'resultat_scolaire_admin',
            component: RapportScolairePage,
            meta: { middleware: [isNotAdmin] },
        },
























        /*
    *
    *===============
    * *
    * *
    * *
    * *
    * fin lien de users
    * liens de users
    * =================

    */

        {
            path: "/user/profil",
            nema: "profil_user",
            component: UserProfile,
            meta: { middleware: [isNotUser] },
        },
        {
            path: "/user/security",
            nema: "security_user",
            component: BasicSecure,
            meta: { middleware: [isNotUser] },
        },

        /*
    *
    *===============
    * *
    * *
    * *
    * *
    * fin lien de users
    * liens de users
    * =================

    */

        /*
    *
    *===============
    * *
    * *
    * *
    * *
    * fin lien de entreprise
    * liens de entreprise
    * =================

    */

        {
            path: "/entreprise/profil",
            nema: "profil_entreprise",
            component: UserProfile,
            meta: { middleware: [isNotEntreprise] },
        },
        {
            path: "/entreprise/security",
            nema: "security_entreprise",
            component: BasicSecure,
            meta: { middleware: [isNotEntreprise] },
        },

        /*
*
*===============
* *
* *
* *
* *
* fin lien de users
* liens de users
* =================

*/
    ],
});

// Creates a `nextMiddleware()` function which not only
// runs the default `next()` callback but also triggers
// the subsequent Middleware function.
function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    // If no subsequent Middleware exists,
    // the default `next()` callback is returned.
    if (!subsequentMiddleware) return context.next;

    return (...parameters) => {
        // Run the default Vue Router `next()` callback first.
        context.next(...parameters);
        // Than run the subsequent Middleware with a new
        // `nextMiddleware()` callback.
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({ ...context, next: nextMiddleware });
    };
}

Router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware)
            ? to.meta.middleware
            : [to.meta.middleware];

        const context = {
            from,
            next,
            Router,
            to,
        };
        const nextMiddleware = nextFactory(context, middleware, 1);

        return middleware[0]({ ...context, next: nextMiddleware });
    }

    return next();
});

// Router.beforeEach(VueRouteMiddleware());
export default Router;
