export default function isNotAdmin({ next, router }) {

    const auth =  window.emerfine.user.id_role
    if (auth !=1) {

        return router.push({ name: "infos" });
    }

    return next();
}
