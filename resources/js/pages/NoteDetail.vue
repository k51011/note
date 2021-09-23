<template>
  <div>
  
  <div v-if="!editStatus && note">
    <h1>{{ note.title }}</h1>
    <div id="preview" class="content ql-editor" v-html="note.content"></div>
  </div>
  <div v-else>
    <note-edit 
      :note = "note"
      :categories = "categories"
      :editorOption = "editorOption"
      @put-note="putNote"
    >
      
    </note-edit>
  </div>
    <RouterLink :to="`/`">
      <el-button type="text" class="button">一覧</el-button>
    </RouterLink>
    <!--<RouterLink :to="`/notes/${note.id}/edit`">-->
    <!--  <el-button @click="changeEditStatus" type="text" class="button">編集</el-button>-->
    <el-button @click="changeEditStatus" type="text" class="button">
      <template v-if="editStatus">
        詳細
      </template>
      <template v-else>
        編集
      </template>
    </el-button>
    <!--</RouterLink>-->
    <!--<form action="/notes/{ id }" method="POST">-->
      <!--<input type="hidden" name="_method" value="DELETE">-->
    
    <button v-if="!editStatus" class="deletebutton" @click='deleteNote()'>削除</button>
    <!--<el-button class="deletebutton" @click='deleteNote()' type="primary" icon="el-icon-delete"></el-button>-->
    <!--</form>-->
  </div>
</template>


<script>
import NoteEdit from "./NoteEdit"
export default {
  components: {
    NoteEdit
  },
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      note: null,
      fullWidth: false,
      editStatus: false,
      categories: [],
      editorOption: {}
    }
  },
  methods: {
    async fetchNote () {
      const response = await this.axios.get(`/api/notes/${this.id}`)
      this.note = response.data
    },
    deleteNote(){
      'use strict';
      if(confirm('削除すると復元できません。\n本当に削除しますか？')) {
        this.axios.delete(`/notes/${this.note.id}`)
        .then((response)=>{
          if(response.status!=200){
            this.$message('false')
            return;
          }
          this.$message('success')
          window.location.href = "/";
        })
      }
    },
    changeEditStatus(){
      this.editStatus=!this.editStatus;
    },
    getCategories(){
      this.axios.get('/categories')
      .then((response)=>{
        if(response.status!=200){
          return;
        }
        this.categories=response.data;
      })
    },
    putNote(putForm){
      this.axios.put(`/notes/${this.note.id}`,putForm)
      .then((response)=>{
        if(response.status!=200){
          this.$message('false')
          return;
        }
        this.$message('success')
        this.changeEditStatus();
        this.$router.go()
      })
    },
  },
  mounted() {
    this.getCategories();
    this.fetchNote();
  },

  
}
</script>

<style>
  .deletebutton {
     margin-top: 100px;
     /*font-size: 50%;*/
  }
</style>

