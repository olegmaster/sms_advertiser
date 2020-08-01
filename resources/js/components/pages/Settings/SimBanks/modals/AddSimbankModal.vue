<template>
    <b-modal
        v-model="showModal"
        hide-backdrop
        no-close-on-backdrop
        title="Добавить симбанк"
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
                            label="Название симбанка"
                            invalid-feedback="Введите название симбанка, от 5 символов"
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
    import {validationMixin} from "vuelidate";
    import {required, requiredIf, helpers, minLength} from "vuelidate/lib/validators";


    export default {
        name: 'AddSimbankModal',
        components: {
            VueElementLoading
        },
        props: ['value'],
        data: function () {
            return {
                showModal: false,
                isLoading: false,
                form: {
                    name: '',
                }
            };
        },
        validations: {
            form: {
                name: {
                    required,
                    minLength: minLength(5),
                },
            }
        },

        methods: {
            resetModal() {
                this.form.name = '';
                this.$v.$reset();
            },
            handleOk(bvModalEvt) {
                bvModalEvt.preventDefault()
                this.handleSubmit()
            },
            handleSubmit() {
                this.$v.form.$touch();
                if (this.$v.form.$anyError) {
                    return;
                }
                this.addDomain();
            },
            addDomain() {
                let vm = this;
                this.isLoading = true;

                let url = '/api/settings/simbanks';
                axios.post(url, this.form).then(response => {
                    if (!response.data.errorCode) {
                        this.$emit('add-success');
                        this.resetModal()
                        this.$toast('Симбанк добавлен');
                    }
                    vm.isLoading = false;
                    this.showModal = false;
                }).catch(responce => {
                    this.$toast('Ошибка добавления симбанка, возможно такой уже есть', 'danger');
                    vm.isLoading = false;
                });
            }
        },
        watch: {
            value: function (val) {
                this.showModal = val;
                this.$emit('input', val);

            },
            showModal: function (val) {
                this.$emit('input', val);
            }

        },
        mounted() {

        }
    }
</script>
