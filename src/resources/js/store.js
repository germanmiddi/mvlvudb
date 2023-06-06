import { reactive } from 'vue'

const store = reactive({

    sidebarCollapse: false,
    miniSidebarCollapse: true,
    collapseSidebar(){
        this.sidebarCollapse = !this.sidebarCollapse
        this.miniSidebarCollapse = !this.miniSidebarCollapse
    },
    mobileSidebar: true,
    showNavbar: true,
    hideSidebar : function() {
        this.sidebarCollapse = false
        this.miniSidebarCollapse = false
        this.showNavbar = true
    }

})

export default store