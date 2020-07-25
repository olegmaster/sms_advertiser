<template>
    <b-modal v-model="showModal" hide-backdrop  title="Добавить прокси" @show="resetModal" @hidden="resetModal" @ok="handleOk" >
        <form ref="addProxyModal" @submit.stop.prevent="handleSubmit">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-auto">
                        <b-form-group label="Тип прокси">
                            <b-form-radio-group
                                    v-model="form.type"
                                    :options="radioOptions1"
                                    name="radios-stacked"
                                    stacked
                            ></b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="col-sm-auto">
                        <b-form-group label="Добавить из:">
                            <b-form-radio-group @change=""
                                    v-model="form.source_type"
                                    :options="radioOptions2"
                                    name="radios-stacked2"
                                    stacked
                            ></b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="col-sm-auto">
                        <b-form-group label="Small:" label-for="file-small" label-cols-sm="2" label-size="sm">
                            <b-form-file id="file-small" size="sm" accept=".txt"></b-form-file>
                        </b-form-group>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <b-form-group
                                class="mb-0"
                                label="Список прокси"
                                label-for="proxies"
                                :disabled="form.source_type === 0"
                                :invalid-feedback="invalidFeedback"
                                :state="formCheckedFields.proxies"
                        >
                            <b-form-textarea
                                    v-model="form.proxies"
                                    :state="formCheckedFields.proxies"
                                    id="proxies"
                                    placeholder="Введите прокси, каждая новая прокси с новой строки"
                                    rows="5"
                                    no-resize
                                    size="sm"
                                    :disabled="form.source_type === 0"
                                    :required="form.source_type === 1"
                                    :autofocus="form.source_type === 1"
                            ></b-form-textarea>
                        </b-form-group>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            Формат: [ (http|socks4|socks4):// ] [ login:password@ ]IP:PORT<br>
                            Пример:<br>
                            <strong>1)</strong>  http://pasha:pass@192.168.1.12:3128<br>
                            <strong>2)</strong>  socks4://pasha:pass@192.168.1.12:1080<br>
                            <strong>3)</strong>  socks5://192.168.1.12:1080
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </b-modal>
</template>

<script>

  import VueElementLoading from 'vue-element-loading'


export default {
    name : 'AddProxiesModal',
    components: {
          VueElementLoading
    },
    props: ['value'],
    data: function () {
        return {
            showModal : false,
            dict : {
              sample : 'каждый прокси с новой строки<br>' +
                  '<br>Формат: [ (http|socks4|socks4):// ] [ login:password@ ]IP:PORT' +
                  'Пример:<br>' +
                  '1)  http://pasha:pass@192.168.1.12:3128<br>' +
                  '2)  socks4://pasha:pass@192.168.1.12:1080<br>' +
                  '3)  socks5://192.168.1.12:1080'
            },
            radioOptions1 :[
                { text: 'HTTP', value: 0 },
                { text: 'Socks4', value: 1 },
                { text: 'Socks5', value: 2 },
            ],
            radioOptions2 :[
                { text: 'файла', value: 0 },
                { text: 'списка ниже', value: 1 }
            ],
            form: {
                type: 0,
                source_type : 0,
                proxies : ''
            },
            formIsCorrect : null,
            validProxyRegExp : new RegExp(/^(?:(http|socks4|socks5):\/\/)?(?:[\w_-][\w\d_-]*:[\w-_][\w\d-_]*@)?(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):\d{2,5}$/i),
            formCheckedFields : {
                proxies : false
            }
        };
    },
    computed: {
        invalidFeedback() {
            if (this.form.source_type != 1 )
            {
                this.formCheckedFields.proxies = null;
                return '';
            }

            if (this.form.proxies.trim().length > 0)
            {
                let divided = this.form.proxies.split('\n').map( v => (v.trim().length > 0) ? this.checkForValidProxy(v.trim()) : true );
                let wrongProxyRow = divided.indexOf(false);
                this.formCheckedFields.proxies = (wrongProxyRow == -1);
                console.log(this.formCheckedFields.proxies);

                return 'Заполните список прокси в правильном формате' + (wrongProxyRow >= 0 ? ', строка ' + (wrongProxyRow +1 ) : '');
            } else {
                //this.formCheckedFields.proxies = false;
                return 'Заполните список прокси'
            }
        }
    },
    methods: {
        formAllFieldsIsValid(){
            return Object.values(this.formCheckedFields).filter(v=>!v).length == 0;
        },
        checkFormValidity()
        {
            const valid = this.$refs['addProxyModal'].checkValidity()
            this.invalidFeedback;
            this.formIsCorrect = valid && this.formAllFieldsIsValid();
            console.log(this.formCheckedFields, this.formIsCorrect);
            return valid
        },
        resetModal()
        {
            this.form.proxies = '';
            this.formCheckedFields.proxies = null;
            this.formIsCorrect = null
        },
        handleOk(bvModalEvt)
        {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.handleSubmit()
        },
        handleSubmit()
        {
            // Exit when the form isn't valid
            if (!this.checkFormValidity()) {
                return
            }
            // Push the name to submitted names
            //this.submittedNames.push(this.name)
            // Hide the modal manually
            this.$nextTick(() => {
                this.$bvModal.hide('modal-prevent-closing')
            })
        },
        checkForValidProxy(proxy) {
            return this.validProxyRegExp.test(proxy.trim());
        }
    },
    watch: {
        value: function (val) {
            this.showModal = val;
            this.$emit('input', val );
        },
        showModal: function (val) {
            this.$emit('input', val );
        }

    },
    mounted()
    {

    }
}
</script>
