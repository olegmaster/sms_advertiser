<template>
    <b-modal
        v-model="showModal"
        hide-backdrop
        no-close-on-backdrop
        :title="thematicsName"
        @hidden="resetModal"
        @ok="handleOk"
        id="edit-thematics-modal"

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
                                          :state="!$v.form.name.$dirty ? null :  !$v.form.name.$invalid"
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
        name : 'EditThematicsModal',
        components: {
            VueElementLoading
        },
        props: {
            value : false,
            form: {
                name: '',
            }
        },
        data: function () {
            return {
                showModal : false,
                isLoading : false,
                thematicsName: '',
                form: {
                    name : '',
                }
            };
        },
        validations: {
            form: {
                name: {
                    required,
                    minLength: minLength(5)
                },
            }
        },
        computed: {
            modalTitle(){
                return "Редактировать тематику \"" + this.form.name + "\""
            }

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
                    return;
                }
                this.editThematics();
            },
            editThematics()
            {
                let vm = this;
                this.isLoading = true;

                let url = '/api/settings/thematics/3';
                let data = this.form
                data.value = 3
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
            this.$root.$on('bv::modal::show', (bvEvent, modalId) => {
                if(modalId === 'edit-thematics-modal'){
                    this.thematicsName = "Редактировать тематику \"" + this.form.name + "\""
                }
            })
        }
    }
</script>
