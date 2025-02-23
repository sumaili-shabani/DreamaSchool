export default function isNotUser({ next, router }) {

    const auth =  window.emerfine.user.id_role
    if (auth !=2) {

        return router.push({ name: "infos" });
    }

    return next();
}
