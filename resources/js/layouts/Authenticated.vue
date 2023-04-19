<template>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <AdminSidebar />
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
                <AdminNavbar />
            <div class="container-fluid">
                <Breadcrumb class="row justify-content-center mt-4" :crumbs="crumbs" @selected="selected" />
                <router-view></router-view>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
</template>


<script setup>
import {computed, onMounted} from "vue";
import { useRoute } from "vue-router";
import AdminNavbar from "../components/includes/AdminNavbar.vue";
import AdminSidebar from "../components/includes/AdminSidebar.vue";
import Breadcrumb from "../components/includes/Breadcrumb.vue";


import $ from 'jquery';
const route = useRoute();

onMounted(()=>{
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
})

const crumbs = computed(() => {
    let pathArray = route.path.split('/')
      pathArray.shift()
      const breadCrumbs = [{ "href": "/admin", "disabled": false, "text": "Dashboard" }]
      // needed to handle the intermediary entries for nested vue routes
      let breadcrumb = ''
      let lastIndexFound = 0
      for (let i = 0; i < pathArray.length; ++i) {
        breadcrumb = `${breadcrumb}${'/'}${pathArray[i]}`
        if (route.matched[i] &&
          Object.hasOwnProperty.call(route.matched[i], 'meta') &&
          Object.hasOwnProperty.call(route.matched[i].meta, 'breadCrumb')) {
          breadCrumbs.push({
            href: i !== 0 && pathArray[i - (i - lastIndexFound)]
              ? '/' + pathArray[i - (i - lastIndexFound)] + breadcrumb
              : breadcrumb,
            disabled: i + 1 === pathArray.length,
            text: route.matched[i].meta.breadCrumb || pathArray[i]
          })
          lastIndexFound = i
          breadcrumb = ''
        }
      }
      return breadCrumbs
});

function selected(crumb) {
    // console.log(crumb);
}

</script>
<style>
.w-20{
    width: 20%;
}
.ml-1{
    margin-left: 1rem;
}
.mr-1{
    margin-right: 1rem;
}
.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
</style>
<style>
body {
    overflow-x: hidden;
}

#sidebar-wrapper {
    min-height: 100vh;
    margin-left: -15rem;
    -webkit-transition: margin .25s ease-out;
    -moz-transition: margin .25s ease-out;
    -o-transition: margin .25s ease-out;
    transition: margin .25s ease-out;
}

#sidebar-wrapper .sidebar-heading {
    padding: 0.875rem 1.25rem;
    font-size: 1.2rem;
}

#sidebar-wrapper .list-group {
    width: 15rem;
}

#page-content-wrapper {
    min-width: 100vw;
}

#wrapper.toggled #sidebar-wrapper {
    margin-left: 0;
}

@media (min-width: 768px) {
    #sidebar-wrapper {
        margin-left: 0;
    }

    #page-content-wrapper {
        min-width: 0;
        width: 100%;
    }

    #wrapper.toggled #sidebar-wrapper {
        margin-left: -15rem;
    }
}

</style>
