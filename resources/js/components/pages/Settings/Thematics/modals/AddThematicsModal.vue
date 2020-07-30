<template>
    <b-modal
            v-model="showModal"
            hide-backdrop
            no-close-on-backdrop
            title="Добавить тематику"
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
    name : 'AddThematicsModal',
    components: {
          VueElementLoading
    },
    props: ['value'],
    data: function () {
        return {
            showModal : false,
            isLoading : false,
            form: {
                name : '',
                spam_limit : 30000,
                freeze_hours: 24,
            }
        };
    },
    validations: {
        form: {
            name: {
                required,
                minLength: 5
            },
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
                console.log($v.form.$error())
                return;
            }
            this.addThematics();
        },
        addThematics()
        {
            let vm = this;
            this.isLoading = true;

            let url = '/api/settings/thematics';
            console.log(this.form)
            axios.post(url, this.form).then( response => {
                if (!response.data.errorCode )
                {
                    this.$emit('add-success');
                    this.$toast('Тематика добавлена');
                    this.resetModal()
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
