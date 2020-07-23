<template>
    <div :class="sidebarbg" class="app-sidebar sidebar-shadow" @mouseover="toggleSidebarHover('add','closed-sidebar-open')" @mouseleave="toggleSidebarHover('remove','closed-sidebar-open')">
        <div class="app-header__logo">
            <div class="logo-src"/>
            <div class="header__pane ml-auto">
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" v-bind:class="{ 'is-active' : isOpen }" @click="toggleBodyClass('closed-sidebar')">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-sidebar-content">
            <VuePerfectScrollbar class="app-sidebar-scroll" v-once>
                <sidebar-menu showOneChild :menu="menu"/>
            </VuePerfectScrollbar>
        </div>

    </div>
</template>

<script>
    import {SidebarMenu} from 'vue-sidebar-menu'
    import VuePerfectScrollbar from 'vue-perfect-scrollbar'

    export default {
        components: {
            SidebarMenu,
            VuePerfectScrollbar
        },
        data() {
            return {
                isOpen: false,
                sidebarActive: false,

                menu: [
                    {
                        header: true,
                        title: 'Основное меню',
                    },
                    {
                        title: 'Главная',
                        href: '/',
                        icon: 'lnr-apartment',
                    },
                    {
                        title: 'Таргетинг',
                        icon: 'pe-7s-news-paper',
                        child: [
                            {
                                href: '/target',
                                title: 'Список заданий',
                            },
                            {
                                href: '/target/tasks-from-archive/',
                                title: 'Список заданий из архива',
                            },
                            {
                                href: '/target/target-audience-base/',
                                title: 'База целевых аудиторий',
                            },
                            {
                                href: '/target/target-audience-base-from-archive/',
                                title: 'База целевых аудиторий из архива',
                            },

                        ]
                    },
                    {
                        title: 'Рекламные компании',
                        icon: 'pe-7s-news-paper',
                        child: [
                            {
                                href: '/advertising-companies/',
                                title: 'Список заданий',
                            },
                            {
                                href: '/advertising-companies/tasks-from-archive/',
                                title: 'Список заданий из архива',
                            },
                        ]
                    },
                    {
                        title: 'Аналитика',
                        href: '/analytics/',
                        icon: 'pe-7s-graph2',
                    },
                    {
                        title: 'Диалоги SMS и MMS',
                        href: '/dialogs/',
                        icon: 'pe-7s-chat',
                    },

                    {
                        title: 'Входящие вызовы',
                        href: '/incoming-calls/',
                        icon: 'pe-7s-call',
                    },
                    {
                        title: 'База сообщений',
                        icon: 'pe-7s-news-paper',
                        child: [
                            {
                                href: '/messages/sms/',
                                title: 'SMS сообщения',
                            },
                            {
                                href: '/messages/mms/',
                                title: 'MMS сообщения',
                            },
                            {
                                href: '/messages/voice/',
                                title: 'Голосовые сообщения',
                            }
                        ]
                    },
                    {
                        title: 'Спам лист',
                        href: '/unsubscribed-recipients/',
                        icon: 'pe-7s-call',
                    },
                    {
                        title: 'Избранное',
                        href: '/favorites/',
                        icon: 'pe-7s-call',
                    },


                    {
                        header: true,
                        title: 'Настройки',
                    },
                    {
                        href: '/settings/thematics/',
                        title: 'Тематика',
                        icon: 'pe-7s-news-paper',
                    },
                    {
                        href: '/settings/sim-banks/',
                        title: 'Симбанки',
                        icon: 'pe-7s-news-paper',
                    },
                    {
                        href: '/settings/sim-cards/',
                        title: 'Симкарты',
                        icon: 'pe-7s-news-paper',
                    },
                    {
                        href: '/settings/proxies/',
                        title: 'Прокси сервера',
                        icon: 'pe-7s-news-paper',
                    },
                    {
                        href: '/settings/domens-redirects/',
                        title: 'Домены и редиректы',
                        icon: 'pe-7s-news-paper',
                    },
                    {
                        href: '/settings/profiles/',
                        title: 'Профили',
                        icon: 'pe-7s-news-paper',
                    },


                ],
                collapsed: true,

                windowWidth: 0,

            }
        },
        props: {
            sidebarbg: String,

        },
        methods: {

            toggleBodyClass(className) {
                const el = document.body;
                this.isOpen = !this.isOpen;

                if (this.isOpen) {
                    el.classList.add(className);
                } else {
                    el.classList.remove(className);
                }
            },
            toggleSidebarHover(add, className) {
                const el = document.body;
                this.sidebarActive = !this.sidebarActive;

                this.windowWidth = document.documentElement.clientWidth;

                if (this.windowWidth > '992') {
                    if (add === 'add') {
                        el.classList.add(className);
                    } else {
                        el.classList.remove(className);
                    }
                }
            },
            getWindowWidth() {
                const el = document.body;

                this.windowWidth = document.documentElement.clientWidth;

                if (this.windowWidth < '1350') {
                    el.classList.add('closed-sidebar', 'closed-sidebar-md');
                } else {
                    el.classList.remove('closed-sidebar', 'closed-sidebar-md');
                }
            },
        },
        mounted() {
            this.$nextTick(function () {
                window.addEventListener('resize', this.getWindowWidth);

                //Init
                this.getWindowWidth()
            })
        },

        beforeDestroy() {
            window.removeEventListener('resize', this.getWindowWidth);
        }
    }
</script>
