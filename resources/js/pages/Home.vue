<template>
    <b-container>
        <b-row class="align-items-center">
            <b-col>
                <DatePicker
                    @change="fetchStoreStateByDate"
                    :datepicker="{
                        title: 'Choose date',
                        id: 'datepicker',
                        opened,
                    }"
                />
            </b-col>
            <b-col>
                <StoreState :storeState="{ nearestDate, initialDate }" />
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import axios from "axios";
import DatePicker from "@/components/Calendars/DatePicker";
import StoreState from "@/components/Feedbacks/StoreState";

export default {
    name: "Home",
    components: {
        DatePicker,
        StoreState,
    },
    data() {
        return {
            opened: null,
            initialDate: new Date(),
            nearestDate: null,
        };
    },
    methods: {
        async fetchStoreStateByDate(date) {
            const storeState = await axios.get("/api/schedule", {
                params: { date },
            });
            this.opened = storeState.data.openedAtInitialDate;
        },
    },
    async mounted() {
        const storeState = await axios.get("/api/schedule", {
            params: { initialDate: this.initialDate },
        });
        this.nearestDate = new Date(storeState.data.until);
    },
};
</script>
