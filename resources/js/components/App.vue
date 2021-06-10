<template>
    <div id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <sidebar></sidebar>

            <!-- Content Wrapper -->
            <div id="content-wrapper"
                 class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <navbar></navbar>

                    <!-- Begin Page Content -->
                    <router-view></router-view>
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Monkey planner</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded"
           href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade"
             id="logoutModal"
             tabindex="-1"
             role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close"
                                type="button"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                type="button"
                                data-dismiss="modal">Cancel
                        </button>
                        <a class="btn btn-primary"
                           href="/logout">Odhlásit se</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    </body>-->
</template>

<script>
import DashboardPage from "./dashboard/DashboardPage";
import Navbar from "./ui/Navbar";
import Sidebar from "./ui/Sidebar";

/**
 * Main app component.
 *
 * This component wraps all user interface of planner SPA.
 */
export default {
    name: "App",
    components: {Sidebar, Navbar, DashboardPage},
    mounted() {

    }
}
</script>

<style scoped>

</style>
