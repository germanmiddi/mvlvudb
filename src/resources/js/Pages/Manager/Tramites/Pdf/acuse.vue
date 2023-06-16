<style scoped>

  @page landscape { size: 297mm 210mm; margin: 10mm; padding:0mm }
  @page regular { size: 210mm 297mm; margin: 0mm; padding:0mm }
  
  .landscape-content {
    page: landscape;
  }

  .regular{
    page:  regular;
  }

</style>

<template>
  <div>
    <div class="regular">
      <!-- <vue-pdf-embed style="width:210mm" :source="pdf1" /> -->
      PRINTER
    </div>
    <div class="landscape">
     <!--  <vue-pdf-embed @rendered="print" style="width:100mm;" class="landscape-content" :source="pdf2" />   -->
    </div>
  
  </div>
</template>

<script>
import VuePdfEmbed from 'vue-pdf-embed'

// OR THE FOLLOWING IMPORT FOR VUE 2
// import VuePdfEmbed from 'vue-pdf-embed/dist/vue2-pdf-embed'

export default {
  props:{
    pdf1: String,
    pdf2: String
  },
  components: {
    VuePdfEmbed,
  },
  data() {
    return {
      source1: '', //'<PDF_URL>',
      source2: '', //'data:application/pdf;base64,<BASE64_ENCODED_PDF>',
    }
  },
  methods:{ 
    /* print(){
      window.print()
    } */
  },
  mounted(){
      
  }
}
</script>
