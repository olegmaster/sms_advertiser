<template>
    <b-modal
        v-model="showModal"
        hide-backdrop
        no-close-on-backdrop
        title="Редактировать домен"
        @show="resetModal"
        @hidden="resetModal"
        @ok="handleOk"

        ok-title='Редактировать'
        cancel-title="Отмена"
        :ok-disabled="isLoading"
        :cancel-disabled="isLoading"
        :hide-header-close="isLoading"
        :no-close-on-esc="isLoading"
    >
        <form @submit.stop.prevent="handleSubmit">
            <VueElementLoading :active="isLoading" spinner="bar-fade-scale" color="var(--primary)"/>
            <div class="container-fluid">
                <div class="row">

                    <b-form-group label="Название домена">
                        <b-form-input type="text"
                                      v-model="domain.domain"
                        ></b-form-input>
                    </b-form-group>
                    <br>

                    <b-form-group label="Лимит">
                        <b-form-input type="number"
                                      v-model="domain.spam_limit"
                        ></b-form-input>
                    </b-form-group>

                    <br>
                    <b-form-group label="Время заморозки в часах">
                        <b-form-input type="number"
                                      v-model="domain.freeze_hours"
                        ></b-form-input>
                    </b-form-group>

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
        name : 'EditDomainModal',
        components: {
            VueElementLoading
        },
        props: {
            value : false,
            domain: {
                domain: '',
                freeze_hours: 0,
                spam_limit: 0,
            }
        },
        data: function () {
            return {
                showModal : false,
                isLoading : false,
                form: {
                    domain : '',
                    spam_limit : 0,
                    freeze_hours: 0,
                }
            };
        },
        validations: {
            form: {
                name: {
                    required
                },
                spam_limit: {
                    required,
                },
                freeze_hours: {
                    required
                },

            }
        },
        computed: {


        },
        methods: {
            resetModal()
            {
                this.form.name = '';
                this.form.spam_limit = 0;
                this.form.freeze_hours = 0;
                this.$v.$reset();
            },
            handleOk(bvModalEvt)
            {
                bvModalEvt.preventDefault()
                this.handleSubmit()
            },
            handleSubmit()
            {
                // this.$v.form.$touch();
                // if (this.$v.form.$anyError) {
                //     console.log($v.form.$error())
                //     return;
                // }
                this.editDomain();
            },
            editDomain()
            {
                let vm = this;
                this.isLoading = true;

                let url = '/api/settings/domains';
                console.log('submit')
                console.log(this.form)
                let data = this.form
                data.value = 7
                axios.patch(url, data).then( response => {
                    if (!response.data.errorCode )
                    {
                        this.$emit('edit-success');
                    }
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
