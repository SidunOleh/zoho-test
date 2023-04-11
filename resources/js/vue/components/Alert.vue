<template>
   <div :class="'mb-1 alert alert-' + type" role="alert">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: [
        'type',
    ],
}
</script>