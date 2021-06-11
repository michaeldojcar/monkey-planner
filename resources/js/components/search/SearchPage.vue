<template>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vyhledávání {{ query }}</h1>
        </div>

        <div class="row"
             v-if="state === 'init'">
            <div class="col-12">
                Zadejte, co chcete vyhledat.
            </div>
        </div>


        <div class="row"
             v-if="state === 'searching'">
            <div class="col-12">
                Probíhá vyhledávání...
            </div>
        </div>

        <div class="row"
             v-if="state === 'results'">
            <div class="col-12">
                <table class="table">
                    <tr v-if="!results.length">
                        <td>Bohužel jsme nic nenašli.</td>
                    </tr>
                    <tr v-for="result in results">
                        <td>
                            <router-link :to="'/ob/'+result.uuid">
                                <span class="badge badge-primary">{{ result.type.name }}</span>
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/ob/'+result.uuid">{{ result.name }}</router-link>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchPage",


    data: () => {
        return {
            // State can be init, searching, results
            state: 'init',
            results: null,
        }
    },


    computed: {
        query() {
            // Vuex search query
            return this.$store.state.searchQuery
        }
    },
    watch: {
        query() {
            // Perform search after query update.

            if (this.query) {
                this.search(this.query)
            }
            else {
                this.state = "init";
            }
        }
    },

    mounted() {
    },

    methods: {
        search(query) {
            console.debug('Performing search on query: ' + this.query);
            this.state = 'searching'

            axios
                .post('/api/search', {
                    q: this.query
                })
                .then(response => {
                        this.results = response.data
                        this.state = 'results'
                    }
                )
        }
    }
}
</script>

<style scoped>

</style>
