<template>
    <b-modal
        v-model="showModal"
        hide-backdrop
        no-close-on-backdrop
        title="Редактировать тематику"
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
                    <div class="col-sm-auto">
                        <b-form-group
                            label="Название тематики"
                            invalid-feedback="Введите название тематики"
                            :state="!$v.form.name.$dirty ? null :  !$v.form.name.$invalid"
                        >
                            <b-form-input type="text"
                                          v-model="$v.form.name.$model"
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
        name : 'EditDomainModal',
        components: {
            VueElementLoading
        },
        props: {
            value : false,
            form: {
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
                    name : '',
                }
            };
        },
        validations: {
            form: {
                name: {
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
                this.editDomain();
            },
            editDomain()
            {
                let vm = this;
                this.isLoading = true;

                let url = '/api/settings/domains/7';
                console.log('submit')
                console.log(this.form)
                let data = this.form
                data.value = 7
                data.ids = [this.form.id]
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
