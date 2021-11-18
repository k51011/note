<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      NOTES
    </RouterLink>
    <div style="display: flex; justify-content: right;">
      <div class="navbar__menu">
        <button class="button" @click="showForm = ! showForm">
          <i class="icon ion-md-add"></i>
          note作成
        </button>
        <NoteForm v-model="showForm" />
        <button class="button" @click="showForm2 = ! showForm2">
          進捗確認
        </button>
        <Progress v-model="showForm2" />
        <div　v-show="$route.path === '/'">
          <el-dropdown trigger="click">
            <span class="el-dropdown-link">
              <i class="el-icon-s-custom"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item @click.native="logout()">logout</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import NoteForm from './NoteForm.vue'
import Progress from './Progress.vue'
export default {
  name:'Navbar',
  components: {
    NoteForm,
    Progress
  },
  data () {
    return {
      showForm: false,
      showForm2: false
    }
  },
  methods: {
    logout(){
      this.axios.post('logout')
      .then((response)=>{
        this.$router.go()
      })
    }
  }
}
</script>

<style>
  .button {
    margin-right: 10px;
  }
  .el-icon-s-custom {
    font-size: 200%;
  }
</style>