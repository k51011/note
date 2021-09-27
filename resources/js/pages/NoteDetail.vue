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
    <div class="transition">
      <RouterLink :to="`/`">
        <el-button type="text" class="button">一覧</el-button>
      </RouterLink>
      <el-button @click="changeEditStatus" type="text" class="button">
        <template v-if="editStatus">
          詳細
        </template>
        <template v-else>
          編集
        </template>
      </el-button>
    </div>
    <button v-if="!editStatus" class="deletebutton" @click='deleteNote()'><i class="el-icon-delete"></i></button>
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
      
      editorOption: {
        theme: 'snow',
        modules: {
          toolbar:  [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],

            [{ 'header': 1 }, { 'header': 2 }],               // custom button values
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [ 'link', 'image'],          // add's image support
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'font': [] }],
            [{ 'align': [] }],

            ['clean']                                        // remove formatting button
          ]
        },
      }
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
     font-size: 150%;
  }
  
  .transition {
    position: absolute;
    top:100px;
    right:100px;
  }
</style>

