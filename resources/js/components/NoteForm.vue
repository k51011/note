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
    },
    
		async LocalToS3(img) {
			var startIndex = this.postForm.content.indexOf(img); 
			var endIndex = startIndex + img.length-1;
			const base64 = this.postForm.content.slice(startIndex+5, endIndex); 
			// base64文字列をBlob形式のFileに変換する
			var bin = window.atob(String(base64.replace(/^.*,/, '')));
			var buffer = new Uint8Array(bin.length);
			for (var i = 0; i < bin.length; i++) {
					buffer[i] = bin.charCodeAt(i);
			}
			// Blobを作成
			var blob = new window.Blob([buffer.buffer], {type: 'image/png'});
			
			// Blobをfile形式に変換
			const imgData = new FormData();
			imgData.append('image', blob);
			imgData.append('startIndex', startIndex);
			imgData.append('endIndex', endIndex);
			imgData.append('editorContens', this.postForm.content);
			// awsのパスに変換
			await this.axios.post('/notes/image', imgData).then((res) => {
				this.postForm.content = 
					this.postForm.content.slice(0,startIndex+5) + 
					res.data + 
					this.postForm.content.slice(endIndex, this.postForm.content.length);
			})
		},
  },
  
  watch: {
		'postForm.content': function(val, oldVal){
			var img = val.match(/src="data[^"]*"/);
			if(!img) {
				this.postForm.content = this.postForm.content;
				return;
			}
			this.LocalToS3(img[0])
		}
	},
    
  
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
    height: 350px;
  }
  #editor .quill-editor {
    height: 60%
  }

</style>