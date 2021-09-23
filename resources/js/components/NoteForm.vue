<template>
  <div v-show="value" class="photo-form">
    <form action="/notes" method="POST">
        <div class="title">
            <h2>タイトル</h2>
            <input type="text" v-model='postForm.title' placeholder="タイトル"/>
        </div>
        <div class="content">
            <h2>内容</h2>
            
            <div id="editor">
              <quill-editor 
                v-model="postForm.content"
                ref="quillEditor"
                :options="editorOption"
              >
              </quill-editor>
            </div>
            
    
            <!--<textarea v-model='postForm.content' placeholder="内容"></textarea>-->
        </div>
        <div class="category_id">
            <h2>カテゴリー</h2>
            <el-row>
                <div style="display: flex; justify-content: space-around;">
                    <div v-for='(category,index) in categories'>
                      <el-button @click='button(category.id)' type="danger" plain>{{ category.name }}</el-button>
                    </div>
                </div>
            </el-row>
            <!--<h2>選択中のカテゴリー</h2>-->
            <!--<el-button type="danger" v-if='selectedCategory' plain>{{ selectedCategory[0].name }}</el-button>-->

        </div>
        
        <!--<el-button type="primary" @click='postNote'>Upload<i class="el-icon-upload el-icon-right"></i></el-button>-->
        <input class="upbutton" type="button" value="Upload" @click='postNote'/>
    </form>
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
  computed: {
    selectedCategory(){
      if(!this.postForm.category_id){
        return;
      }
      return this.categories.filter(category=>category.id===this.postForm.category_id)
    }
  },
  data(){
    return {
      csrf_token: '',
      postForm: {
        title: '',
        content: '',
        category_id: '',
      },
      categories:{},
      
      editorOption: {
        theme: 'snow'
      }
      
    }
  },
  
  mounted() {
    this.getCategories()
  },
  methods: {
    getCategories(){
      this.axios.get('/categories')
      .then((response)=>{
        if(response.status!=200){
          return;
        }
        this.categories=response.data;
      }) 
      
    },
    postNote(){
      this.axios.post('/notes',this.postForm)
      .then((response)=>{
        if(response.status!=200){
          this.$message('false')
          return;
        }
        this.$message('success')
        this.$router.go()
      })
    },
    button(category_id){
      this.postForm.category_id=category_id;
    }
  }
}
</script>

<style>
  .upbutton {
    margin-top: 13px;
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