<template>
  <div>
    <!--{{ putForm }}-->
    <form action="/notes/{ id }" method="POST">
      <input type="hidden" name="_method" value="PUT">
      <div v-if="note">
        <div class="title">
            <h2>タイトル</h2>
            <input type="text" name="title" v-model='putForm.title' placeholder="タイトル"/>
        </div>
        <div class="content">
            <h2>内容</h2>
            <div id="editor">
              <quill-editor 
                v-model="putForm.content"
                ref="quillEditor"
                :options="editorOption"
              >
              </quill-editor>
            </div>
        </div>
        <div class="category_id">
            <h2>カテゴリー</h2>
            <el-row v-if="categories">
                <div style="display: flex;">
                    <div v-for='(category,index) in categories'>
                      <el-button name="category_id" @click='button(category.id)' type="danger" plain>{{ category.name }}</el-button>
                    </div>
                </div>
            </el-row>
            <!--<h2>選択中のカテゴリー</h2>-->
            <!--<el-button type="danger" round v-if='selectedCategory'>{{ selectedCategory[0].name }}</el-button>-->
            
        </div>
      
      <!--<el-button type="primary" @click='putNote'>Upload<i class="el-icon-upload el-icon-right"></i></el-button>-->
        <input class="upbutton" type="button" value="Upload" @click='putNote'/>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "NoteEdit",
  props: {
    note: {
      type: Object,
    },
    categories: {
      type: Array
    },
    editorOption: {
      theme: 'snow'
    }
  },
  computed: {
    selectedCategory(){
      if(!this.putForm.category_id){
        return;
      }
      return this.categories.filter(category=>category.id===this.putForm.category_id)
    }
  },
  data(){
    return {
      csrf_token: '',
      putForm: this.note,
    }
  },
  methods: {
    putNote(){
      this.$emit('put-note',this.putForm)
    },
    button(category_id){
      this.putForm.category_id=category_id;
    },
  }
}
</script>

<style>
  .upbutton {
    position: relative;
    top: 50px;
  }
  
  #editor {
    background: #fff;
    border-radius: 4px;
    padding: 20px;
    transition: all 0.2s;
  }
  
  #editor{
    height: 250px;
  }
  #editor .quill-editor {
    height: 60%
  }
</style>