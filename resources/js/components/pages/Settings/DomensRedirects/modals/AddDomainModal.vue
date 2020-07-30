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
                    <div class="col-sm-auto">
                        <b-form-group
                            label="Название домена"
                            invalid-feedback="Введите название домена"
                            :state="!$v.form.domain.$dirty ? null :  !$v.form.domain.$invalid"
                        >
                            <b-form-input type="text"
                                          v-model="$v.form.domain.$model"
                            ></b-form-input>
                        </b-form-group>
                    </div>
                    <div class="col-sm-auto">
                        <b-form-group label="Лимит">
                            <b-form-input type="number"
                                          v-model="$v.form.spam_limit.$model"
                            ></b-form-input>
                        </b-form-group>
                    </div>
                    <div class="col-sm-auto">
                        <b-form-group label="Время заморозки в часах">
                            <b-form-input type="number"
                                          v-model="$v.form.freeze_hours.$model"
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
  import { required, requiredIf, helpers, minLength } from "vuelidate/lib/validators";


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
                spam_limit : 30000,
                freeze_hours: 24,
            }
        };
    },
    validations: {
        form: {
            domain: {
                required,
                minLength: 5
            },
            spam_limit: {
                required,
            },
            freeze_hours: {
                required
            },
        }
    },

    methods: {
        resetModal()
        {
            this.form.name = '';
            this.form.spam_limit = 32000;
            this.form.freeze_hours = 24;
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
                console.log($v.form.$error())
                return;
            }
            this.addDomain();
        },
        addDomain()
        {
            let vm = this;
            this.isLoading = true;

            let url = '/api/settings/domains';
            console.log(this.form)
            axios.post(url, this.form).then( response => {
                if (!response.data.errorCode )
                {
                    this.$emit('add-success');
                    this.resetModal()
                    this.$toast('Домен добавлен');
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
