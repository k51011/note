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
        this.getWaitingPercentage();
        this.getProgressPercentage();
        this.getCompletionPercentage();
      }) 
    },
    getWaitingPercentage() {
      var count = 0;
      for (var i = 0, j = this.notes.length; i < j; i++) {
        if (this.notes[i].category.color == 'red' || this.notes[i].category.color == 'yellow' || this.notes[i].category.color == 'blue') {
          count++;
        }
      }
      this.waitingPercentage=count/this.notes.length*100;
    },
    getProgressPercentage() {
      var count = 0;
      for (var i = 0, j = this.notes.length; i < j; i++) {
        if (this.notes[i].category.color == 'green') {
          count++;
        }
      }
      this.progressPercentage=count/this.notes.length*100;
    },
    getCompletionPercentage() {
      var count = 0;
      for (var i = 0, j = this.notes.length; i < j; i++) {
        if (this.notes[i].category.color == 'black') {
          count++;
        }
      }
      this.completionPercentage=count/this.notes.length*100;
    }
  },
  
  mounted() {
    this.getNotes()
    
  },
}
</script>


