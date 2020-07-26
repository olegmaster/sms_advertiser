<template>
    <b-modal v-model="value" hide-backdrop  title="Добавить прокси" >
      <p class="my-4">Vertically centered modal!</p>
        <b-form-group label="Individual radios">
            <b-form-radio v-model="selected" name="some-radios" value="A">Option A</b-form-radio>
            <b-form-radio v-model="selected" name="some-radios" value="B">Option B</b-form-radio>
        </b-form-group>
    </b-modal>
</template>

<script>

  import VueElementLoading from 'vue-element-loading'


export default {
    components: {
          VueElementLoading
    },
    name : 'AddProxiesModal',
    props: {

    },
    data: function () {
        return {
            value : false
        };
    },
    computed: {

    },
    methods: {

    },
    watch: {

    },
    mounted()
    {

    }
}
</script>
