export default function isNotEntreprise({ next, router }) {

    const auth =  window.emerfine.user.id_role
    if (auth !=3) {

        return router.push({ name: "infos" });
    }

    return next();
}
