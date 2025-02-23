<template>

    <!-- debit -->
    <div class="header">
        <div class="header-left active">
            <a href="javascript:void(0);" class="logo">
                <img :src="`${baseURL}/vuetheme/assets/img/logo.png`" alt="" />
            </a>
            <a href="javascript:void(0);" class="logo-small">
                <img :src="`${baseURL}/vuetheme/assets/img/logo-small.png`" alt="" />
            </a>
            <a id="toggle_btn" href="javascript:void(0);"> </a>
        </div>

        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <ul class="nav user-menu">

            <li class="nav-item">
                <div class="top-nav-search">
                    <a href="javascript:void(0);" class="responsive-search">
                        <i class="fa fa-search"></i>
                    </a>
                    <form action="#">
                        <div class="searchinputs">
                            <input type="text" placeholder="Search Here ..." />
                            <div class="search-addon">
                                <span><img :src="`${baseURL}/vuetheme/assets/img/icons/closes.svg`"
                                        alt="img" /></span>
                            </div>
                        </div>
                        <a class="btn" id="searchdiv"><img :src="`${baseURL}/vuetheme/assets/img/icons/search.svg`"
                                alt="img" /></a>
                    </form>
                </div>
            </li>



            <li class="nav-item dropdown has-arrow main-drop" style="margin-top: -10px;">
                <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                    <span class="user-img"><img :src="this.userData.avatar == null
                            ? `${baseURL}/images/avatar.png`
                            : `${baseURL}/images/` + this.userData.avatar
                        " alt="" /> <span class="status online"></span></span>
                </a>
                <div class="dropdown-menu menu-drop-user">
                    <div class="profilename">
                        <div class="profileset">
                            <span class="user-img"><img :src="this.userData.avatar == null
                                    ? `${baseURL}/images/avatar.png`
                                    : `${baseURL}/images/` + this.userData.avatar
                                " alt="" /> <span class="status online"></span></span>
                            <div class="profilesets">
                                <h6>{{ teacher_name }}</h6>

                                <a href="javascript:void(0)" :class="userData.id_role==1?'btn btn-success btn-sm clear-noti':
                                userData.id_role==2?'btn btn-primary btn-sm clear-noti':'btn btn-default btn-sm clear-noti'"> {{ userData.id_role | getRoleConnected }} </a>



                            </div>
                        </div>
                        <hr class="m-0" />
                        <RouterLink  class="dropdown-item"  v-for="(menu, i) in menus" :key="i" :to="menu.href"> <i class="me-2" :data-feather="menu.icon"></i>
                            {{ menu.title }}</RouterLink >

                        <hr class="m-0" />
                        <a class="dropdown-item logout pb-0" :href="`${this.baseURL}/logout`"><img
                                :src="`${baseURL}/vuetheme/assets/img/icons/log-out.svg`" class="me-2"
                                alt="img" />Deconnexion</a>
                    </div>
                </div>
            </li>
        </ul>

        <div class="dropdown mobile-user-menu">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <RouterLink class="dropdown-item" v-for="(menu, i) in menus" :key="i" :to="menu.href"><i class="me-2" :data-feather="menu.icon"></i> {{ menu.title }}</RouterLink>

                <a class="dropdown-item" :href="`${this.baseURL}/logout`">Logout</a>
            </div>
        </div>
    </div>
    <!-- fin -->

</template>

<script>
export default {
    data() {
        return {
            titre: "",
            menus: [
                {
                    title: "Profile",
                    icon: "user",
                    href: "/profil",
                },
            ],
            hader: "",
            teacher_name: window.emerfine.user.name,
        };
    },
    created() {
        this.getInfoConnected();
    },
    methods: {
        getInfoConnected() {
            if (this.userData.id_role == 1) {
                this.menus = [
                    {
                        title: "Voir mon Profil",
                        icon: "user",
                        href: "/admin/profil",
                    },
                    {
                        title: "Changer mon mot de passe",
                        icon: "lock",
                        href: "/admin/security",
                    },
                ];
            } else if (this.userData.id_role == 2) {
                this.menus = [
                    {
                        title: "Voir mon Profil",
                        icon: "user",
                        href: "/user/profil",
                    },
                    {
                        title: "Changer mon mot de passe",
                        icon: "lock",
                        href: "/user/security",
                    },
                ];
            } else if (this.userData.id_role == 3) {
                this.menus = [
                    {
                        title: "Voir mon Profil",
                        icon: "user",
                        href: "/entreprise/profil",
                    },
                    {
                        title: "Changer mon mot de passe",
                        icon: "lock",
                        href: "/entreprise/security",
                    },
                ];
            } else {
                this.menus = [
                    { title: "Mon profil", href: "error/profil", icon: "person" },
                ];
            }
            // console.log(window.emerfine.user);
        },
    },
    filters: {
        subStr(value) {
            if (value.length > 20) {
                return value.slice(0, 20).toLowerCase();
            } else {
                return value;
            }
        },
        LowerCase(value) {
            return value.toLowerCase();
        },
    },
};
</script>

<style scoped>
.clear-noti {
    float: center;
    font-size: 11px;
    text-transform: uppercase;
    text-decoration: none;
}
</style>
