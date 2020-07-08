<template>
    <div>
        <v-row class="fill-height">
            <v-col>
                <v-sheet height="800">
                    <v-calendar
                        ref="calendar"
                        v-model="value"
                        color="primary"
                        type="custom-daily"
                        :start="event.from"
                        :end="event.to"
                        :max-days="event.days"
                        :events="events"
                        :event-color="getEventColor"
                        :event-ripple="false"
                        @change="getEvents"
                        @mousedown:event="startDrag"
                        @mousedown:time="startTime"
                        @mousemove:time="mouseMove"
                        @mouseup:time="endDrag"
                        @mouseleave.native="cancelDrag"
                        :interval-format="intervalFormat"
                    >
                        <template #event="{ event, timed, eventSummary }">
                            <div
                                class="v-event-draggable"
                                v-html="eventSummary()"
                            ></div>
                            <div
                                v-if="timed"
                                class="v-event-drag-bottom"
                                @mousedown.stop="extendBottom(event)"
                            ></div>
                        </template>
                    </v-calendar>
                </v-sheet>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "Program",

        components: {},

        data: () => ({
            value: '',
            event: {},
            events: [],
            colors: ['', '#3F51B5', '#673AB7', '#00BCD4', '#4CAF50', '#FF9800', '#757575'],
            names: ['Houpačka', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
            dragEvent: null,
            dragStart: null,
            createEvent: null,
            createStart: null,
            extendOriginal: null,
        }),

        mounted() {
            this.fetch()

            setInterval(() => {
                this.fetch()
            }, 60000);
        },

        methods: {
            fetch() {
                axios.get('/api/event/1/calendar')
                    .then((response) => {
                        this.event = response.data.event
                        this.events = response.data.events;
                    })
            },

            push() {
                axios.post('/api/event/1/calendar', {
                    events: this.events
                });
            },

            startDrag({event, timed}) {
                if (event && timed) {
                    this.dragEvent = event
                    this.dragTime = null
                    this.extendOriginal = null
                }
            },

            startTime(tms) {
                const mouse = this.toTime(tms)

                if (this.dragEvent && this.dragTime === null) {
                    const start = this.dragEvent.start

                    this.dragTime = mouse - start
                } else {
                    this.createStart = this.roundTime(mouse)
                    this.createEvent = {
                        name: `Event #${this.events.length}`,
                        color: this.rndElement(this.colors),
                        start: this.createStart,
                        end: this.createStart,
                        timed: true,
                    }

                    this.events.push(this.createEvent)
                }
            },

            intervalFormat(interval) {
                return interval.time
            },

            extendBottom(event) {
                this.createEvent = event
                this.createStart = event.start
                this.extendOriginal = event.end
            },
            mouseMove(tms) {
                const mouse = this.toTime(tms)

                if (this.dragEvent && this.dragTime !== null) {
                    const start = this.dragEvent.start
                    const end = this.dragEvent.end
                    const duration = end - start
                    const newStartTime = mouse - this.dragTime
                    const newStart = this.roundTime(newStartTime)
                    const newEnd = newStart + duration

                    this.dragEvent.start = newStart
                    this.dragEvent.end = newEnd
                } else if (this.createEvent && this.createStart !== null) {
                    const mouseRounded = this.roundTime(mouse, false)
                    const min = Math.min(mouseRounded, this.createStart)
                    const max = Math.max(mouseRounded, this.createStart)

                    this.createEvent.start = min
                    this.createEvent.end = max
                }
            },
            endDrag() {
                this.dragTime = null
                this.dragEvent = null
                this.createEvent = null
                this.createStart = null
                this.extendOriginal = null

                this.push();
            },
            cancelDrag() {
                if (this.createEvent) {
                    if (this.extendOriginal) {
                        this.createEvent.end = this.extendOriginal
                    } else {
                        const i = this.events.indexOf(this.createEvent)
                        if (i !== -1) {
                            this.events.splice(i, 1)
                        }
                    }
                }

                this.createEvent = null
                this.createStart = null
                this.dragTime = null
                this.dragEvent = null
            },
            roundTime(time, down = true) {
                const roundTo = 15 // minutes
                const roundDownTime = roundTo * 60 * 1000

                return down
                    ? time - time % roundDownTime
                    : time + (roundDownTime - (time % roundDownTime))
            },
            toTime(tms) {
                return new Date(tms.year, tms.month - 1, tms.day, tms.hour, tms.minute).getTime()
            },
            getEventColor(event) {
                const rgb = parseInt(event.color.substring(1), 16)
                const r = (rgb >> 16) & 0xFF
                const g = (rgb >> 8) & 0xFF
                const b = (rgb >> 0) & 0xFF

                return event === this.dragEvent
                    ? `rgba(${r}, ${g}, ${b}, 0.7)`
                    : event === this.createEvent
                        ? `rgba(${r}, ${g}, ${b}, 0.7)`
                        : event.color
            },
            getEvents({start, end}) {

            },
            rnd(a, b) {
                return Math.floor((b - a + 1) * Math.random()) + a
            },
            rndElement(arr) {
                return arr[this.rnd(0, arr.length - 1)]
            },
        },
    }
</script>

<style lang="scss">

    .theme--light.v-calendar-events .v-event-timed {
        user-select: none;
        -webkit-user-select: none;

        padding: 3px 3px !important;

        border: none !important;

        color: white;
    }

    .v-event-draggable {
        /*padding-left: 3px;*/
        line-break: normal;
    }

    .v-event-drag-bottom {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 4px;
        height: 4px;
        cursor: ns-resize;

        &::after {
            display: none;
            position: absolute;
            left: 50%;
            height: 7px;
            border-top: 1px solid white;
            border-bottom: 1px solid white;
            width: 16px;
            margin-left: -8px;
            opacity: 0.8;
            content: '';
        }

        &:hover::after {
            display: block;
        }
    }
</style>
