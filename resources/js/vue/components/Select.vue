<template>
    <div class="form-group mb-3">
        
        <alert v-if="this.$parent.hasError(name)" type="danger">
            {{ this.$parent.errors[name][0] }}
        </alert>
        
        <label :for="name">{{ title }}</label>
        <select v-model="this.$parent[name.split('.')[0]][name.split('.')[1]]" 
            class="form-control" :id="name" role="button">
            <template v-for="option of options">
                <option>{{ option }}</option>
            </template>
        </select>
    
    </div>
</template>

<script>
import alert from './Alert.vue'

export default {
    props: [
        'title',
        'name',
        'options',
    ],
    components: {
        alert,
    },
}
</script>