<template>
  <div v-if="notes.length!=0">
    <div v-show="value" class="photo-form" >
      <p class="letter">緊急:高</p>
      <el-progress :percentage='highPercentage' color="red"></el-progress>
      <p class="letter">緊急:中</p>
      <el-progress :percentage='middlePercentage' color="yellow"></el-progress>
      <p class="letter">緊急:低</p>
      <el-progress :percentage='lowPercentage' color="blue"></el-progress>
      <p class="letter">進行中</p>
      <el-progress :percentage='progressPercentage' color="green"></el-progress>
      <p class="letter">完了</p>
      <el-progress :percentage='completionPercentage' color="black"></el-progress>
    </div>
  </div>
  <div v-else>
      <div v-show="value" class="photo-form" >
        <p class="letter">ノートを作成してください</p>
    </div> 
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
      highPercentage:0,
      middlePercentage:0,
      lowPercentage:0,
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
      var countHigh = 0;
      var countMiddle = 0;
      var countLow = 0;
      var countProgress = 0;
      var countCompletion = 0;
      
      for (var i = 0, j = this.notes.length; i < j; i++) {
        if (this.notes[i].category.color == 'red') {
          countHigh++;
        }
        else if (this.notes[i].category.color == 'yellow') {
          countMiddle++;
        }
        else if (this.notes[i].category.color == 'blue') {
          countLow++;
        }
        else if (this.notes[i].category.color == 'green') {
          countProgress++;
        }
        else{
          countCompletion++;
        }
      }
      this.highPercentage=Math.round(countHigh/this.notes.length*100);
      this.middlePercentage=Math.round(countMiddle/this.notes.length*100);
      this.lowPercentage=Math.round(countLow/this.notes.length*100);
      this.progressPercentage=Math.round(countProgress/this.notes.length*100);
      this.completionPercentage=Math.round(countCompletion/this.notes.length*100);
    }
  },
  
  mounted() {
    this.getNotes()
  },
}
</script>


