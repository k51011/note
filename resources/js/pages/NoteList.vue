<template>
  <div class="title">
    <el-row>
      <el-col :span="4" v-for="(note, index) in notes" :key="note.id">
        <el-card style='height: 300px; width: 150px;' :body-style="{ padding: '0px' }">
          <img src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" class="image">
          <div style="padding: 14px;">
            <span>{{ note.title }}</span>
            <div class="bottom clearfix">
              <time class="time">作成日:{{ note.created_at }}</time>
              <RouterLink :to="`/notes/${note.id}`">
                <el-button type="text" class="button">開く</el-button>
              </RouterLink>
            </div>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  data(){
    return {
      notes:[],
      
    }
  },
  mounted() {
    this.getNotes()
  },
  methods: {
    getNotes(){
      this.axios.get('/notes')
      .then((response)=>{
        if(response.status!=200){
          return;
        }
        this.notes=response.data;
      }) 
    },
  },
  computed: {
    progressNote(){
      if(!this.notes) {return;}
      return this.notes.filter(note=>note.category.color=='green');
    },
  }
}
</script>

<style>
  .time {
    font-size: 13px;
    color: #999;
  }
  
  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }

  .button {
    padding: 0;
    float: right;
  }

  .image {
    width: 100%;
    display: block;
  }

  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }
  
  .clearfix:after {
      clear: both
  }

</style>
