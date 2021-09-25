<template>
  <div v-show="value" class="photo-form" >
    <p class="letter">未着手</p>
    <el-progress :percentage='waitingPercentage' color="red"></el-progress>
    <p class="letter">進行中</p>
    <el-progress :percentage='progressPercentage' color="blue"></el-progress>
    <p class="letter">完了</p>
    <el-progress :percentage='completionPercentage' color="green"></el-progress>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      notes:{},
      waitingPercentage:0,
      progressPercentage:0,
      completionPercentage:0,
    }
  },
  methods: {
    getNotes(){
      this.axios.get('/notes')
      .then((response)=>{
        if(response.status!=200){
          return;
        }
        this.notes=response.data;
        this.getPercentage();
      }) 
    },
    getPercentage() {
      var countWaiting = 0;
      var countProgress = 0;
      var countCompletion = 0;
      
      for (var i = 0, j = this.notes.length; i < j; i++) {
        if (this.notes[i].category.color == 'green') {
          countProgress++;
        }
        else if (this.notes[i].category.color == 'black') {
          countCompletion++;
        }
        else{
          countWaiting++;
        }
      }
      this.waitingPercentage=Math.round(countWaiting/this.notes.length*100);
      this.progressPercentage=Math.round(countProgress/this.notes.length*100);
      this.completionPercentage=Math.round(countCompletion/this.notes.length*100);
    }
  },
  
  mounted() {
    this.getNotes()
  },
}
</script>


