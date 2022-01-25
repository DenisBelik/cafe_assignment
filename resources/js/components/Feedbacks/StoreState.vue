<template>
    <div>
        <div v-if="storeState.nearestDate <= today">Our store is opened.</div>
        <div v-else>
            Our store is closed at the moment, but it will be opened in
            {{ nearestDate }}.
        </div>
    </div>
</template>

<script>
export default {
    name: "StoreState",
    data() {
        return {
            today: new Date(),
        };
    },
    computed: {
        nearestDate() {
            return this.storeState.nearestDate.toLocaleString();
        },
    },
    props: {
        storeState: Object,
    },
};
</script>
