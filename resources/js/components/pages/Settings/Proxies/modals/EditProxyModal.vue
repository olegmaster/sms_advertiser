<template>
    <b-modal
            v-model="showModal"
            hide-backdrop
            no-close-on-backdrop
            title="Редактировать прокси"
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
                            ></b-form-radio-group>
                        </b-form-group>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <b-form-group
                                class="mb-0"
                                label="IP адресс прокси"
                                label-for="ip"
                                :invalid-feedback="invalidFeedback"
                                :state="!$v.form.ip.$dirty ? null : !$v.form.ip.$invalid"
                        >
                            <b-form-input
                                    v-model="$v.form.ip.$model"
                                    :state="!$v.form.ip.$dirty ? null : !$v.form.ip.$invalid"
                                    id="ip"
                                    placeholder="Введите IP адресс прокси"
                                    size="sm"
                                    required
                                    autofocus
                            ></b-form-input>
                        </b-form-group>
                    </div>
                    <div class="col-lg-6">
                        <b-form-group
                                class="mb-0"
                                label="Порт прокси"
                                label-for="port"
                                invalid-feedback="Введите число в интервале 1-65535"
                                :state="!$v.form.port.$dirty ? null : !$v.form.port.$invalid"
                        >
                            <b-form-input
                                    v-model="$v.form.port.$model"
                                    :state="!$v.form.port.$dirty ? null : !$v.form.port.$invalid"
                                    id="port"
                                    placeholder="Введите порт прокси"
                                    size="sm"
                                    required
                            ></b-form-input>
                        </b-form-group>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <b-form-group
                                class="mb-0"
                                label="Логин"
                                label-for="login"
                                invalid-feedback=""
                                :state="!$v.form.login.$dirty ? null : !$v.form.login.$invalid"
                        >
                            <b-form-input
                                    v-model="$v.form.login.$model"
                                    :state="!$v.form.login.$dirty ? null : !$v.form.login.$invalid"
                                    id="login"
                                    placeholder="Введите логин"
                                    size="sm"
                                    required
                            ></b-form-input>
                        </b-form-group>
                    </div>
                    <div class="col-lg-6">
                        <b-form-group
                                class="mb-0"
                                label="Пароль"
                                label-for="password"
                                invalid-feedback=""
                                :state="!$v.form.password.$dirty ? null : !$v.form.password.$invalid"
                        >
                            <b-form-input
                                    v-model="$v.form.password.$model"
                                    :state="!$v.form.password.$dirty ? null : !$v.form.password.$invalid"
                                    id="password"
                                    placeholder="Введите пароль"
                                    size="sm"
                                    required
                            ></b-form-input>
                        </b-form-group>
                    </div>

                </div>
            </div>
        </form>
    </b-modal>
</template>

<script>

  import VueElementLoading from 'vue-element-loading'
  import { validationMixin } from "vuelidate";
  import { required, requiredIf, helpers, minLength, ipAddress, numeric, between } from "vuelidate/lib/validators";

export default {
    name: 'EditProxyModal',
    components: {
        VueElementLoading
    },
    props: {
        value : false,
        proxy: {
            default:{
                id: 0,
                ip: '',
                port:'',
                login: '',
                password:'',
                type:0
            }
        }
  },
    data: function () {
        return {
            showModal : false,
            isLoading : false,
            radioOptions1 :[
                { text: 'HTTP', value: 0 },
                { text: 'Socks4', value: 1 },
                { text: 'Socks5', value: 2 },
            ],
            form: {
                ip: '',
                port: '',
                login: '',
                password: '',
                type: 0,
            }
        };
    },
    validations: {
        form: {
            ip: {
                required ,
                ipAddress
            },
            port: {
                required ,
                numeric,
                between: between(1, 65535)
            },
            login: {
                minLength: minLength(1)
            },
            password: {
                minLength: minLength(1)
            },
            type: {
                required
            }

        }
    },
    computed: {
        invalidFeedback() {
            if (this.form.ip.trim().length > 0)
            {
                return 'Введите IP адресс прокси в правильном формате';
            } else
                return 'Введите IP адресс прокси'
        }
    },
    methods: {
        resetModal()
        {
            this.form = Object.assign({}, this.proxy);
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

            this.editProxy();
        },
        editProxy()
        {
            let vm = this;
            this.isLoading = true;
            let data = {
                ip: this.form.ip,
                port: this.form.port,
                login: this.form.login,
                password: this.form.password,
                type: this.form.type,
            }

            let url = '/api/settings/proxies/' + this.proxy.id + '/';
            axios.put(url, data).then( response => {
                if (!response.data.errorCode )
                {
                    this.$toast('Прокси успешно обновлен!');
                    this.$emit('edit-success');
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
