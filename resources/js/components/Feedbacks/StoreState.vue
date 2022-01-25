<template>
    <div>
        <div v-if="isOpen">Our store is opened.</div>
        <div v-else-if="storeState.nearestDate">
            Our store is closed at the moment, but it will be opened in
            {{ timeLeft }}.
        </div>
        <div v-else>We're not sure when our store will be opened.</div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "StoreState",
    computed: {
        nearestDate() {
            return this.storeState.nearestDate?.toLocaleString();
        },
        isOpen() {
            return (
                this.storeState.nearestDate?.toLocaleString() <=
                this.storeState.initialDate.toLocaleString()
            );
        },
        timeLeft() {
            if (!this.storeState.nearestDate) {
                return "";
            }

            const diff = moment.duration(
                moment(this.storeState.nearestDate).diff(
                    moment(this.storeState.initialDate)
                )
            );

            return `${diff.days()} days, ${diff.hours()} hours ${diff.minutes()} minutes and ${diff.seconds()} seconds`;
        },
    },
    props: {
        storeState: Object,
    },
};
</script>
