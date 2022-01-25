<template>
    <b-container>
        <b-row class="align-items-center">
            <b-col>
                <DatePicker
                    @change="fetchStoreStateByDate"
                    :datepicker="{ title: 'Choose date', id: 'datepicker' }"
                />
            </b-col>
            <b-col>
                <StoreState :storeState="{ nearestDate: new Date() }" />
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import DatePicker from "@/components/Calendars/DatePicker";
import StoreState from "@/components/Feedbacks/StoreState";

export default {
    name: "Home",
    components: {
        DatePicker,
        StoreState,
    },
    methods: {
        fetchStoreStateByDate(date) {},
    },
};
</script>
