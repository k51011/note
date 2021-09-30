<template>
	<div>
  	<el-upload
  		class="avatar-uploader"
  		:action="serverUrl"
  		name="file"
  		:data="imgData"
  		:show-file-list="false"
  		:on-success="uploadSuccess"
  		:on-error="uploadError"
  		:before-upload="beforeUpload"
  		id="quill-upload">
  	</el-upload>
  	<el-row v-loading="quillUpdateImg">
  		<quill-editor
  		v-model="detailContent"
  		ref="myQuillEditor"
  		:options="editorOption"
  		@change="onEditorChange($event)"
  		@ready="onEditorReady($event)"
  		>
  		</quill-editor>
  	</el-row>
	</div>
</template>

<script>
import {quillEditor} from 'vue-quill-editor';
const toolbarOptions = [
	['bold', 'italic', 'underline', 'strike'], // toggled buttons
	['blockquote', 'code-block'],
	
	[{'header': 1}, {'header': 2}], // custom button values
	[{'list': 'ordered'}, {'list': 'bullet'}],
	[{'script': 'sub'}, {'script': 'super'}], // superscript/subscript
	[{'indent': '-1'}, {'indent': '+1'}], // outdent/indent
	[{'direction': 'rtl'}], // text direction
	
	[{'size': ['10px', '12px', '14px', '16px' ,'18px', '20px', '22px', '24px', '26px', '32px', '48px']}], // custom dropdown
	[{'header': [1, 2, 3, 4, 5, 6, false]}],
	
	[{'color': []}, {'background': []}], // dropdown with defaults from theme
	[{'font': []}],
	[{'align': []}],
	['link', 'image'],
	['clean'] // remove formatting button
]

export default {
  props: {
    serverUrl:String,
    imgData:Object
  },
  data(){
    return {
      quillUpdateImg: false,
      detailContent: '',
      editorOption: {
				placeholder: '',
				theme: 'snow', 
				modules: {
				  toolbar: {
				    container: toolbarOptions,
				    handlers: {
				      'image': function (value) {
				        if (value) {
				          document.querySelector('#quill-upload input').click()
				        } else {
				          this.quill.format('image',false);
				        }
				      }
				    }
				  }
				}
      }
      
    }
  },
  methods: {
    beforeUpload(res, file) {
      this.quillUpdateImg = true
    },
    uploadSuccess(res, file) {
      let quill = this.$refs.myQuillEditor.quill
      console.log(res)
      if (res.code == 200 && res.result !== null) {
        let length = quill.getSelection().index;
        quill.insertEmbed(length, 'image', res.result.url)
        quill.setSelection(length + 1)
      } else {
        this.$message.error('アップロードに失敗しました')
      }
      this.quillUpdateImg = false
    },
    uploadError(res, file) {
			this.quillUpdateImg = false
			this.$message.error('アップロードの失敗しました')
		},
		onEditorChange(){},
		onEditorReady(){},
		getContent(value){
			this.detailContent = value
		}
	},
	components:{
	  quillEditor
	},
	watch:{
		detailContent(newVal,oldVal){
			this.$emit('changeContent',newVal)
		}
	}
}
</script>
