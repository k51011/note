<template>
  <div class="title">
    <el-container style="height: 800px; border: 0px solid #eee">
      <el-aside width="200px" style="background-color: rgb(255,255,255)">
        <el-menu>
          <el-submenu index="1">
            <template slot="title"><i class="el-icon-menu"></i>選択表示</template>
            <el-menu-item-group>
              <RouterLink :to="`/`">
                <el-menu-item index="1-0">全て</el-menu-item>
              </RouterLink>
              <RouterLink :to="'/high'">
                <el-menu-item index="1-1">緊急:高</el-menu-item>
              </RouterLink>
              <RouterLink :to="'/middle'">
                <el-menu-item index="1-2">緊急:中</el-menu-item>
              </RouterLink>
              <RouterLink :to="'/low'">
                <el-menu-item index="1-3">緊急:低</el-menu-item>
              </RouterLink>
              <RouterLink :to="'/progress'">
                <el-menu-item index="1-4">進行中</el-menu-item>
              </RouterLink>
              <RouterLink :to="'/completion'">
                <el-menu-item index="1-5">完了</el-menu-item>
              </RouterLink>
              <RouterLink :to="'/favorite'">
                <el-menu-item index="1-6">お気に入り</el-menu-item>
              </RouterLink>
            </el-menu-item-group>
          </el-submenu>
          
          <el-submenu index="2">
            <template slot="title"><i class="el-icon-menu"></i>並び替え</template>
            <el-menu-item-group>
              <el-menu-item index="2-1" @click="sort(0)">作成日順（降順）</el-menu-item>
              <el-menu-item index="2-2" @click="sort(1)">作成日順（昇順）</el-menu-item>
              <el-menu-item index="2-3" @click="sort(2)">更新日順（降順）</el-menu-item>
              <el-menu-item index="2-4" @click="sort(3)">更新日順（昇順）</el-menu-item>
            </el-menu-item-group>
          </el-submenu>
          
        </el-menu>
      </el-aside>
  
      <div>
        <el-row>
          <el-col :span="4" v-for="(note, index) in notes" :key="note.id">
            <el-card style='height: 300px;' :body-style="{ padding: '0px' }">
              <img src="images/images-note.png" class="image" style="border:solid 2px blue">
              <div style="padding: 14px;">
                <span>{{ note.title }}</span>
                <div class="bottom clearfix">
                  <time class="time">作成日:{{ note.created_at }}</time>
                  <div class="good">
                    <RouterLink :to="`/notes/${note.id}`">
                      <el-button type="text" class="button">開く</el-button>
                    </RouterLink>
                    <div v-if="note.isLiked === false">
                      <el-button size="mini" @click.prevent="favorite(note.id)">いいね</el-button>
                    </div>
                    <div v-else>
                      <el-button type="danger" size="mini" @click.prevent="favorite(note.id)">解除</el-button>
                    </div>
                  </div>
                </div>
              </div>
            </el-card>
          </el-col>
        </el-row>
      </div>
    </el-container>  
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
      this.axios.get('/notes/low')
      .then((response)=>{
        if(response.status!=200){
          return;
        }
        this.notes=response.data;
      }) 
    },
    favorite(note_id) {
      const id = note_id
      const array = ["/notes/",id,"/favorites"];
      const path = array.join('')
      this.axios.post(path)
      .then(res => {
        this.getNotes()
      }).catch(function(err) {
        console.log(err)
      })
    },
    sort(index){
      switch(index) {
      case 0:
        this.notes.sort(function(a,b){
          if(a.created_at > b.created_at) return -1;
          if(a.created_at < b.created_at) return 1;
          return 0;
        });
        break;
      case 1:
        this.notes.sort(function(a,b){
          if(a.created_at < b.created_at) return -1;
          if(a.created_at > b.created_at) return 1;
          return 0;
        });
        break;
      case 2:
        this.notes.sort(function(a,b){
          if(a.updated_at > b.updated_at) return -1;
          if(a.updated_at < b.updated_at) return 1;
          return 0;
        });
        break;
      case 3:
        this.notes.sort(function(a,b){
          if(a.updated_at < b.updated_at) return -1;
          if(a.updated_at > b.updated_at) return 1;
          return 0;
        });
        break;
      default:
      }
    }
  },
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
  
  .good {
    margin-top: 13px;
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
  
  .el-aside {
    color: #333;
  }

</style>