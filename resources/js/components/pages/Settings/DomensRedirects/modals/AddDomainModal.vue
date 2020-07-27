<template>
    <b-modal
            v-model="showModal"
            hide-backdrop
            no-close-on-backdrop
            title="Добавить домен"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"

            ok-title='Добавить'
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
                                v-model="form.domain"
                            ></b-form-input>
                        </b-form-group>
                    <br>

                        <b-form-group label="Лимит">
                            <b-form-input type="number"
                                          v-model="form.spam_limit"
                            ></b-form-input>
                        </b-form-group>

                    <br>
                        <b-form-group label="Время заморозки в часах">
                            <b-form-input type="number"
                                          v-model="form.freeze_hours"
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
    name : 'AddDomainModal',
    components: {
          VueElementLoading
    },
    props: ['value'],
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
        invalidFeedback() {
            if (this.form.source_type != 1 )
                return '';

            if (this.form.proxies.trim().length > 0)
            {
                let wrongProxyRow = checkProxy(this.form.proxies);
                return 'Заполните список домен в правильном формате' + (wrongProxyRow >= 0 ? ', ошибка в строке ' + (wrongProxyRow +1 ) : '');
            } else
                return 'Заполните список домен'
        }
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
                    this.$emit('add-success');
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
