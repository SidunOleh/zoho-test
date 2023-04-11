<template>
    <div class="form-body min-vh-100 d-flex justify-content-center align-items-center pt-3 pb-3">
        
        <form @submit.prevent="create" class="w-50">

            <alert v-if="successMessage" type="success">{{ this.successMessage }}</alert>
            <alert v-if="failureMessage" type="danger">{{ this.failureMessage }}</alert>
            
            <textInput title="Account Name" name="account.Account_Name"></textInput>
            <textInput title="Website" name="account.Website"></textInput>
            <textInput title="Phone" name="account.Phone"></textInput>
            <textInput title="Deal Name" name="deal.Deal_Name"></textInput>
        
            <selectInput title="Stage" name="deal.Stage" :options="getStages()"></selectInput>
        
            <button :disabled="!button" type="submit" class="btn btn-primary w-100">Create</button>
        
        </form>
    
    </div>
</template>

<script>
import textInput from './components/Input.vue'
import selectInput from './components/Select.vue'
import alert from './components/Alert.vue'

export default {
    data() {
        return {
            account: {
                Account_Name: '',
                Website: '',
                Phone: '',
            },
            deal: {
                Deal_Name: '',
                Stage: 'Qualification',
            },
            successMessage: '',
            failureMessage: '',
            errors: {},
            button: true,
        }
    },
    methods: {
        getStages() {
            return [
                'Qualification',
                'Needs Analysis',
                'Value Proposition',
                'Identify Decision Makers',
                'Proposal/Price Quote',
                'Negotiation/Review',
                'Closed Won',
                'Closed Lost',
                'Closed-Lost to Competition',
            ]
        },
        create() {
            this.button = false
            axios.post('/api/zoho/form', {
                account: this.account,
                deal: this.deal,
            }).then(res => {
                Object.assign(this.$data, this.$options.data())
                this.successMessage = res.data.message
            }).catch(err => {
                this.successMessage = ''
                this.failureMessage = ''
                this.errors = {}
                this.button = true
                let res = err.response
                switch (res.status) {
                    case 422:
                        this.errors = res.data.errors
                    break
                    default:
                        this.failureMessage = res.data.message
                }
            })
        },
        hasError(field) {
            return this.errors.hasOwnProperty(field)
        },
    },
    components: {
        textInput,
        selectInput,
        alert,
    },
}
</script>

<style>
    @media (max-width: 1024px) {
        .form-body form {
            width: 100% !important;
        }
    }
</style>