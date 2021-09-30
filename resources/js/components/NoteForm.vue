<template>
  <div v-show="value" class="photo-form">
    {{ postForm.content }}
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
            
            
            <!--<Editor -->
            <!--  v-model="postForm.content"-->
            <!--  :serverUrl="imgUrl" -->
            <!--  :imgData="imgData" -->
            <!--  :msg="postForm.content" -->
            <!--  @changeContent="changeContent" -->
            <!--  ref="editor"-->
            <!--  >-->
                
            <!--</Editor>-->
            
            
    
            <!--<textarea v-model='postForm.content' placeholder="内容"></textarea>-->
        </div>
        <div class="category_id">
            <h2>カテゴリー</h2>
            <el-row>
                <div style="display: flex; justify-content: space-around;">
                    <div v-for='(category,index) in categories'>
                      <div v-if="category.color=='red'">
                        <el-button @click='button(category.id)' type="danger" plain>{{ category.name }}</el-button>
                      </div>
                      <div v-else-if="category.color=='yellow'">
                        <el-button @click='button(category.id)' type="warning" plain>{{ category.name }}</el-button>
                      </div>
                      <div v-else-if="category.color=='blue'">
                        <el-button @click='button(category.id)' type="primary" plain>{{ category.name }}</el-button>
                      </div>
                      <div v-else-if="category.color=='green'">
                        <el-button @click='button(category.id)' type="success" plain>{{ category.name }}</el-button>
                      </div>
                      <div v-else>
                        <el-button @click='button(category.id)' type="info" plain>{{ category.name }}</el-button>
                      </div>
                    </div>
                </div>
            </el-row>
            <!--<h2>選択中のカテゴリー</h2>-->
            <!--<el-button type="danger" v-if='selectedCategory' plain>{{ selectedCategory[0].name }}</el-button>-->

        </div>
        
        <!--<el-button type="primary" @click='postNote'>Upload<i class="el-icon-upload el-icon-right"></i></el-button>-->
        <!--<input class="upbutton" type="button" value="Upload" @click='postNote'/>-->
        <el-button class="upbutton" type="primary" value="Upload" size="small" @click='postNote'>Upload<i class="el-icon-upload el-icon-right"></i></el-button>
    </form>
  </div>
</template>

<script>
// import Editor from './Editor';

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
    },
    
    
    // data(){
    //   content:""
    // },
    // imgUrl(){
    //   return this.SERVER_PATH+"dapp/backmgr/dapp/open/uploadImg"; 
    // },
    // imgData(){
    //     return {type:'img',token:this.token} 
    // },
  
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
  

    
    // changeContent(value){
    //   this.content = value;
    // },
    
    
    
		// async LocalToS3(img) {
		// 	var startIndex = this.postForm.content.indexOf(img); 
		// 	var endIndex = startIndex + img.length-1;
		// 	const base64 = this.postForm.content.slice(startIndex+5, endIndex); 
		// 	// base64文字列をBlob形式のFileに変換する
		// 	var bin = window.atob(String(base64.replace(/^.*,/, '')));
		// 	var buffer = new Uint8Array(bin.length);
		// 	for (var i = 0; i < bin.length; i++) {
		// 			buffer[i] = bin.charCodeAt(i);
		// 	}
		// 	// Blobを作成
		// 	var blob = new window.Blob([buffer.buffer], {type: 'image/png'});
			
		// 	// Blobをfile形式に変換
		// 	const imgData = new FormData();
		// 	imgData.append('image', blob);
		// 	imgData.append('startIndex', startIndex);
		// 	imgData.append('endIndex', endIndex);
		// 	imgData.append('editorContens', this.postForm.content);
		// 	// awsのパスに変換
		// 	await this.axios.post('/notes/image', imgData).then((res) => {
		// 		this.postForm.content = 
		// 			this.postForm.content.slice(0,startIndex+5) + 
		// 			res.data + 
		// 			this.postForm.content.slice(endIndex, this.postForm.content.length);
		// 	})
		// },
  // },
  
  
  
  // watch: {
		// 'postForm.content': function(val, oldVal){
		// 	var img = val.match(/src="data[^"]*"/);
		// 	if(!img) {
		// 		this.postForm.content = this.postForm.content;
		// 		return;
		// 	}
		// 	this.LocalToS3(img[0])
		// }
  // }
  	
//   getBase64 (file) {
//       return new Promise((resolve, reject) => {
//         const reader = new FileReader()
//         reader.readAsDataURL(file)
//         reader.onload = () => resolve(reader.result)
//         reader.onerror = error => reject(error)
//       })
//     },
		
// 	},
//   watch: {
// 		'postForm.content': function(newVal,oldVal){
// 			var img = newVal.match(/src="data[^"]*"/);
// 			if(!img) {
// 				this.postForm.content = this.postForm.content;
// 				return;
// 			}
// 			var formData = new FormData();
// 			this.getBase64(img[0])
// 			formData.append("img",this.img);
// 			this.axios.post('/notes/image', formData).then((res) => {
// 				this.postForm.content = this.postFrom.content + res.data
// 			})
// 		}
// 	},
  
  
//   components:{
//     Editor
//   },
//   watch:{
//   content(newVal,oldVal){
//       this.$refs.editor.getContent(newVal);
//     }
//   }
//     async postImage(image) {
// 			const config = {
//         header: {
//           "Content-Type": "multipart/form-data"
//         }
//       };
// 			var formData = new FormData();
// 			formData.append("image",image);
// 			await this.axios.post('/notes/image', formData, config).then((res) => {
// 			  console.log(res.data);
// 				this.postForm.content = this.postFrom.content + res.data
// 			})
// 		},

  
  
//   },
//   watch: {
// 		'postForm.content': function(newVal,oldVal){
// 			var image = newVal.match(/src="data[^"]*"/);
// 			if(!image) {
// 				this.postForm.content = this.postForm.content;
// 				return;
// 			}
// 			this.postImage(image[0]);
// 		}
// 	},
  
  
  
  
  
  
//   watch: {
// 		'postForm.content': function(newVal,oldVal){
// 			var image = newVal.match(/src="data[^"]*"/);
// 			if(!image) {
// 				this.postForm.content = this.postForm.content;
// 				return;
// 			}
// 			const config = {
//         header: {
//           "Content-Type": "multipart/form-data"
//         }
//       };
// 			var formData = new FormData();
// 			formData.append("image",this.image);
// 			this.axios.post('/notes/image', formData, config).then((res) => {
// 				this.postForm.content = this.postFrom.content + res.data
// 			})
// 		}
// 	},
  
    
    
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
    height: 350px;
  }
  #editor .quill-editor {
    height: 60%
  }

</style>