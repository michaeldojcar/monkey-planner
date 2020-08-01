<template>
    <div>
        <digital-clock :blink="false"/>
    </div>
</template>

<script>
    import DigitalClock from "vue-digital-clock";

    export default {
        components: {
            DigitalClock
        }
    };
</script>

<style>
.clock {
    font-size: 100px;
}
</style>
