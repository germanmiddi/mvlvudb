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
    },

    userCan(module, groups) {

        if (!groups || !Array.isArray(groups)) {
            return false; // Si los grupos no son válidos, retornamos falso
        }
        
        if (groups.some(group => group.includes('ALL'))) {
            return true; // Si hay un grupo que contiene 'ALL', permitimos el acceso sin verificar el módulo
        }          
        return groups.some(group => group.includes(module)); // Verificamos si el módulo está en el array de grupos
    }

})

export default store