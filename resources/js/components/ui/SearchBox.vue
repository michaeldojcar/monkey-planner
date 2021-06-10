<template>
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text"
                   class="form-control bg-light border-0 small"
                   placeholder="Vyhledávání"
                   aria-label="Search"
                   aria-describedby="basic-addon2"
                   v-on:change="search"
                   v-on:submit="search"
                   v-model="query">

            <div class="input-group-append">
                <button v-on:click="search"
                        class="btn btn-primary"
                        type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchBox",

    data: () => {
        return {
            query: null
        }
    },

    methods: {
        search() {
            this.$store.commit('updateSearchQuery', this.query)

            if (this.$route.path !== '/search') {
                this.$router.push('/search')
            }

        }
    }
}
</script>

<style scoped>

</style>
