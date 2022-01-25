<template>
    <div>
        <label :for="datepicker.id">
            {{ datepicker.title }}
        </label>
        <b-form-datepicker
            :id="datepicker.id"
            v-model="value"
            class="mt-2"
            @input="$emit('change', value)"
        />
        <p v-if="datepicker.opened !== null">
            <span v-if="datepicker.opened">We are opened at that day.</span>
            <span v-else>Sorry, but we are closed at that day.</span>
        </p>
    </div>
</template>

<script>
export default {
    name: "Home",
    props: {
        datepicker: Object,
    },
};
</script>
