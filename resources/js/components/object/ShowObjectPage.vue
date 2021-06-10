<template>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <span class="badge badge-primary">{{ object.type.name }}</span>
            {{ object.name }}
        </h1>

        <!--        <a href="#"-->
        <!--           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i-->
        <!--            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
    </div>
</template>

<script>
export default {
    name: "showObjectPage"
}
</script>

<style scoped>

</style>
