<template>
    <b-modal
            v-model="showModal"
            hide-backdrop
            no-close-on-backdrop
            title="Добавить прокси"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
            :ok-disabled="isLoading"
            :cancel-disabled="isLoading"
            :hide-header-close="isLoading"
            :no-close-on-esc="isLoading"
    >
        <form @submit.stop.prevent="handleSubmit">
            <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-auto">
                        <b-form-group label="Тип прокси">
                            <b-form-radio-group
                                    v-model="$v.form.type.$model"
                                    :options="radioOptions1"
                                    name="radios-stacked"
                                    stacked
                            ></b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="col-sm-auto">
                        <b-form-group label="Добавить из:">
                            <b-form-radio-group @change=""
                                    v-model="$v.form.source_type.$model"
                                    :options="radioOptions2"
                                    name="radios-stacked2"
                                    stacked
                            ></b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="col-sm-6">
                        <b-form-group
                                :disabled="form.source_type === 1"
                                invalid-feedback="Выберите файл с расширением txt"
                                :state="!$v.form.file.$dirty || form.source_type === 1 ? null : !$v.form.file.$invalid"
                        >
                            <b-form-file
                                    v-model="$v.form.file.$model"
                                    placeholder="Выберите файл"
                                    browse-text="Обзор"
                                    size="sm"
                                    accept=".txt"
                                    :state="!$v.form.file.$dirty || form.source_type === 1 ? null : !$v.form.file.$invalid"
                            ></b-form-file>
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
                                :state="!$v.form.proxies.$dirty || form.source_type === 0 ? null : !$v.form.proxies.$invalid"
                        >
                            <b-form-textarea
                                    v-model="$v.form.proxies.$model"
                                    :state="!$v.form.proxies.$dirty || form.source_type === 0 ? null : !$v.form.proxies.$invalid"
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
  import { validationMixin } from "vuelidate";
  import { required, requiredIf, helpers, minLength } from "vuelidate/lib/validators";
  const validProxyRegExp = new RegExp(/^(?:(http|socks4|socks5):\/\/)?(?:[\w_-][\w\d_-]*:[\w-_][\w\d-_]*@)?(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):\d{2,5}$/i);
  const validFileName = new RegExp(/\.txt$/i);
  const validProxy = (proxy) => validProxyRegExp.test(proxy.trim());
  const checkProxy = (proxies) =>(proxies.split('\n').map( v => (v.trim().length > 0) ? validProxy(v.trim()) : true )).indexOf(false);

  //Валидаторы
  const proxyValidator = (proxies) => !helpers.req(proxies) || (checkProxy(proxies) == -1);
  const fileValidator = (file) => !helpers.req(file) || validFileName.test(file.name);


export default {
    name : 'AddProxiesModal',
    components: {
          VueElementLoading
    },
    props: ['value'],
    data: function () {
        return {
            showModal : false,
            isLoading : false,
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
                file: null,
                proxies : ''
            }
        };
    },
    validations: {
        form: {
            type: {
                required
            },
            source_type: {
                required
            },
            file: {
                required : requiredIf(function(){ return this.form.source_type == 0}),
                fileValidator
            },
            proxies: {
                required : requiredIf(function() { return this.form.source_type == 1}),
                proxyValidator,
                minLength: 10
            }
        }
    },
    computed: {
        invalidFeedback() {
            if (this.form.source_type != 1 )
                return '';

            if (this.form.proxies.trim().length > 0)
            {
                let wrongProxyRow = checkProxy(this.form.proxies);
                return 'Заполните список прокси в правильном формате' + (wrongProxyRow >= 0 ? ', ошибка в строке ' + (wrongProxyRow +1 ) : '');
            } else
                return 'Заполните список прокси'
        }
    },
    methods: {
        resetModal()
        {
            this.form.type = 0;
            this.form.source_type = 0;
            this.form.file = null;
            this.form.proxies = '';
            this.$v.$reset();
        },
        handleOk(bvModalEvt)
        {
            bvModalEvt.preventDefault()
            this.handleSubmit()
        },
        handleSubmit()
        {
            this.$v.form.$touch();
            if (this.$v.form.$anyError) {
                return;
            }

            this.addProxies();
        },
        addProxies()
        {
            let vm = this;
            this.isLoading = true;
            let formData = new FormData();
            if ( !this.form.source_type )
                formData.append('file', this.form.file, this.form.file.name );
            formData.append('proxies', JSON.stringify(this.form) );

            let url = '/api/settings/proxies/';
            axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then( response => {
                if (!response.data.errorCode )
                {
                    this.$toast('Прокси успешно добавлен!');
                    this.$emit('add-success');
                } else
                    this.$toast(response.data.message, 'danger');
                vm.isLoading = false;
                this.showModal = false;
            }).catch( responce => {
                vm.isLoading = false;
            });
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
