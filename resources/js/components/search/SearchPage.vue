<template>
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Vyhledávání {{ query }}</h1>
    </div>

    <div class="row"
         v-if="loading">
      <div class="col-12">
        Probíhá vyhledávání...
      </div>
    </div>

    <div class="row"
         v-else>
      <div class="col-12">

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SearchPage",



  data: () => {
    return {
      loading: true,
    }
  },


  computed: {
    query() {
      return this.$store.state.searchQuery
    }
  },

  mounted() {
  },

  methods: {
    search(query) {
      console.debug('Search');
      this.query = query;
      this.loading = true;

      axios
          .get('/api/search')
          .then(response => {
                this.results = response.data
                this.loading = false
              }
          )
    }
  }
}
</script>

<style scoped>

</style>
