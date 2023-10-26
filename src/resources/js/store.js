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
    },

    fechaFormateada(fecha) {
        const fechaObjeto = new Date(fecha);
        //fechaObjeto.setDate(fechaObjeto.getDate() + 1); // Restar un día
        fechaObjeto.setDate(fechaObjeto.getDate()); // Restar un día

        const dia = fechaObjeto.getDate();
        const mes = fechaObjeto.getMonth() + 1; // Los meses en JavaScript son indexados desde 0
        const anio = fechaObjeto.getFullYear();
    
        const horas = fechaObjeto.getHours();
        const minutos = fechaObjeto.getMinutes();
        const segundos = fechaObjeto.getSeconds();

        // Agregar ceros iniciales si es necesario
        const diaFormateado = dia < 10 ? `0${dia}` : dia;
        const mesFormateado = mes < 10 ? `0${mes}` : mes;
    
        const horasFormateadas = horas < 10 ? `0${horas}` : horas;
        const minutosFormateados = minutos < 10 ? `0${minutos}` : minutos;

        return `${diaFormateado}/${mesFormateado}/${anio} ${horasFormateadas}:${minutosFormateados}`;
    },

    dateFormateada(fecha) {
        // 2021-08-21
        const fechaObjecto = fecha.split('-')
        return `${fechaObjecto[2]}/${fechaObjecto[1]}/${fechaObjecto[0]}`
    },

    // Validar formato de Input File.
    isValidFileType(file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
        return allowedTypes.includes(file.type);
    },

    exportBandejaExcel(filtros){
        console.log("REPORTE EXCEL BANDEJA")
    }


})

export default store