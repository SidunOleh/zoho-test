<template>
    <div class="form-group mb-3">

        <alert v-if="this.$parent.hasError(name)" type="danger">
            {{ this.$parent.errors[name][0] }}
        </alert>
    
        <label :for="name">{{ title }}</label>
        <input v-model="this.$parent[name.split('.')[0]][name.split('.')[1]]" 
            type="text" class="form-control" :id="name" :placeholder="'Enter ' + title">
    
    </div>
</template>

<script>
import alert from './Alert.vue'

export default {
    props: [
        'title',
        'name',
    ],
    components: {
        alert,
    },
}
</script>