<template>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vyhledávání {{ query }}</h1>
            <!--            <a href="#"-->
            <!--               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i-->
            <!--                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
        </div>

        <div class="row">
            <div class="col-12">

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchPage",

    computed: {
      query() {
          return this.$store.state.searchQuery
      }
    },

    mounted() {},

    methods: {
        // search(query) {
        //     console.debug('Search');
        //     this.query = query;
        // }
    }
}
</script>

<style scoped>

</style>
