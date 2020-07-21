import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    scrollBehavior() {
        return window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    routes: [
        // Главная
        {
            path: '/',
            name: 'main',
            component: () => import('../components/pages/Main/Index.vue'),
        },

        // Таргетинг
        {
            path: '/target/',
            name: 'target',
            component: () => import('../components/pages/Target/Tasks.vue'),
        },
        {
            path: '/target/tasks-from-archive/',
            name: 'target-tasks-from-archive',
            component: () => import('../components/pages/Target/TasksFromArchive.vue'),
        },
        {
            path: '/target/target-audience-base/',
            name: 'target-audience-base',
            component: () => import('../components/pages/Target/TargetAudienceBase.vue'),
        },
        {
            path: '/target/target-audience-base-from-archive/',
            name: 'target-audience-base-from-archive',
            component: () => import('../components/pages/Target/TargetAudienceBaseFromArchive.vue'),
        },

        // Рекламные компании
        {
            path: '/advertising-companies/',
            name: 'advertising-companies',
            component: () => import('../components/pages/AdvertisingCompanies/Tasks.vue'),
        },
        {
            path: '/advertising-companies/tasks-from-archive/',
            name: 'advertising-companies-tasks-from-archive',
            component: () => import('../components/pages/AdvertisingCompanies/TasksFromArchive.vue'),
        },

        // Аналитика
        {
            path: '/analytics/',
            name: 'analytics',
            component: () => import('../components/pages/Analytics/Index.vue'),
        },

        // Диалоги SMS MMS
        {
            path: '/dialogs/',
            name: 'dialogs',
            component: () => import('../components/pages/Dialogs/Index.vue'),
        },

        // Входящие вызовы
        {
            path: '/incoming-calls/',
            name: 'incoming-calls',
            component: () => import('../components/pages/IncomingCalls/Index.vue'),
        }
    ]
})
