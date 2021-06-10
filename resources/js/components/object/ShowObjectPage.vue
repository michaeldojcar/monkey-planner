<template>
    <div class="container-fluid"
         v-if="loading">
        Načítání...
    </div>

    <div v-else>
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <span class="badge badge-primary">{{ object.type.name || 'loading' }}</span>
                    <h1 class="h3 mb-0 text-gray-800">
                        {{ object.name }}
                    </h1>
                </div>

                <!--        <a href="#"-->
                <!--           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i-->
                <!--            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "showObjectPage",
    data: () => {
        return {
            object: null,
            loading: true
        }
    },

    mounted() {
        let uuid = this.$route.params.uuid;

        axios
            .get('/api/obs/' + uuid)
            .then(response => {
                    this.object = response.data
                    this.loading = false
                }
            )
    }
}
</script>

<style scoped>

</style>
