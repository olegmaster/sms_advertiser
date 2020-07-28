let toastPlugin = {};
toastPlugin.install = function (Vue, options) {

    // Вывод сообщений с правого верхнего угола окна. Используем в разных случайях для вывода успешности или не успешности операций.
    // Подробно можно прочитать по этой ссылке https://bootstrap-vue.org/docs/components/toast  . Там есть описание опций которых можно использовать.
    Vue.prototype.$toast = function( message, variant = 'success', title = 'Системное сообщение', delay = 5000, append = false, toaster = 'b-toaster-top-right' )
    {
        this.$bvToast.toast(message, {
            title: title,
            autoHideDelay: 5000,
            appendToast: append,
            variant: variant,
            solid: true,
            toaster: toaster,
        })
    }

};
export default toastPlugin;