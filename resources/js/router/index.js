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
        },

        // База сообщений -> sms
        {
            path: '/messages/sms/',
            name: 'messages-sms',
            component: () => import('../components/pages/Messages/SmsMessages.vue'),
        },

        // База сообщений -> mms
        {
            path: '/messages/mms/',
            name: 'messages-mms',
            component: () => import('../components/pages/Messages/MmsMessages.vue'),
        },

        // База сообщений -> voice
        {
            path: '/messages/voice/',
            name: 'messages-voice',
            component: () => import('../components/pages/Messages/VoiceMessages.vue'),
        },

        // Спам лист
        {
            path: '/unsubscribed-recipients/',
            name: 'unsubscribed-recipients',
            component: () => import('../components/pages/UnsubscribedRecipients/Index.vue'),
        },

        // Спам лист
        {
            path: '/favorites/',
            name: 'favorites',
            component: () => import('../components/pages/Favorites/Index.vue'),
        },

        // Настройки -> Тематика
        {
            path: '/settings/thematics/',
            name: 'settings-thematics',
            component: () => import('../components/pages/Settings/Thematics/Index.vue'),
        },

        // Настройки -> Симбанки
        {
            path: '/settings/sim-banks/',
            name: 'settings-sim-banks',
            component: () => import('../components/pages/Settings/SimBanks/Index.vue'),
        },

        // Настройки -> Симкарты
        {
            path: '/settings/sim-cards/',
            name: 'settings-sim-cards',
            component: () => import('../components/pages/Settings/SimCards/Index.vue'),
        },

        // Настройки -> Прокси сервера
        {
            path: '/settings/proxies/',
            name: 'settings-proxies',
            component: () => import('../components/pages/Settings/Proxies/Index.vue'),
        },

        // Настройки -> Домены и редиректы
        {
            path: '/settings/domens-redirects/',
            name: 'settings-domens-redirects',
            component: () => import('../components/pages/Settings/DomensRedirects/Index.vue'),
        },

        // Настройки -> Профили
        {
            path: '/settings/profiles/',
            name: 'settings-profiles',
            component: () => import('../components/pages/Settings/Profiles/Index.vue'),
        }

    ]
})
