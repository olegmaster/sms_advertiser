let commonFunctions = {};
commonFunctions.install = function (Vue, options) {

    Vue.prototype.$getDateTime = function (dbDateTime, with_time = false, withMonthText = false)
    {
        let monthNames = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Ноябрь',
            'Декабрь',
        ];
        let date = new Date(Date.parse(dbDateTime));
        return date.getDate() + '-' + (withMonthText ? monthNames[(''+date.getMonth()).slice(-2)] : ('0'+date.getMonth()).slice(-2) ) + '-' + date.getFullYear() + ( with_time ? ' ' + date.getHours() + ':' + date.getMinutes() + ':' + ('0'+date.getSeconds()).slice(-2): '' );
        //return date.getDate() + '-' + ('0' + date.getMonth()).slice(-2) + '-' + date.getFullYear()
    }


};
export default commonFunctions;

