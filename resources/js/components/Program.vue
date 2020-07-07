<template>
    <kalendar :configuration="calendar_settings"
              :events="events"/>
</template>

<script>
    import {Kalendar} from 'kalendar-vue';

    export default {
        name: "Program",

        components: {
            Kalendar,
        },

        data: () => {
            return {
                events: [],
                calendar_settings: {
                    style: 'material_design',
                    cell_height: 20,
                    scrollToNow: true,
                    current_day: new Date(),
                    read_only: false,
                    day_starts_at: 0,
                    day_ends_at: 24,
                    overlap: true,
                    hide_dates: ['2019-10-31'], // Spooky
                    hide_days: [6],
                    past_event_creation: true
                },

                new_appointment: {
                    title: null,
                    description: null
                }
            }
        }
    }
</script>

<style scoped>

</style>
